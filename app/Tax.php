<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
        'user_id', 'tax_name', 'tax_company_name', 'tax_industry', 'tax_zipcode', 'tax_addres_1', 'tax_addres_2', 'tax_reference', 'tax_img'
    ];

    protected $guarded = ['*','id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
