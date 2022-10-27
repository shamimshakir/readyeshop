<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="wrapper"></div>    
    <script type="text/javascript">
        if(!localStorage.getItem('app_url')){
            localStorage.setItem('app_url', "{{ config('app.url') }}")
        }
    </script>
    <script src="{{ mix('js/backend/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/backend/jquery.min.js') }}"></script>
    <script src="{{ asset('js/backend/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/backend/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/backend/waves.min.js') }}"></script>
    <script src="{{ asset('js/backend/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('js/backend/all.js') }}"></script>
</body>
</html>
