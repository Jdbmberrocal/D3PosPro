<?php

namespace Modules\InventoryManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use App\BusinessLocation as branch;

class Inventory extends Model
{
    protected $table = "inventory";
    protected $primaryKey = "id";
    protected $fillable = ["branch_id", "created_at" , "end_date" , "status"];

    public function branch(){
        return $this->belongsTo(branch::class , "branch_id");
    }

    public function products(){
        return $this->belongsToMany(\App\Product::class , "inventory_products")->distinct()
            ->withPivot(["amount_after_inventory",'id','inventory_type','qty_before','Amount_difference','transaction_id','variation_id']);
    }

    public function scopeBusiness($query){
        // $currentBussiness = ;

        return $query->with(['branch'=>
        function ($q){
            $q->where('business_id', request()->session()->get('user.business_id'));
        }
            
            ])->whereHas('branch',function ($q){$q->where('business_id', request()->session()->get('user.business_id'));});
    }
}
