<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ricambio;
use App\Models\Fornitore;
use App\Models\Categoria;
use App\Models\Modello;
use App\Models\ModelloRicambio;


class RicambiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ricambi = Ricambio::all();

        return view('ricambi.index', compact('ricambi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorie = Categoria::all();
        $fornitori = Fornitore::all();
        $modelli = Modello::all();

        return view('ricambi.create', compact('categorie','fornitori','modelli'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'codice' => 'required',
            'descrizione' => 'required',
            'prezzo' => 'required',
        ]);
        
        $ricambi = Ricambio::create($request->all());

        $modelli = $request->input('modello_id', []);

        foreach ($modelli as $modello) {
            $pizzaExtra = new ModelloRicambio;
            $pizzaExtra->modello_id = $modello;
            $pizzaExtra->ricambio_id = $ricambi->id;
            $pizzaExtra->save();  
        }

        return redirect()->route('ricambi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ricambio  $ricambi)
    {
        return view('ricambi.show', compact('ricambi'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ricambio  $ricambi)
    {
        $categorie = Categoria::all();
        $fornitori = Fornitore::all();
        $modelli = Modello::all();
        $modelliScelti = collect($ricambi->modelli)->pluck('id')->toArray();

        return view('ricambi.edit', compact('ricambi', 'categorie', 'fornitori', 'modelli', 'modelliScelti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ricambio $ricambi)
    {
        $request->validate([
            'descrizione' => 'required'
        ]);

        $ricambi->update($request->all());

        $cancella = ModelloRicambio::where('ricambio_id', $ricambi->id)->delete();

        if ($request->modello_id) {
            $modelli = $request->input('modello_id', []);

            foreach ($modelli as $modello) {
                $pizzaExtra = new ModelloRicambio;
                $pizzaExtra->modello_id = $modello;
                $pizzaExtra->ricambio_id = $ricambi->id;
                $pizzaExtra->save();  
            }
        }
        
        return redirect()->route('ricambi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ricambio $ricambi)
    {
        $ricambi->delete();

        return redirect()->route('ricambi.index');
    }
}
