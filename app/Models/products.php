<?php

namespace App\Models;

use App\Models\sections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{

    // firts method

    // protected $fillable = [
    //     'product_name',
    //     'section_id',
    //     'description',
    // ];

    // second method

    protected $guarded = [];

    // one to many relationship
    public function section()
    {
        return $this->belongsTo(sections::class);
    }
}
