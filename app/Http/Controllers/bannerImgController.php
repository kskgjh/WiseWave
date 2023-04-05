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
        $image = new bannerImage();
        $image->title = $req->title;
        $image->alt = $req->alt;

        $file = $req->image;

        $imageName = md5(Carbon::now()->timestamp). '.' .$file->extension();
        $file->storeAs('imgs/carroussel', $imageName);
        $image->path = $imageName;

        $image->save();

        return back()->with('message', 'A imagem foi enviada com sucesso');

    }
    public function delete(Request $req){
        $image = bannerImage::find($req->id);
        Storage::delete("assets/imgs/carroussel/$image->path");
        $image->delete();
        return back();
    }
    public function all(){
        return bannerImage::all()->toJson();
    }
}
