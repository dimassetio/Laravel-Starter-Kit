<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="x-csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', Option::get('app_name', 'PT. Chakra'))</title>

    {!! Html::style('assets/css/bootstrap.min.css') !!}
    {!! Html::style('assets/css/bootstrap-theme.min.css') !!}
    {!! Html::style('assets/css/font-awesome.min.css') !!}
    {!! Html::style('assets/css/sb-admin-2.css') !!}
    {!! Html::style('assets/css/app.css') !!}
</head>

<body>
    <div class="container">
        <div class="row">
            @yield('content')
        </div>
        @include('layouts.partials.footer')
    </div>

    {!! Html::script(url('assets/js/jquery.js')) !!}
    {!! Html::script(url('assets/js/bootstrap.min.js')) !!}

    <script type="text/javascript">
        (function() {
            $("div.alert.notifier").delay(10000).fadeOut();
        })();
    </script>
</body>

</html>
