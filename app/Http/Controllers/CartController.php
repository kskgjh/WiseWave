<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Double;
use Ramsey\Uuid\Type\Decimal;

class CartController extends Controller
{
    public function render(){
        $user = auth()->user();
        $cart = Cart::with('items')->where('user_id', $user->id)->get()->first();
        if(!$cart){
            $cart = $this->createCart($user->id);
        }

        return view('site.cart', ['cart'=> $cart]);       
    }

    public function add(Request $req){
        $price = (float) $req->currentPrice;
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        if(!$cart){
            $cart = $this->createCart($user->id);
        }

        if(!$this->addToCart($cart, $req->amount, $price)) return "erro";

        $item = new CartItem([
            'cart_id'=> $cart->id,
            'product_id'=> $req->product,
            'amount'=> $req->amount,
            'variant_id'=> $req->variant,
            'current_price'=> $req->currentPrice
        ]);

        if($item->save()){
            return redirect()->route('cart.render');
        }

        return back()->with('cart', 'Ocorreu um problema ao adicionar o produto, por favor tente novamente mais tarde!');
    }

    public function createCart(int $id){
        $cart = new Cart(['user_id'=> $id]);
        $cart->save();
        return $cart;
    }

    public function addToCart($cart, int $amount, float $price){
        $currentAmount = $cart->item_amount;
        $currentTotalPrice = $cart->total_price;
        
        $newPrice = $currentTotalPrice + ($price * $amount);
        $newAmount = $currentAmount + $amount;

        $update = $cart->update([
            'item_amount'=> $newAmount,
            'total_price'=> $newPrice
        ]);

        return $update;
    }

    public function deleteItem(Request $req){
        $cart = Cart::find($req->cart_id);
        if($cart->user_id !== auth()->user()->id) return redirect()->route('access.denied');

    }
}
