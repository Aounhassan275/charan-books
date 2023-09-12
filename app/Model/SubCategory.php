<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','category_id', 'sub_category_id','status'
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subCategory(){
        return $this->belongsTo(Category::class,'sub_category_id');
    }
}
