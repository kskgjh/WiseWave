<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\FeatureItem;
use App\Models\ProductFeature;
use Database\Factories\ProductFactory;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function all(){
        return Feature::with('items')->with('products')->get();
    }

    public function validateItems(Request $req){
        $amount = $req->amount;
        $validate = true;
        for($i = 0; $i < $amount; $i++){
            $itemName = "item_{$i}";
            $item = $req->$itemName;

            if(empty($item)) $validate = false;
        }

        return $validate;
    }

    public function add(Request $req){
        $messages = [
            'title.required'=> 'Por favor insira o título da característica.',
            'title.unique'=> 'Essa característica já existe.',
            'text.required'=> 'Por favor insira a descrição.',
        ];

        if($req->type == 'text'){
            $rules = [
                'title'=> ['required', 'unique:features,title'], 
                'text'=> 'required'
            ];
            if($req->validate($rules, $messages)){
                $feature = new Feature([
                    'title'=> $req->title,
                    'type'=> $req->type,
                    'text'=> $req->text
                ]);
                if($feature->save()) return redirect()->to('/admin#features')->with('featurePost', 'Característica adicionada com sucesso');



            }
        }

        if($req->type == 'items'){
            $rules = [
                'title'=> ['required', 'unique:features,title']
            ];
            if($req->validate($rules, $messages) && $this->validateItems($req)){
                $feature = new Feature([
                    'title'=> $req->title,
                    'type'=> $req->type,

                ]);
                $feature->save();

                $amount = $req->amount;
                for($i = 0; $i < $amount; $i++){
                    $itemName = "item_{$i}";
                    $itemText = $req->$itemName;

                    $item = new FeatureItem([
                        'item'=> $itemText,
                        'feature_id'=> $feature->id
                    ]);
                    $item->save();
                }   

                return redirect()->to('/admin#features')->with('featurePost', 'Característica adicionada com sucesso');
            }
        }
        return redirect()->to('/admin#features')->with('featurePost', 'Característica não foi adicionada com sucesso. Tente novamente mais tarde.');
    }

    public function addFeatureToProduct(Request $req){
        $verification = ProductFeature::where('product_id', $req->product)->where('feature_id', $req->feature)->get();
        
        if(count($verification) > 0) return redirect()->to('/admin#features')->with('feature','Este produto já possui essa característica!');

        $productFeature = new ProductFeature([
            'product_id'=> $req->product,
            'feature_id'=> $req->feature
        ]);
        if($productFeature->save()) return redirect()->to('/admin#features')->with('feature', "Característica adicionada com sucesso!");
    }
}
