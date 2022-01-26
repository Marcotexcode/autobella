<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdineRiga;


class CarrelloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$ordineRighe = OrdineRiga::all();

        $idCarrello = session('idCarrello');

        $ordineRighe = OrdineRiga::where('ordine_testata_id', $idCarrello)->get();

        return view('carrello.index', compact('ordineRighe'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ordineRiga = OrdineRiga::find($id);
        //dd($ordineRiga);
        return view('carrello.edit', compact('ordineRiga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantità' => 'required|numeric|min:0|not_in:0'
        ]);

        $ordineRiga = OrdineRiga::find($id)->update($request->all());

        return redirect()->route('carrello.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrdineRiga::find($id)->delete();
        return redirect()->route('carrello.index');
    }
}
