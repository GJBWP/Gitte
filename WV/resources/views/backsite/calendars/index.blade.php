@extends('layouts.layoutbacksite')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
<h1>Kalender Items</h1>

            <table class="table">
    <thead>
        <tr>
            <th>Datum</th>
            <th>Activiteit</th>

        </tr>
    </thead>
    <tbody>
@foreach($calendars as $item)
        <tr>
            <td>{{date('d-m-Y', strtotime($item->date))}}</td>
            <td><a href="{{route('calendars.show', $item->id)}}">{{$item->name}}</a></td>

        </tr>
@endforeach
    </tbody>
</table>
            </div>
            <div class="col-md-6 col-sm-12">
                <h1>Item toevoegen</h1>
                {{Form::open(['action' => 'CalendarsController@store'])}}

                {{Form::token()}}

                <div class="form-group row">
                    {!! Form::label('date', 'Datum', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::date('date', null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                <div class="form-group row">
                    {!! Form::label('name', 'Activiteit', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::text('name', null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                <div class="form-group row">
                    {!! Form::label('description', 'Extra Informatie', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::textarea('description', null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                {!!Form::submit('Toevoegen', ['class'=>'btn btn-primary'])!!}

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
