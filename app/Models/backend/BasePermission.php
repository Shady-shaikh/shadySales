<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasePermission extends Model
{
    use HasFactory;

    protected $table = 'base_permissions';
    protected $primaryKey = 'base_permission_id';

    protected $fillable = ['base_permission_name', 'guard_name',];

}
