<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['date','board_members_id','amount','remark'];

    public function boardMember()
    {
        return $this->belongsTo(BoardMember::class, 'board_members_id');
    }
}