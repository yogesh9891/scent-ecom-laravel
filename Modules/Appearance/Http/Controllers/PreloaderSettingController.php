<?php

namespace Modules\Appearance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Appearance\Repositories\PreloaderRepository;
use Modules\UserActivityLog\Traits\LogActivity;
use App\Models\Fragrent;
use App\Models\Review_product;


class PreloaderSettingController extends Controller
{
    protected $preloaderRepo;
    public function __construct(PreloaderRepository $preloaderRepo)
    {
        $this->preloaderRepo = $preloaderRepo;
    }

    public function index(){
        return view('appearance::preloader.index');
    }

    public function update(Request $request){
        $request->validate([
            'preloader_status' => 'required',
            'preloader_type' => 'required'
        ]);

        try{
            $this->preloaderRepo->updatePreloader($request->except('_token'));
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->back();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }

    }

    public function getAll(){
        $getFragments = Fragrent::get();
        return view('appearance::fragment.index' , compact('getFragments'));
    }

    public function delete($id){
        $deleteFragment = Fragrent::find($id);
        $deleteFragment->delete();
        Toastr::success(__('Deleted successfully'), __('success'));
        return redirect()->back();
    }

    public function getAllReview(){
        $getAllReviews = Review_product::get();
        // $getAllReviews = Review_product::with('review')->get();

        // dd($getAllReviews);
        return view('appearance::review_product.index' , compact('getAllReviews'));
    }

    public function deleteReview($id){
        $deleteReview = Review_product::find($id);
        $deleteReview->delete();
        Toastr::success(__('Deleted successfully'), __('success'));
        return redirect()->back();
    }


    public function reviewStatus(Request $request) {
        $id = $request->id;
        $data = Review_product::find($id);
        if ($data->status == 1) {
            $data->status = 0;
        } else {
            $data->status = 1;
        }
        $data->update();
    }
}
