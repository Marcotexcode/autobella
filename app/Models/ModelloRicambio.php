<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelloRicambio extends Model
{
    use HasFactory;

    protected $table = 'modello_ricambio';

    protected $fillable = [
        'modello_id',
        'ricambio_id'
    ];

    public function ricambi()
    {
        return $this->belongsToMany(Ricambio::class);
    }

    public function modelli()
    {
        return $this->belongsToMany(Modello::class);
    }

}
