@extends('layouts.layoutbacksite')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
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
