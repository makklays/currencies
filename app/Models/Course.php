<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    public $timestamps = false;

    protected $fillabel = [
        'id',
        'send_currency',
        'recive_currency',
        'send_course',
        'recive_course',
        'created_at',
    ];
}
