<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\FrontendCMS\Entities\HomepageCustomGender;
use Modules\Menu\Entities\MegaMenuBottomPanel;
use Modules\Menu\Entities\MenuElement;
use Modules\Seller\Entities\SellerProduct;

class Gender extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    protected $table = "genders";
    protected $guarded = ["id"];

    public static function boot()
    {
        parent::boot();
        static::created(function ($gender) {
            $gender->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($gender) {
            $gender->updated_by = Auth::user()->id ?? null;
        });

        self::created(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::updated(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::deleted(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
    }


    public function products(){
        return $this->hasMany(Product::class,'gender_id','id');
    }

    public function sellerProductsAll(){
        return SellerProduct::where('status',1)->whereHas('product',function($query){
            return $query->where('gender_id',$this->id);
        })->activeSeller()->get();

    }
    public function sellerProducts(){
        return $this->hasManyThrough(SellerProduct::class, Product::class)->activeSeller();
    }

    public function categories(){
        return $this->hasManyDeep(Category::class, 
        [
            Product::class,
            CategoryProduct::class
        ],
        [
            'gender_id', // Foreign key on the "users" table.
            'category_id',     // Foreign key on the "comments" table.
            'id'    // Foreign key on the "posts" table.
        ],
        [  
            'id',               // Local key on "tool_groups" table
            'gender_id',                // Local key on "tools" table
            'category_id',          // Local key on pivot table
        ]
        );
    }
    
    public function getMenuElementsAttribute(){
        return MenuElement::where('type', 'gender')->where('element_id', $this->id)->get();
    }

    public function MenuBottomPanel(){
        return $this->hasMany(MegaMenuBottomPanel::class,'gender_id', 'id');
    }

    public function getSildersAttribute(){
        return HeaderSliderPanel::where('data_type','gender')->where('data_id', $this->id)->get();
    }

    public function homepageCustomGenders(){
        return $this->hasMany(HomepageCustomGender::class, 'gender_id', 'id');
    }

    //for api
    public function getAllProductsAttribute(){
        return SellerProduct::with('product')->whereHas('product', function($query){
            return $query->where('gender_id', $this->id);
        })->activeSeller()->paginate(10);
    }
    
    protected static function factory(){
        return \Modules\Product\Database\factories\GenderFactory::new();
    }
}
