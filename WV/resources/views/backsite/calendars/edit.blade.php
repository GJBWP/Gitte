@extends('layouts.layoutbacksite')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">

    {!! Form::open(['method'=>'PATCH', 'action'=>['CalendarsController@update', $calendar->id]]) !!}

    {{Form::token()}}

    <div class="form-group row">
        {!! Form::label('date', 'Datum', ['class'=>'col-sm-4 col-form-label']) !!}
        {!! Form::date('date', $calendar->date, ['class'=>'form-control col-sm-8'])!!}
    </div>

    <div class="form-group row">
        {!! Form::label('name', 'Activiteit', ['class'=>'col-sm-4 col-form-label']) !!}
        {!! Form::text('name', $calendar->name, ['class'=>'form-control col-sm-8'])!!}
    </div>

    <div class="form-group row">
        {!! Form::label('description', 'Extra Informatie', ['class'=>'col-sm-4 col-form-label']) !!}
        {!! Form::textarea('description', $calendar->description, ['class'=>'form-control col-sm-8'])!!}
    </div>
                <div class="form-group row">
    {!!Form::submit('Wijzigen', ['class'=>'btn btn-primary'])!!}
                </div>
    {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
