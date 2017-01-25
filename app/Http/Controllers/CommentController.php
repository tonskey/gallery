<?php

namespace App\Http\Controllers;
use App\Faker\Factory as Faker;
use App\Category;
use Validator;
use App\Tag;
use App\TagItem;
use App\Item;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getapprover(){
        $comment=Comment::where('approver',true)
            ->orderBy('created_at','desc')
            ->get();
        return view('approvercom',['comment'=>$comment]);
    }
}