<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'email', 'phone', 'address_line_1', 'address_line_2', 'landmark', 'country',
        'state', 'city', 'city_name', 'pin_code', 'gst_no', 'company_logo'
    ];
}
