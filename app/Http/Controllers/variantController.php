<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use App\Models\variantOptions;
use Illuminate\Http\Request;

class variantController extends Controller
{
    public function allVariants(){
        return Variant::with('variantOptions')->get();
    }

    public function getVariant(Request $req){
        return Variant::find($req->id)->with('variantOptions');
    }

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
            $previous = url()->previous();
            $backUrl = "$previous#products";
            
            return redirect()->to($backUrl)->with('sucess', true);
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
}
