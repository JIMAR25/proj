@extends('layouts.header')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Détails du stock
                        <a href="{{ route('admin.index') }}" class="btn btn-primary btn-sm float-right">Retour</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong>Article:</strong></td>
                                    <td>{{ $stock->nom }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>{{ $stock->type }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td>{{ $stock->description }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Quantité:</strong></td>
                                    <td>{{ $stock->quantite }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
