<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class delivery_reports extends Model
{
    use HasFactory;
    protected $guarded = [];

        // توليد قيمة عشوائية لحقل `code` عند إنشاء سجل جديد
        protected static function boot()
        {
            parent::boot();
    
            static::creating(function ($report) {
                $report->code = random_int(1000, 9999); // توليد رقم عشوائي بين 1000 و 9999
            });
        }

}
