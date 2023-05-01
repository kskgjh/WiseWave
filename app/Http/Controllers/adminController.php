<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index(){
        $categories = Category::with('children')->get();
        $products = Product::paginate(20);
        return view('site.admin.adminPanel', ['products'=> $products]);
    }
}
