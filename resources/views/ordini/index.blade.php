@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Elenco ordini</h2>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data</th>
                            <th scope="col">Indirizzo</th>
                            <th scope="col">Azioni</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Marco</td>
                            <td>29/03/2020</td>
                            <td>Pineto</td>
                            <td>
                                <button class="btn btn-primary">Dettaglio Ordine</button>
                                <button class="btn btn-primary">Ordine Pronto</button>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection