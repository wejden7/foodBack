<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unite extends Model
{
    use HasFactory;
    
    protected $fillable =[
        'label',
        'convert',
        'categorie_id'
    ];

    public function catrgorie()
    {
        return $this->belongsTo(categorie_unite::class,'categorie_id');
    }
}
