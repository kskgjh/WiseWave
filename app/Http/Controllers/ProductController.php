<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\productImg;
use App\Models\Product;
use App\Models\Variant;
use App\Models\variantOptions;
use App\Models\Volume;

class ProductController extends Controller
{

    public function render(Request $req){
        $product = Product::with('productImgs')
                            ->with('variants')
                            ->with('category')
                            ->find($req->id);
        if($product->variant_id) {
        $variantOptions = variantOptions::where('variant_id', $product->variant_id) 
                                        ->get();
        }
        return view('site.productPage', ['product'=> $product, 
                                        'variantOptions'=> $variantOptions]);
    }

    public function getPage($previous){
        $page = strpos($previous, '?')? false : $page = 1;

        if(!$page) {
            $params = parse_url($previous)['query'];
            parse_str($params, $query);
            $page = $query['page'];
        }

        return $page;
    }

    function makeBackUrl($page, $product = null){
        if($product){
        return "/admin?page={$page}&product={$product}";
        }

        return "/admin?page={$page}";

    }

    public function find(Request $req){
        $product = Product::with('productImgs')
                            ->with('variants')
                            ->with('category')
                            ->with('volumes')
                            ->find($req->id);
        return $product;
    }

    public function all(Request $req){
        if($req->order){
            $products = Product::with('productImgs')
                        ->with('volumes')
                        ->orderBy($req->order, 'desc')->paginate(20);
        } else {
            $products = Product::with('productImgs')
                        ->with('volumes')
                        ->paginate(20);
        }

        return $products;
    }
    
    public function delete(Request $req){
        Product::destroy($req->id);

        $imgs = productImg::get()->where('product_id', $req->id);

        foreach($imgs as $img) {
            $img->delete();
            Storage::delete("imgs/product/$img->name");
        }
        return redirect()->to('/admin#products');
    }

    public function add(ProductRequest $req){
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
            'variant_id'=> $variant,
            'category_id'=> $req->category_id?? null,
            'price'=> $req->value
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

    public function addVolume(int $id, $width,  $height,  $length, $weight, $amount){
        $volume = new Volume([
            'width'=> $width,
            'height'=> $height,
            'length'=> $length,
            'weight'=> $weight,
            'amount'=>$amount,
            'product_id'=> $id,
        ]);

        $volume->save();
    }

    public function validateVolumes(Request $req){
        $validate = true;
        for($i = 0; $i < $req->volAmount; $i++){
            $width = "width_{$i}";
            $height = "height_{$i}";
            $length = "length_{$i}";
            $weight = "weight_{$i}";
            $amount = "amount_{$i}";

        if(empty($req->$width) || empty($req->$height) || empty($req->$length) || empty($req->$weight) || empty($req->$amount)){
            dd($req->$weight, $req->$width, $req->$length, $req->$height);

            $validate = false;
        }
    }
    return $validate;
    }

    public function update(Request $req){
        $previous = url()->previous();
        $page = $this->getPage($previous);

        $backUrl = $this->makeBackUrl($page, $req->id);

        if($req->volAmount){
            $validate = $this->validateVolumes($req);

            if(!$validate) return redirect()->to('/admin#products')->with('volumes', "Por favor preencha todos os volumes");
            
            for($i = 0; $i < $req->volAmount; $i++){
                $width = "width_{$i}";
                $height = "height_{$i}";
                $length = "length_{$i}";
                $weight = "weight_{$i}";
            $amount = "amount_{$i}";


                $this->addVolume($req->id, $req->$width, $req->$height, $req->$length, $req->$weight, $req->$amount);
            }
        }
        $status = $req->status == 'on'? true : false;
        $product = Product::find($req->id)->update([
            'status'=> $status,
            'price'=> $req->price,
            'text'=> $req->text,
            'amount'=> $req->amount,
            'name'=> $req->name,
            'category_id'=> $req->category_id,
            'variant_id'=> $req->variant_id,
        ]);

        if($product) return redirect()->to($backUrl)->with('productUpdated', "Informações alteradas com sucesso.");

        return redirect()->to($backUrl)->with('productUpdated', 'Não foi possível atualizar as informações, tente novamente mais tarde.');
    }

    public function deleteVol(Request $req){
        $previous = url()->previous();
        $page = $this->getPage($previous);

        $backUrl = $this->makeBackUrl($page, $req->product);

        if(Volume::destroy($req->id)) return redirect()->to($backUrl);

        return redirect()->to($backUrl)->with('volumeDeleteError', 'Não foi possível excluír o volume, por favor tente novamente mais tarde');


    }
} // class
