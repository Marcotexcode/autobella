<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class OrdineTestata extends Model
{
    use HasFactory;

    protected $table = 'ordine_testate';

    protected $fillable = [
        'user_id',
        'tipo',
        'indirizzo',
        'telefono'
    ];

    // Relazione
    public function ordine_righe()
    {
        return $this->hasMany(OrdineRiga::class);
    }

    // Relazione
    public function utente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Carrello Anonimo
    public static function carrelloAnonimo()
    {
        $carrello = OrdineTestata::where('id', session('idCarrello'));

        return $carrello;
    }

    // Carrello Utente
    public static function carrelloUtente()
    {
        $carrello = OrdineTestata::where('user_id', Auth::user()->id)->where('tipo', 0);

        return $carrello;
    }

    // Passa il carrello o autenticato o anonimo
    public static function carrelloAnonimoAutenticato()
    {
        $idCarrello = null;

        if (session('idCarrello')) {

            $idCarrello = OrdineTestata::where('id', session('idCarrello'));

        } elseif(Auth::user()) {
            
            $idCarrello = OrdineTestata::where('user_id', Auth::user()->id)->where('tipo', 0);

        } 

        return $idCarrello;
    } 

}
