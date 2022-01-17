<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorie';

    protected $fillable = [
        'desctizione'
    ];
    
    public function ricambio()
    {
        return $this->belongsTo(Ricambi::class);
    }
}
