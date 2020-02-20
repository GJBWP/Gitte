<h1>Nieuwe taak aangemaakt voor u!</h1>
<br>
<h4>Informatie</h4>
<br>
<table class="table">
    <tr>
        <td>Project:</td><td>{!! $project !!}</td>
    </tr>
    <tr>
        <td>Adres:</td><td>{!! $location !!}</td>
    </tr>
    <tr>
        <td>Van:</td><td>{!! $startdate !!} {!! $starttime !!}</td>
    </tr>
    <tr>
        <td>Tot:</td><td>{!! $enddate !!} {!! $endtime !!}</td>
    </tr>
    <tr>
        <td>Omschrijving Werkzaamheden:</td><td>{!! $description !!}</td>
    </tr>
    <tr>
        <td>Opmerkingen:</td><td>{!! $remarks !!}</td>
    </tr>

</table>

<a href="{!! $url !!}">Naar taken</a><br>
<a href="{!! $google !!}">Toevoegen aan Google agenda</a>
