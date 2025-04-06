<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class delivery_reports extends Model
{
    use HasFactory;
    protected $guarded = [];

        protected static function boot()
        {
            parent::boot();
    
            static::creating(function ($report) {
                $report->code = random_int(1000, 9999);
            });
        }

}
