<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicSalary extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = ['user_id', 'company_id', 'amount'];

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
