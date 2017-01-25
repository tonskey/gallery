<?php

namespace App\Http\Controllers;

use App\Picture;

use Illuminate\Http\Request;

use App\Http\Requests;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Orchestra\Imagine\Facade as Imagine;
use Illuminate\Support\Facades\Storage;
function create_thumbnail($path,$filename,$ext)
{
    $width=150;
    $height=150;
    $mode=ImageInterface::THUMBNAIL_OUTBOUND;
    $size=new Box($width,$height);
    $thumb=Imagine::open("{$path}/${filename}.{$ext}")->thumbnail($size,$mode);
    $destination="{$filename}.thumb.{$ext}";
    $thumb->save("{$path}/{$destination}");
    return "{$path}/{$destination}";
}
class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function _construct()
    {
        $this->middleware('store');
        $this->middleware('destroy');
        $this->middleware('update');
    }
    public function index(Request $r)
    {
        $dir=$r->input('dir','desc');
        // $p=Picture::all();
        return Picture::orderBy('created_at',$dir)->paginate(12);
        // return $dir=='asc'?$p->sortBy('created_at'):$p->sortByDesc('created_at');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|min:3',
            'description'=>'required|min:3'
        ]);
        $p=new Picture;
        $p->title=$request->input('title');
        $p->description=$request->input('title');
        $p->views=0;
        $file=$request->file('img');
        $name=rand(1111,9999).$file->getClientOriginalName();
        $file->move('img',$name);
        $p->thumb='/'.create_thumbnail(
            'img',
            pathinfo($name)['filename'],
            pathinfo($name)['extension']
        );
        $p->picture='/img/'.$name;
        $p->save();
        return $p;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p=Picture::find($id);
        $p->views++;
        $p->save();
        return $p;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'title'=>'required|min:3',
            'description'=>'required|min:3'
        ]);
        $p=Picture::find($id);
        $p->title=$request->input('title');
        $p->description=$request->input('description');
        if($request->input('changeFoto')==='true')
        {
            $file=$request->file('img');
            $name=rand(1111,9999).$file->getClientOriginalName();
            $file->move('img',$name);
            $p->thumb='/'.create_thumbnail(
                'img',
                pathinfo($name)['filename'],
                pathinfo($name)['extension']
            );
            $p->picture='/img/'.$name;
        }
        $p->save();
        return $p;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Picture::destroy($id);
    }
}
