<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'image',
        'user_id',
        'categorie_id'

    ];

    public function ingredionPost()
    {
        return $this->hasMany(ingredion_post::class,'post_id');
    }

    public function etape()
    {
        return $this->hasMany(etape::class,'post_id');
    }

    public function comment()
    {
        return $this->hasMany(comment::class,'post_id');
    }
}
