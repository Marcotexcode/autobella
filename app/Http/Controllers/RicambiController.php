<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ricambio;
use App\Models\Fornitore;
use App\Models\Categoria;



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
        // // dd(Ricambio::find(1)->fornitore);
        // dd(Ricambio::find(1)->categoria);


        // // ricambi = Ricambio::all();

        //  dd(Categoria::find(1)->ricambi);
    
        
        
        return view('ricambi.index', compact('ricambi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Ricambio  $ricambi)
    {
        $categorie = Categoria::all();
        $fornitori = Fornitore::all();

        return view('ricambi.create', compact('categorie','fornitori'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'ragione_sociale' => 'required',
        //     'indirizzo' => 'required',
        //     'comune' => 'required',
        //     'cap' => 'required',
        //     'provincia' => 'required',
        //     'p_iva' => 'required'
        // ]);
        $ricambi = Ricambio::create($request->all());

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
        return view('ricambi.edit', compact('ricambi', 'categorie', 'fornitori'));
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
