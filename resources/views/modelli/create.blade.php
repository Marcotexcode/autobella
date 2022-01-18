@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Aggiungi Modello</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('modelli.index') }}">Torna indietro</a>
                    </div>
                </div>
            </div>       
            <form action="{{ route('modelli.store') }}" method="POST">
                @csrf
                <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                <input type="text" name="nome" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Anno commercializzazione:</strong>
                                <input type="text" name="anno_commercializzazione" class="form-control">
                            </div>
                        </div>

                        <div class="card-text">
                            <h4>Marca</h4>
                            <select name='marca_id' class="bg-gray-600 appearance-none">
                                @foreach ($marche as $marca)
                                    <option value="{{$marca->id}}">{{$marca->nome}}</option>
                                @endforeach 
                            </select>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4>Ricambi compatibili</h4>
                            <div class="card-text">
                                @foreach ($ricambi as $ricambio)  
                                    <div class="form-check">
                                        <input class="form-check-input" name="ricambio_id[]" value="{{$ricambio->id}}" type="checkbox" id="extraIndex">
                                        <label for="extraIndex" class="form-check-label">
                                             {{$ricambio->codice}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>     
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Invia</button>
                    </div>
                </div>              
            </form>
        </div>
    </div>
</div>
@endsection