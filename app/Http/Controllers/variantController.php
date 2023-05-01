<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariantRegisterRequest;
use App\Models\Variant;
use App\Models\variantOptions;
use Illuminate\Http\Request;

class variantController extends Controller
{
    public function all(){
        return Variant::with('variantOptions')->get();
    }

    public function find(Request $req){
        return Variant::with('variantOptions')->find($req->id);
    }

    public function add(VariantRegisterRequest $req){
        $optionsAmount = $req->amount;

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
                $name = "colorName_$i";
                $color = "variantColor_$i";

                $option = new variantOptions([
                    'option'=> $req->$name,
                    'color'=> $req->$color,
                    'variant_id'=> $variant->id
                ]);

                $option->save();

        }
        return redirect()->to('/admin#products')->with('sucess', true);
    }}   
}
