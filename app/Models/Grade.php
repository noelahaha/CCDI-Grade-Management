<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';

    protected $fillable = [
        'name',
        'student_id',
        'subject',
        'grade',
        'status',
        'inc_reason',
    ];
}