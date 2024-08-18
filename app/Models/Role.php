<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'display_name', 'description', 'company_id'];

    // company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
}
