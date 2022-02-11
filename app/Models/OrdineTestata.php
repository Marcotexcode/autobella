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

    public function ordine_righe()
    {
        return $this->hasMany(OrdineRiga::class);
    }

    public function utente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // public static function carrelloAutenticato()
    // {
    //     $idCarrello = OrdineTestata::where('user_id', Auth::user()->id)->where('tipo', 0);

    //     return $idCarrello;
    // }

    // passa il carrello o autenticato o anonimo
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

    // righe carrello anonimo o autenticato
    public static function righeAnonimoAutenticato()
    {
        $righeCarrello = [];
        
        if (session('idCarrello')) {

            $righeCarrello = OrdineRiga::where('ordine_testata_id', session('idCarrello'))->get();
            
            
        } elseif(Auth::user()) {

            $idCarrello = OrdineTestata::where('user_id', Auth::user()->id)->where('tipo', 0)->value('id');

            $righeCarrello = OrdineRiga::where('ordine_testata_id', $idCarrello)->get();
        }

        return $righeCarrello;
    }

}
