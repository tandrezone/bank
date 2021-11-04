<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

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
        <tr>
            @foreach($row as $item)
            <td>{{$item}}</td>
            @endforeach
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
