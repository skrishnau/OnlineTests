<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online Tests - @yield('title') </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">




    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/all.css')}}" rel="stylesheet" type="text/css">

     @yield('head')

    <script>
        var app_url = "{{Request::root()}}";
    </script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>

{{-- Navbar here ? --}}
            {{-- @include('layout.navbar') --}}

    <div class="container-fluid flex-center position-ref full-height">
       {{--  <div class="content">

        </div> --}}

        <div class="content" style="min-height: 100%;">
        <div class="row text-light bg-dark " >
            <!-- style="height: 70px;" -->
            @include('layout.menubar')
        </div>
            <div class="row">

                {{-- <div class="col-md-2 pt-3 bg-secondary">

                    @section('leftmenubar')

                        @include('layout.leftmenubar')

                    @show
                </div> --}}

                <div class="col-md-10 bg-light ">
                    <div class="row card ">
                        <div class=" card-header bg-dark text-light">
                            <h3>
                                @yield('heading')
                            </h3>
                        </div>
                        <div class="card-body">
                            {{-- Contents --}}
                            @yield('content')

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    @yield('scripts')
</body>
</html>
