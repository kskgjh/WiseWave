<?php

namespace App\Http\Controllers;

use App\Http\Requests\bannerImgRequest;
use App\Models\bannerImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class bannerImgController extends Controller
{
    public function save(bannerImgRequest $req){
        $previous = url()->previous();
        $backUrl = "$previous#carrossel";
        
        $image = new bannerImage();
        $image->title = $req->title;
        $image->alt = $req->alt;

        $file = $req->image;

        $imageName = md5(Carbon::now()->timestamp). '.' .$file->extension();
        $file->storeAs('imgs/carroussel', $imageName);
        $image->path = $imageName;

        $image->save();

        return redirect()->to($backUrl)->with('message', 'A imagem foi enviada com sucesso');

    }
    public function delete(Request $req){
        $previous = url()->previous();
        $backUrl = "$previous#carrossel";

        $image = bannerImage::find($req->id);
        Storage::delete("assets/imgs/carroussel/$image->path");
        $image->delete();
        return redirect()->to($backUrl);
    }
    public function all(){
        return bannerImage::all()->toJson();
    }
}
