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
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('ricambi.index') }}"> Back</a>
                    </div>
                </div>
            </div>       
            <form action="{{ route('ricambi.update', $ricambi->id) }}" method="POST">
                @csrf
                @method('PUT')  
                <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Codice:</strong>
                                <input type="text" name="codice" value="{{$ricambi->codice}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Descrizione:</strong>
                                <textarea class="form-control" style="height:150px" name="descrizione" >{{$ricambi->descrizione}}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Prezzo:</strong>
                                <input type="text" name="prezzo" value="{{$ricambi->prezzo}}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="card-text">
                            <h4>Categoria</h4>
                            <select name='categoria_id' class="bg-gray-600 appearance-none">
                                @foreach ($categorie as $categoria)
                                    <option value="{{$categoria->id}}" {{$categoria->id == $ricambi->categoria_id ? 'selected' : ''}} value="{{$ricambi->categoria_id}}">{{$categoria->id}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="card-text">
                            <h4>Fornitori</h4>
                            <select name='fornitore_id' class="bg-gray-600 appearance-none">
                                @foreach ($fornitori as $fornitore)
                                    <option value="{{$fornitore->id}}" {{$fornitore->id == $ricambi->fornitore_id ? 'selected' : ''}} >{{$fornitore->ragione_sociale}}</option>
                                @endforeach 
                            </select>
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