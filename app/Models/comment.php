<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ID_Client',
        'client_name',
        'Comment',
        'Note',
        'datecomment',
    ];
}
