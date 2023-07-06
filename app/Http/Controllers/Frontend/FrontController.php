<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function login()
    {
        try{
            return view(theme('pages.login'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }

    public function register()
    {
        try{
            return view(theme('pages.register'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
