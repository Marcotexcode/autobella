<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Modello;
use App\Models\Ricambio;
use App\Models\Marca;
use App\Models\ModelloRicambio;



class ModelliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelli = Modello::all();

        return view('modelli.index', compact('modelli'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ricambi = Ricambio::all();
        $marche = Marca::all();

        return view('modelli.create', compact('ricambi','marche'));
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
            'marca_id' => 'required',
            'nome' => 'required',
            'anno_commercializzazione' => 'required'
        ]);

        $modelli = Modello::create($request->all());

        $ricambi = $request->input('ricambio_id', []);

        foreach ($ricambi as $ricambio) {
            $ricambioCompatibile = new ModelloRicambio;
            $ricambioCompatibile->ricambio_id = $ricambio;
            $ricambioCompatibile->modello_id = $modelli->id;
            $ricambioCompatibile->save();
        }

        return redirect()->route('modelli.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Modello $modelli)
    {
        return view('miodelli.show', compact('modelli'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Modello $modelli)
    {
        $marche = Marca::all();

        $ricambi = Ricambio::all();

        $ricambiScelti = collect($modelli->ricambi)->pluck('id')->toArray();

        return view('modelli.edit', compact('modelli', 'marche', 'ricambi', 'ricambiScelti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Modello $modelli)
    {
        $request->validate([
            'marca_id' => 'required',
            'nome' => 'required',
            'anno_commercializzazione' => 'required'
        ]);
        
        $modelli->update($request->all());

        $cancella = ModelloRicambio::where('modello_id', $modelli->id)->delete();

        if($request->ricambio_id) {
            $ricambi = $request->input('ricambio_id', []);

            foreach ($ricambi as $ricambio) {
                $ricambioCompatibile = new ModelloRicambio;
                $ricambioCompatibile->ricambio_id = $ricambio;
                $ricambioCompatibile->modello_id = $modelli->id;
                $ricambioCompatibile->save();
            }
        }

        return redirect()->route('modelli.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modello $modelli)
    {
        $modelli->delete();

        return redirect()->route('modelli.index');
    }
}
