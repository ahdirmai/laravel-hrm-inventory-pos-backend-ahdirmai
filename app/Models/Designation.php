<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = ['name', 'description', 'company_id', 'created_by'];

    // relationships
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
