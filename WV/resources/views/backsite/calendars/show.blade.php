@extends('layouts.layoutbacksite')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Datum</th><td>{{$calendar->date}}</td>
                    </tr>
                    <tr>
                        <th>Activiteit</th><td>{{$calendar->name}}</td>
                    </tr>
                    <tr>
                        <th>Extra Informatie</th><td>{{$calendar->description}}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{route('calendars.edit', $calendar->id)}}" class="btn btn-primary float-left col-6">Wijzigen</a>
            {!! Form::open(['method'=>'DELETE', 'action'=>['CalendarsController@destroy', $calendar->id]]) !!}
            {!!Form::submit('Verwijderen', ['class'=>'btn btn-danger col-6'])!!}

            {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
