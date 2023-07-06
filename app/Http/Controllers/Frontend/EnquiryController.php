<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index()
    {
        try{
            return view(theme('pages.contact_us'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
