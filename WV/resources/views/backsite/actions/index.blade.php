@extends('layouts.layoutbacksite')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">


                <table class="table">
                    <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Winkel</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($actions as $item)
                        <tr>
                            <td>{{date('d-m-Y', strtotime($item->from)) . ' - ' .date('d-m-Y', strtotime($item->till)) }}</td>
                            <td><a href="{{route('actions.show', $item->id)}}">{{$item->store->companyname}}</a></td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 col-sm-12">
                {{Form::open(['action' => 'ActionsController@store'])}}

                {{Form::token()}}

                <div class="form-group row">
                    {!! Form::label('store_id', 'Winkel', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::select('store_id', ['' => 'Winkel kiezen'] + $stores, null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                <div class="form-group row">
                    {!! Form::label('from', 'Datum', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::date('from', null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                <div class="form-group row">
                    {!! Form::label('till', 'Datum', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::date('till', null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                <div class="form-group row">
                    {!! Form::label('description', 'Extra Informatie', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::textarea('description', null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                <div class="form-group row">
                    {!! Form::label('flyer', 'Flyer of Afbeelding', ['class'=>'col-sm-4 col-form-label']) !!}
                    {!! Form::file('flyer', null, ['class'=>'form-control col-sm-8'])!!}
                </div>

                {!!Form::submit('Toevoegen', ['class'=>'btn btn-primary'])!!}

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
