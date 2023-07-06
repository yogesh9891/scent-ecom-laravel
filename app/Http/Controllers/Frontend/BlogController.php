<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Entities\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        try{
            return view(theme('pages.blog'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function singleBlog()
    {
        try{
            return view(theme('pages.blog-details'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
