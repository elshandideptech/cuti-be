<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTakeLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_employee',
        'id_leave',
        'start_date',
        'end_date'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class, 'id_employee');
    }

    public function leave(){
        return $this->belongsTo(Leave::class, 'id_leave');
    }
}
