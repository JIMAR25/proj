@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Modifier une réservation</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.reservations.index') }}"> Retour</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Attention!</strong> Il y a eu quelques problèmes avec les champs saisis.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.reservations.update',$reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Chambre:</strong>
                    <select class="form-control" name="id_chambre">
                        @foreach ($chambres as $chambre)
                            <option value="{{ $chambre->id_chambre }}" @if ($chambre->id_chambre == $reservation->id_chambre) selected @endif>{{ $chambre->numero }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" value="{{ $reservation->email }}" class="form-control" placeholder="Email">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Date d'arrivée:</strong>
                    <input type="date" name="date_arrivee" value="{{ $reservation->date_arrivee }}" class="form-control" placeholder="Date d'arrivée">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Date de départ:</strong>
                    <input type="date" name="date_depart" value="{{ $reservation->date_depart }}" class="form-control" placeholder="Date de départ">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>

    </form>
@endsection