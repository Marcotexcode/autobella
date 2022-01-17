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
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Ragione Sociale:</strong>
                            {{ $fornitori->ragione_sociale }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Indirizzo:</strong>
                            {{ $fornitori->indirizzo }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Comune:</strong>
                            {{ $fornitori->comune }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Cap:</strong>
                            {{ $fornitori->cap }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Provincia:</strong>
                            {{ $fornitori->provincia }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Partita Iva:</strong>
                            {{ $fornitori->p_iva }}
                        </div>
                    </div>
                </div>              
        </div>
    </div>
</div>
@endsection