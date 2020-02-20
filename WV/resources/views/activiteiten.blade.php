@extends('layouts.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12"><h1>Kalender</h1>
        <table class="table">
            <tr><th>Datum</th><th>Activiteit</th><th class="one">Bijzonderheden</th></tr>
            @foreach($calendars as $item)
            <tr><td>{{date('d-m-Y', strtotime($item->date))}}</td><td>{{$item->name}}</td><td class="one">{{$item->description}}</td></tr>
            @endforeach
        </table>
        </div>
        <div class="col-md-6 col-sm-12"><h1>Acties</h1>
        @foreach($actions as $row)
            <h4>Bedrijf: {{$row->store->companyname}}</h4>
            <p>Van: {{date('d-m-Y', strtotime($item->from))}}  Tot: {{date('d-m-Y', strtotime($item->till))}}</p>
             <p>{{$row->description}}</p>
                <img src="{{asset('images/actions/'.$row->flyer)}}" alt="">
                <hr>
        @endforeach
        </div>
    </div>
</div>
@endsection
