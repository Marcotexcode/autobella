@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col">
            <div class="row">
                <h1>Indirizzo di consegna</h1>
            </div>
        </div>
       
        <div class="col">
            <div class="row">
                <form action="{{ route('indirizzo.store')}}" method="POST">
                    @csrf 
                    <div class="form-group">
                      <label for="indirizzo">Inserisci indirizzo</label>
                      <input type="text" name="indirizzo" class="form-control" id="indirizzo">
                    </div>
                    <div class="form-group my-5">
                      <label for="numero-telefono">Inserisci Telefono</label>
                      <input type="text" name="telefono" class="form-control" id="numero-telefono">
                    </div>
                    <h2>Totale: {{$sommaTotale}} €</h2>
                    <button type="submit" class="btn btn-primary">Spedisci a questo indirizzo</button>
                </form>
            </div>
        </div>
    </div>
@endsection