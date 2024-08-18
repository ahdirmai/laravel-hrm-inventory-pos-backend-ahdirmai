<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $guarded = [];

    // company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // leave type
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    // created by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // updated by
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
