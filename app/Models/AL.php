<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AL extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'a_l_s';

    // protected $table = "a_l_s";
    // protected $fillable = [
    //     'product_Id',
    //     'Manger_Id',
    //     'counter',
    //     'total_price',
    //     'catagories_Id'
    // ];
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_Id');
    // }
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'Manger_Id');
    // }
    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'catagories_Id');
    // }
}
