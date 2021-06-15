<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingredion_post extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
        'post_id',
        'ingredion_id',
        'unite_id'
    ];
    protected $primaryKey = 'post_id';
}
