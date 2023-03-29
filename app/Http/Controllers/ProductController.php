<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\variantOptions;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\productImg;
use App\Models\Product;
use App\Models\Variant;

class ProductController extends Controller
{
    public function addVariant(Request $req){

        $optionsAmount = $req->amount;

        $variantRules = [
            'title'=> ['required','unique:variants,title'],
        ];
        $errors = [
            'title.required'=> 'Por favor insira um nome para a variante.',
            'title.unique'=> "Esta variante ja existe."
        ];

        $req->validate($variantRules, $errors);

        $variant = new Variant([
            'title'=> $req->title
        ]);


        $variant->save();

        if($req->type == 1){
            for($i = 1; $i<=$optionsAmount; $i++){
                $attr = "variantOption$i";

                $option = new variantOptions([
                    'option'=> $req->$attr,
                    'variant_id'=> $variant->id
                ]);

                $option->save();
        }
            
            return back()->with('sucess', true);
        }

        if($req->type == 2){
            for($i = 1; $i<=$optionsAmount; $i++){
                $name = "colorName$i";
                $color = "variantColor$i";

                $option = new variantOptions([
                    'option'=> $req->$name,
                    'color'=> $req->$color,
                    'variant_id'=> $variant->id
                ]);

                $option->save();



        }
        return back()->with('sucess', true);
        
    }
    }   

    public function delete(Request $req){
        Product::destroy($req->id);

        $imgs = productImg::get()->where('product_id', $req->id);

        foreach($imgs as $img) {
            $img->delete();
            Storage::delete("imgs/product/$img->name");
        }
        return back();
    }

    public function getVariant(Request $req){
        $variant = Variant::find($req->id);

        return $variant;
    }

    public function addCategory(Request $req){
        $rules = [
            'name'=> ['unique:categories,name', 'required']
        ];
        $messages = [
            'name.required'=> 'Por favor insira o nome a categoria.',
            'name.unique'=> 'Esta categoria ja existe.'
        ];

        $req->validate($rules, $messages);


        $category = new Category([
            'name'=> $req->name,
            'type'=> $req->type
        ]);

        if($req->type == 'child') $category->parent_id = $req->parent_id;

        $category->save();
        return back()->with('success', 'Categoria salva com sucesso.');
    }
}
