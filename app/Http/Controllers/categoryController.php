<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    public function all(){
        return Category::with('children')->get();
    }

    public function find(Request $req){
        return Category::with('children')->find($req->id);
    }

    public function add(Request $req){
        dd($req);

        $backUrl = "/admin#products";

        $rules = [
            'name'=> ['unique:categories,name', 'required']
        ];
        $messages = [
            'name.required'=> 'Por favor insira o nome a categoria.',
            'name.unique'=> 'Esta categoria ja existe.'
        ];

        $req->validate($rules, $messages);
        
        if($req->type == "child" && !$req->parent_id) $req->type = 'parent';

        $category = new Category([
            'name'=> $req->name,
            'type'=> $req->type
        ]);

        if($req->type == 'child') $category->parent_id = $req->parent_id;

        $category->save();
        return redirect()->to($backUrl)->with('success', 'Categoria salva com sucesso.');
    }

    
}
