<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_language',
        'id_parent',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'gender',
    ];

    public function leaves(){
        return $this->hasMany(EmployeeTakeLeave::class, 'id_employee');
    }
    public function language(){
        return $this->belongsTo(Language::class, 'id_language');
    }
}
