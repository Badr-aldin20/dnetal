<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use HasFactory;
    protected $guarded = [];
    use SoftDeletes;
    // protected $fillable=[
    //     'titel','des','user_id',
    // ];
}
