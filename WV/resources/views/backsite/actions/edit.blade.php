@extends('layouts.layoutbacksite')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">



{{Form::open(['action' => 'CalendarsController@store'])}}

    {{Form::token()}}

    {{ Form::close() }}


            </div>
        </div>
    </div>
@endsection
