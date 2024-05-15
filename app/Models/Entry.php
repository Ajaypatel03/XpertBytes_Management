<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['date', 'management_id', 'type_of_entry', 'amount', 'remark'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'type_of_entry')->withDefault();
    }

    public function employ()
    {
        return $this->belongsTo(Employ::class, 'type_of_entry')->withDefault();
    }

    public function boardMember()
    {
        return $this->belongsTo(BoardMember::class, 'type_of_entry')->withDefault();
    }
}