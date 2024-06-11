<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionAssign extends Model
{
    use HasFactory;

    protected $table = 'roles_permissions';
    protected $fillable = [
        'role_id', // Add 'role_id' to the fillable array
        'permission_id',
        // Add any other fields you want to allow for mass assignment here
    ];

}
