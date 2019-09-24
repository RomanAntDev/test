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

    #my-form {
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
<form id="my-form" method="post" action="{{ route('store') }}">
    @csrf
    <h3>Регистрация</h3>
    <div class="form-group">
        <label for="inputCredential">ФИО</label>
        <input type="text" class="form-control" name="name" id="inputCredential"
               placeholder="ФИО" required>
    </div>
    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email" required>
    </div>

    <!-- Region -->
    <div class='with-select'>
        <span>Выбрать область:</span>
        <select class="chosen-select region" name="region" required="true">
            <option value="" disabled selected>Выбрать область</option>
            @foreach($regions as $region)
                <option value="{{ $region['ter_id'] }}">{{ $region['ter_name'] }}</option>
            @endforeach
        </select>
    </div>

    <!-- City -->
    <div class='with-select city' style="display: none">
        <span>Выбрать город:</span>
        <select class="chosen-select2 city" name="city">
            <option value="" disabled selected>Выбрать город</option>
        </select>
    </div>

    <!-- District -->
    <div class='with-select district' style="display: none">
        <span>Выбрать район:</span>
        <select class="chosen-select3 district" name="district">
            <option value="" disabled selected>Выбрать район</option>
        </select>
    </div>

    <div>
        <button type="submit" class="btn btn-primary" style="margin-top: 5px;">Регистрация</button>
    </div>
</form>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link rel="stylesheet" href="http://lysik.pl/public/chosen.css">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>
<script type="application/javascript">

    $('[name=region]').chosen({}).change(function (obj, result) {

        $("[name=district]").closest('div').hide();
        $("[name=district]").chosen("destroy");
        $.ajax({
            type: "POST",
            url: '/cities/' + result.selected,
            dataType: 'json',
            success: function (data) {
                if($.isEmptyObject(data.cities)) {
                    $("[name=city]").closest('div').hide();
                    $("[name=city]").chosen("destroy");
                    console.log(result.selected)

                    $.ajax({
                        type: "POST",
                        url: '/exception/' + result.selected,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data.exceptions)
                            $("[name=district]").closest('div').show();
                            $("[name=district]").html(data.exceptions);
                            $("[name=district]").chosen("destroy").chosen({});

                        },
                        error() {
                            alert('error exception');
                        }
                    });
                } else {
                    $("[name=city]").closest('div').show();
                    $("[name=city]").html(data.cities);
                    $("[name=city]").chosen("destroy").chosen({});
                }
            },
            error() {
                alert('error');
            }
        });
    });
    $('[name=city]').chosen({}).change(function (obj, result) {
        _step = $("[name=region]").val();
        $.ajax({
            type: "POST",
            url: '/districts/' + result.selected,
            dataType: 'json',
            success: function (data) {
                if($.isEmptyObject(data.districts)) {
                    $("[name=district]").closest('div').hide();
                    $("[name=district]").chosen("destroy");
                    $("[name=district]").chosen("destroy").chosen({});
                } else {
                    $("[name=district]").closest('div').show();
                    $("[name=district]").html(data.districts);
                    $("[name=district]").chosen("destroy").chosen({});
                }
            },
            error() {
                alert('error');
            }
        });
    });

    $.validator.setDefaults({ignore: ":hidden:not(select)"});

    // validation
    $('#my-form').validate({
        errorPlacement: function (error, element) {
            console.log("placement");
            if (element.is("select.chosen-selects")) {
                console.log("placement for chosen");

                element.next("div.chzn-container").append(error);
            } else {

                error.insertAfter(element);
            }
        }
    });
</script>
</body>
</html>
