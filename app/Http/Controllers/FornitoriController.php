<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornitore;


class FornitoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fornitori = Fornitore::all();

        return view('fornitori.index', compact('fornitori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fornitori.create');
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
            'ragione_sociale' => 'required',
            'indirizzo' => 'required',
            'comune' => 'required',
            'cap' => 'required',
            'provincia' => 'required',
            'p_iva' => 'required'
        ]);
        $fornitori = Fornitore::create($request->all());

        return redirect()->route('fornitori.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Fornitore $fornitori)
    {   
        return view('fornitori.show', compact('fornitori'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Fornitore  $fornitori)
    {
        return view('fornitori.edit', compact('fornitori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fornitore $fornitori)
    {
        $request->validate([
            'ragione_sociale' => 'required',
            'indirizzo' => 'required',
            'comune' => 'required',
            'cap' => 'required',
            'provincia' => 'required',
            'p_iva' => 'required'
        ]);

        $fornitori->update($request->all());

        return redirect()->route('fornitori.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fornitore $fornitori)
    {
        $fornitori->delete();

        return redirect()->route('fornitori.index');
    }
}
