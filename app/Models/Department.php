<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'company_id', 'created_by', 'updated_by', 'description'];

    // company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // created by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
