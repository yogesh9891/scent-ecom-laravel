<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Http\Requests\GenderFormRequest;
use Modules\Product\Services\GenderService;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Product\Http\Requests\UpdateGenderRequest;
use Illuminate\Support\Facades\DB;
use Modules\UserActivityLog\Traits\LogActivity;

class GenderController extends Controller
{

    protected $genderService;

    public function __construct(GenderService $genderService)
    {
        $this->middleware('maintenance_mode');
        $this->genderService = $genderService;
    }

    public function index(Request $request)
    {
        if ($request->input('keyword') != null) {
            $data['genders'] = $this->genderService->getBySearch($request->input('keyword'));
            $data['keyword'] = $request->input('keyword');
        }else {
            $data['genders'] = $this->genderService->getByPaginate(10);
        }
        $data['total_genders'] = $this->genderService->getAllCount();
        return view('product::gender.index', $data);
    }

    public function bulk_gender_upload_page()
    {
        return view('product::gender.bulk_upload');
    }

    public function csv_gender_download()
    {
        try {
            $this->genderService->csvDownloadGender();
            $filePath = storage_path("app/gender_list.xlsx");
        	$headers = ['Content-Type: text/csv'];
        	$fileName = time().'-gender_list.xlsx';

        	return response()->download($filePath, $fileName, $headers);
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'));
            return back();
        }
    }

    public function bulk_gender_store (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048'
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();
        try {
            $this->genderService->csvUploadGender($request->except("_token"));
            DB::commit();
            LogActivity::successLog('Bulk gender store successful.');
            Toastr::success(__('common.uploaded_successfully'),__('common.success'));
            return back();

        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error(__('common.duplicate_entry_is_exist_in_your_file'));
            }
            else {
                Toastr::error(__('common.Something Went Wrong'));
            }
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }


    public function create(Request $request)
    {
        try{
            return view('product::gender.create');
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return redirect()->back();
        }

    }


    public function store(GenderFormRequest $request)
    {

        try {
            $this->genderService->save($request->except("_token"));
            Toastr::success(__('common.created_successfully'),__('common.success'));
            LogActivity::successLog('Gender Added.');

            if(isset($request->form_type)){
                if($request->form_type == 'modal_form'){
                    $genders = $this->genderService->getActiveAll();
                    return view('product::products.components._gender_list_select',compact('genders'));
                }else{
                    return redirect()->route('product.genders.index');
                }
            }else{
                return redirect()->route('product.genders.index');
            }
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function show($id)
    {
        return view('product::show');
    }


    public function edit($id)
    {
        try {
            $data['gender'] = $this->genderService->findById($id);
            return view('product::gender.edit', $data);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }


    public function update(UpdateGenderRequest $request, $id)
    { 
        try {
            $this->genderService->update($request->except("_token"), $id);
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('Gender updated.');
            return redirect()->route('product.gender.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function destroy($id)
    { 
        try {
            $result = $this->genderService->deleteById($id);
            if ($result == "not_possible") {
                 Toastr::warning(__('product.related_data_exist_in_multiple_directory'),__('com◘mon.warning'));
            }
            else {
                LogActivity::successLog('Gender Deleted.');
               Toastr::success(__('common.deleted_successfully'),__('common.success'));
            }
            return redirect()->route('product.genders.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function update_status(Request $request)
    {
        try {
            $gender = $this->genderService->findById($request->id);
            $gender->status = $request->status;
            $gender->save();
            LogActivity::successLog('gender status update successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function update_feature(Request $request)
    {
        try {
            $gender = $this->genderService->findById($request->id);
            $gender->featured = $request->featured;
            $gender->save();
            LogActivity::successLog('feature status update successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function updateOrder(Request $request)
    {
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));

            foreach($arr as $sortOrder => $id){
                $menu = $this->genderService->findById($id);
                $menu->sort_id = $sortOrder;
                $menu->save();
            }

            LogActivity::successLog('order status update successful.');
            return ['success'=>true,'message'=>'Updated'];
        }
    }

    public function sortableUpdate(Request $request)
    {
        $posts = $this->genderService->getAll();

        foreach ($posts as $post) {
            foreach ($request->order as $order) {
                if ($order['id'] == $post->id) {
                    $post->update(['sort_id' => $order['position']]);
                }
            }
        }

        LogActivity::successLog('sortable update successful.');

        return response('Update Successfully.', 200);
    }

    public function load_more_genders(Request $request)
    {
        $skip = $request->skip ?? 0;

        $genders = $this->genderService->getBySkipTake($skip, 10);
        $output = '';
        if (count($genders) > 0) {
            $output = (string)view('product::gender.list',['genders' => $genders]);
        }
        return \response()->json([
            'genders' => $output
        ]);

    }

    public function getGendersByAjax(Request $request){
        return $this->genderService->getGendersByAjax($request->search);
    }
}
