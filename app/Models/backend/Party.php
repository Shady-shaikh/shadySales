<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $table = 'party';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'company_id', 'type', 'category', 'group', 'building',
        'street', 'landmark', 'country', 'state', 'city', 'city_name',
        'pin_code', 'gst'
    ];
}
