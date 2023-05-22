<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\productImg;
use App\Models\Product;
use App\Models\variantOptions;
use App\Models\Volume;
use Illuminate\Support\Fluent;
use Ramsey\Uuid\Type\Decimal;

class ProductController extends Controller
{

    public function render(Request $req){
        $product = $this->find($req);
        $featureList = [];
        
        if($product->variant_id) {
        $variantOptions = variantOptions::where('variant_id', $product->variant_id) 
                                        ->get();
        }
        if($product->features){
            foreach($product->features as $feature){
                $featureList[] = Feature::with('items')->find($feature->feature_id);
            }
        }
        return view('site.productPage', ['product'=> $product, 
                                        'variantOptions'=> $variantOptions,
                                        'features'=> $featureList]);
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
                            ->with('features')
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
        if($req->variant == 'null'){
            $variant = null;
        } else{
            $variant = $req->variant;
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
            $imgDone->path = $imageName;
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
        $price = (float) str_replace(',', '.', str_replace('.', '', $req->price));
        $status = $req->status == 'on'? true : false;
        $product = Product::find($req->id)->update([
            'status'=> $status,
            'price'=> $price,
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

    public function search(Request $req){
        $filters = new Fluent([
            'orderby'=> null,
            'category_id'=> null,
            'max_value'=> null,
            'min_value'=> null,
            'searchText'=> null,
        ]);
        $categories = Category::with('children')->get();
        
        if($req->method() == 'GET'){
            $products = Product::with('productImgs')->paginate(20);
        }

        if($req->method() == 'POST'){
            
            switch($req->orderby){
                case ('popularity'):
                    $orderby = 'sales';
                    $order = 'desc';
                break;
                case ('lowerPrice'):
                    $orderby = 'price';
                    $order = 'asc';
                break;
                case ('biggerPrice'):
                    $orderby = 'price';
                    $order = 'desc';
                break;
                case ('newer'):
                    $orderby = 'created_at';
                    $order = 'asc';
                break;
                default: 
                    $orderby = null;
                    $order = null;
                break;
            }

            
            $min = (int) $req->min_value;
            $max = (int) $req->max_value;
            $query = Product::query();

            if($min && $max && $min > $max){
                return back()->with('price', 'O valor mínimo não pode ser maior que o valor máximo!');
            }

            if($orderby){
                $filters->orderby = $req->orderby;
                $query->orderBy($orderby, $order);
            }
            if($req->category_id){
                $filters->category_id = $req->category_id;
                $query->where('category_id', $req->category_id);
            }
            if($min !== 0){
                $filters->min_value = $min;
                $query->where('price', '>=', $min);
            }
            if($max !== 0){
                $filters->max_value = $max;
                $query->where('price', '<=', $max);
            }
            if($req->searchText){
                $filters->searchText = $req->searchText;
            }

            $products = $query->with('productImgs')->paginate(20);

            
        }

        return view('site.search', 
        ['products'=> $products, 'categories'=> $categories, 'filters'=> $filters]);

    }
    
} // class
