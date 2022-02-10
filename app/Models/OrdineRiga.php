<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdineRiga extends Model
{
    use HasFactory;

    protected $table = 'ordine_righe';

    protected $fillable = [
        'ordine_testata_id',
        'ricambio_id',
        'quantità',
        'prezzo',
    ];

    public function ricambio()
    {
        return $this->belongsTo(Ricambio::class);
    }
  
}
