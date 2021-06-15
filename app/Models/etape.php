<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etape extends Model
{
    use HasFactory;
    
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'descreption',
        'post_id'

    ];
    
}
