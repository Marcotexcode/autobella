@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Aggiungi Fornitore</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('fornitori.index') }}"> Back</a>
                    </div>
                </div>
            </div>       
            <form action="{{ route('fornitori.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Ragione Sociale:</strong>
                            <input type="text" name="ragione_sociale" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Indirizzo:</strong>
                            <input type="text" name="indirizzo" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Comune:</strong>
                            <input type="text" name="comune" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Cap:</strong>
                            <input type="number" name="cap" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Provincia:</strong>
                            <input type="text" name="provincia" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Partita Iva:</strong>
                            <input type="text" name="p_iva" class="form-control">
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