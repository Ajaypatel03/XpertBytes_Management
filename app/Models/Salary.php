<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['date','employ_id','salary','remark'];

    public function employ()
    {
        return $this->belongsTo(Employ::class, 'employ_id');
    }
}