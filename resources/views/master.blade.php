<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <title>SmartFarm</title>

</head>

<body>
    <div id="app">
        <navbarmenu></navbarmenu>
        <vue-layout></vue-layout>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>