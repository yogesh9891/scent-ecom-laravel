<?php

namespace Modules\Product\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Product\Repositories\GenderRepository;
use App\Traits\ImageStore;
use Modules\Product\Entities\Gender;

class GenderService
{
    use ImageStore;
    protected $genderRepository;

    public function __construct(GenderRepository  $genderRepository)
    {
        $this->genderRepository= $genderRepository;
    }

    public function save($data)
    {
        if (!empty($data['featured'])) {
            $data['featured'] = 1;
        }else {
            $data['featured'] = 0;
        }
        if(isset($data['logo'])){
            $imageName = ImageStore::saveImage($data['logo'],150,150);
            $data['logo'] = $imageName;
        }
        $data['slug'] = strtolower(str_replace(' ','-',$data['name']));
        return $this->genderRepository->create($data);
    }

    public function update($data,$id)
    {
        if (!empty($data['featured'])) {
            $data['featured'] = 1;
        }else {
            $data['featured'] = 0;
        }
        if (!empty($data['logo'])) {
            $gender = Gender::findOrFail($id);
            ImageStore::deleteImage($gender->logo);
            $imageName = ImageStore::saveImage($data['logo'],150,150);
            $data['logo'] = $imageName;
        }
        $data['slug'] = strtolower(str_replace(' ','-',$data['name']));
        return $this->genderRepository->update($data, $id);
    }

    public function getAll()
    {
        return $this->genderRepository->getAll();
    }
    public function getAllCount(){
        return $this->genderRepository->getAllCount();
    }
    public function getActiveAll()
    {
        return $this->genderRepository->getActiveAll();
    }


    public function getBySearch($data)
    {
        return $this->genderRepository->getBySearch($data);
    }

    public function getByPaginate($count)
    {
        return $this->genderRepository->getByPaginate($count);
    }

    public function getBySkipTake($skip, $take)
    {
        return $this->genderRepository->getBySkipTake($skip, $take);
    }

    public function getgenderbySort()
    {
        return $this->genderRepository->getgenderbySort();
    }

    public function deleteById($id)
    {
        $gender = Gender::findOrFail($id);

        if(count($gender->products) < 1){
            ImageStore::deleteImage($gender->logo);
        }
        return $this->genderRepository->delete($id);
    }

    public function findById($id)
    {
        return $this->genderRepository->find($id);
    }

    public function findBySlug($slug)
    {
        return $this->genderRepository->findBySlug($slug);
    }

    public function csvUploadGender($data)
    {
        return $this->genderRepository->csvUploadGender($data);
    }

    public function csvDownloadGender()
    {
        return $this->genderRepository->csvDownloadGender();
    }

    public function getGendersByAjax($search){
        return $this->genderRepository->getGendersByAjax($search);
    }
}
