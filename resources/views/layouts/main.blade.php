<!doctype html>
<html lang="en">

<head>
<meta name="msvalidate.01" content="310E6540CE61306C2596B6477B844752" />
<meta name="google-site-verification" content="xViFI79cGH1RXsvLGsxTlQVlePBk8lT5ssyMG6XvWUo" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="With our fleet of new cars, you will not have to worry about the ridesharing company’s strict vehicle requirements anymore. Join the next generation of Rideshare Driving">
    <meta name="keywords" content="Uber, Lyft, Rideshare, Car Flo">
    <meta name="author" content="Car Flo">
    <title>Tlc Car Rental, Uber Driver App: Car Flo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('images/favicon-32x32.png')}}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{asset('images/favicon-16x16.png')}}" sizes="16x16" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom_elements.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700" rel="stylesheet">

    @yield('add_css')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    @include('_partials.analytics')
</head>
<body>

@include('includes.header')

@yield('content')

@include('includes.footer')

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@yield('add_custom_script')

</body>
</html>
