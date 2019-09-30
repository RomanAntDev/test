<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test PHP</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<style>
    .error {
        color: red;
    }

    span {
        display: inline-block;
        width: 150px;
    }

    input, select {
        width: 150px;
    }

    .with-select > span,
    .with-select > label.error {
        vertical-align: top;
        margin-top: 5px;
        display: inline-block;
    }

    #hm-form {
        padding: 50px;
        background: #d6e9f9;
        position: fixed;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .with-select {
        position: relative;
        vertical-align: middle;
        font-size: 13px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

</style>

<body>

<form id="hm-form" action="{{ route('index') }}">

    <div>Пользователь с таким Email уже зарегистрирован</div><br>

    <div>ФИО: <label class="form-group">{{$user->name}}</label></div>

    <div>Email: <label class="form-group">{{ $user->email }}</label></div>

    <div>Адрес: <label class="form-group">{{ $user->territory->ter_address }}</label></div>

    <button class="btn btn-success">Регистрация</button>
</form>

</body>
</html>
