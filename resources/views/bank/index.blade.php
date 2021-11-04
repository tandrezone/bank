<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Crypto</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
<table border="1px solid black">
    <tr>
        @foreach($tableHeaders as $header)
        <th>{{$header}}</th>
        @endforeach
    </tr>
    @foreach($tableBody as $row)
        <tr
            @if($row[4] < 0 && $row[1] != 'EUR' ) style="background-color: rgba(255,0,0,.2);"@endif
            @if($row[4] > 0 && $row[1] != 'EUR' ) style="background-color: rgba(0,255,0,.2);"@endif
        >
            <td>{{$row[0]}}</td>
            <td>{{$row[1]}}</td>
            <td>{{$row[2]}}</td>
            <td>@if($row[3]){{$row[3]}}€@endif</td>
            <td style="text-align: right;">@if($row[4]){{$row[4]}}€ ({{$row[5]}}€)@endif</td>
        </tr>
    @endforeach
</table>
<div>
    Total {{$total}} €
</div>
<div>
    Gain {{$gain}} €
</div>




    </body>
</html>
