<?php

namespace Modules\Product\Repositories;

use Modules\Product\Entities\Gender;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Imports\GenderImport;
use Modules\Product\Export\GenderExport;

class GenderRepository
{
    public function getAll()
    {
        return Gender::latest()->get();
    }
    public function getAllCount(){
        return Gender::query()->count();
    }

    public function getActiveAll(){
        return Gender::where('status', 1)->latest()->take(100)->get();
    }

    public function getBySearch($data)
    {
        return Gender::where('name','LIKE','%'.$data.'%')->take(10)->get();
    }

    public function getByPaginate($count)
    {
        return Gender::orderBy('sort_id', 'asc')->take($count)->get();
    }

    public function getBySkipTake($skip, $take)
    {
        return Gender::skip($skip)->take($take)->orderBy('sort_id', 'asc')->get();
    }

    public function getgenderbySort()
    {
        return Gender::orderBy("sort_id","asc")->get();
    }

    public function create(array $data)
    {
        $variant = new Gender();
        $variant->fill($data)->save();
    }

    public function find($id)
    {
        return Gender::find($id);
    }

    public function update(array $data, $id)
    {  
        $variant = Gender::findOrFail($id);
        $variant->update($data);
    }

    public function delete($id)
    {
        $gender = Gender::findOrFail($id);

        if (count($gender->products) > 0 || count($gender->MenuElements) > 0 || count($gender->MenuBottomPanel) > 0 || count($gender->Silders) > 0 ||
         count($gender->homepageCustomGenders) > 0) {
            return "not_possible";
        }
        $gender->delete();
        return 'possible';

    }

    public function getGenderForSpecificCategory($category_id, $category_ids)
    {
        // $gender_list = Gender::whereHas('products', function($q) use($category_id, $category_ids){
        //     return $q->whereHas('categories', function($q2) use ($category_id, $category_ids){
        //         return $q2->whereIn('category_id',$category_ids)->orWhere('category_id',$category_id);
        //     });
        // })->take(20)->get();
        
        // $gender_list = Gender::whereHas('products', function($q) use($category_id, $category_ids){
        //     return $q->whereHas('categories', function($q2) use ($category_id, $category_ids){
        //         return $q2->whereRaw("category_id in ('". implode("','",$category_ids). "')")->orWhere('category_id',$category_id);
        //     });
        // })->take(20)->get();
        
        $gender_list = Gender::select('genders.*')->where('genders.status', 1)->join('products', function($q) use($category_ids, $category_id){
            return $q->on('products.gender_id', '=', 'genders.id')->join('category_product', function($q1) use($category_ids, $category_id){
                return $q1->on('category_product.product_id', '=', 'products.id')->whereRaw("category_product.category_id in('". implode("','",$category_ids). "')");
            });
        })->distinct('genders.id')->take(20)->get();

        

        // $gender_list = gender::whereHas('categories', function($q) use($category_id, $category_ids){
        //     return $q->whereIn('category_id',$category_ids)->orWhere('category_id',$category_id);
        // })->take(20)->get();

        return $gender_list;
    }

    public function findBySlug($slug)
    {
        return Gender::where('slug', $slug)->first();
    }

    public function csvUploadGender($data)
    {
        Excel::import(new GenderImport, $data['file']->store('temp'));
    }

    public function csvDownloadGender()
    {
        if (file_exists(storage_path("app/gender_list.xlsx"))) {
          unlink(storage_path("app/gender_list.xlsx"));
        }
        return Excel::store(new GenderExport, 'gender_list.xlsx');
    }

    public function getGendersByAjax($search){
        if($search == ''){
            $genders = Gender::select('id','name')->where('status',1)->paginate(10);
        }else{
            $genders = Gender::select('id','name')->where('status',1)
                ->where('name', 'LIKE', "%{$search}%")
                ->paginate(10);
        }
        $response = [];
        foreach($genders as $gender){
            $response[]  =[
                'id'    =>$gender->id,
                'text'  =>$gender->name
            ];
        }
        return  $response;
    }
}
