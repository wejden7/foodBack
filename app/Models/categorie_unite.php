<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorie_unite extends Model
{
    use HasFactory;
    protected $fillable=['label'];

    public function unites()
    {
        return $this->hasMany(unite::class,'categorie_id');
    }
}
