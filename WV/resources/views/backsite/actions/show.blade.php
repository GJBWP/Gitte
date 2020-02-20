@extends('layouts.layoutbacksite')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Winkel</th><td>{{$action->store->companyname}}</td>
                        </tr>
                        <tr>
                            <th>Periode</th><td>{{date('d-m-Y', strtotime($action->from)) . ' - '.date('d-m-Y', strtotime($action->till))}}</td>
                        </tr>
                        <tr>
                            <th>Extra Informatie</th><td>{{$action->description}}</td>
                        </tr>
                        <tr>
                            <th>Flyer</th><td><img src="{{asset('images/actions/'.$action->flyer)}}" alt=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
