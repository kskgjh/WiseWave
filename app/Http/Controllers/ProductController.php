<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\productImg;
use App\Models\Product;
use App\Models\Variant;

class ProductController extends Controller
{

    public function all(){
        return Product::with('productImgs')->paginate(20);
    }
    
    public function delete(Request $req){
        if(!$req->idArr){
            Product::destroy($req->id);

            $imgs = productImg::get()->where('product_id', $req->id);

            foreach($imgs as $img) {
                $img->delete();
                Storage::delete("imgs/product/$img->name");
            }
            return redirect()->to('http://localhost:8000/admin#products');
        }
    }

    public function addProduct(ProductRequest $req){
        if($req->variant !== 'null'){
            $variant = Variant::where('title', $req->variant)->first()->id;
        } 
        else {
            $variant = null;
        }

        $status = $req->status == 'on'? true : false;

        $product = new Product([
            'name'=> $req->name,
            'status'=> $status,
            'text'=> $req->text,
            'amount'=> $req->amount,
            'variants_id'=> $variant
        ]);

        $product->save();

        $imagesReq = $req->images;

        foreach($imagesReq as $image){
            $imgDone = new productImg;
            $imageName = uniqid().Carbon::now()->timestamp. '.' .$image->extension();
            $imgDone->name = $imageName;
            $imgDone->product_id = $product->id;
            $image->storeAs('imgs/product', $imageName);
            $imgDone->save();
        }

        return redirect()
                    ->to('/admin#products')
                    ->with('productCreated', "Produto cadastrado com sucesso!");
    }


}
