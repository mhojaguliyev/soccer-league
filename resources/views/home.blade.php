<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Football simulation</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        .mt-10 {
            margin-top: 9rem!important;
        }
    </style>
</head>
<body>
<div class="container-fluid gx-0" id="app">
    <div class="row gx-0">
        <div class="col">
            <football-component/>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
