<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employ extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name','designation','mobile_no','email','date_of_birth','address'];

}