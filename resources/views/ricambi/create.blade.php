@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Aggiungi Ricambio</h2>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('ricambi.index') }}"> Back</a>
                    </div>
                </div>
            </div>       
            <form action="{{ route('ricambi.store') }}" method="POST">
                @csrf
                <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Codice:</strong>
                                <input type="text" name="codice" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Descrizione:</strong>
                                <textarea class="form-control" style="height:150px" name="descrizione" ></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Prezzo:</strong>
                                <input type="text" name="prezzo" class="form-control">
                            </div>
                        </div>
                        
                        <div class="card-text">
                            <h4>Categoria</h4>
                            <select name='categoria_id' class="bg-gray-600 appearance-none">
                                @foreach ($categorie as $categoria)
                                    <option value="{{$categoria->id}}">{{$categoria->descrizione}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="card-text">
                            <h4>Fornitori</h4>
                            <select name='fornitore_id' class="bg-gray-600 appearance-none">
                                @foreach ($fornitori as $fornitore)
                                    <option value="{{$fornitore->id}}">{{$fornitore->ragione_sociale}}</option>
                                @endforeach 
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4>Modelli compatibili</h4>
                            <div class="card-text">
                                @foreach ($modelli as $modello)  
                                    <div class="form-check">
                                        <input class="form-check-input" name="modello_id[]" value="{{$modello->id}}" type="checkbox" id="extraIndex">
                                        <label for="extraIndex" class="form-check-label">
                                             {{$modello->nome}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>     
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>              
            </form>
        </div>
    </div>
</div>
@endsection