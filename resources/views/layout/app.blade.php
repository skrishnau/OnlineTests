<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- for posting via ajax --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <title>Online Tests - @yield('title') </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    {{-- <link href="{{asset('css/all.css')}}" rel="stylesheet" type="text/css"> --}}

     @yield('head')

    <script>
        var app_url = "{{Request::root()}}";
    </script>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> --}}

    <!-- Optional theme -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>

{{-- Navbar here ? --}}
            {{-- @include('layout.navbar') --}}
    <div class="loadingBackground" style="{{isset($blockWindow) && $blockWindow ? "" : "display:none;"}} background-color:rgba(54, 51, 47, 0.5); position:fixed; left:0; top:0;z-index:1000; width:100%; height:100%;">
        {{-- style="position: fixed;  height:100%; width:100%;text-align:center;" --}}
        <div class="loader" style="position:fixed; left:45%; top:45%; z-index:1000;"></div> 
    </div>
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
                </div>  --}}
                <div class="col-md-10 offset-md-1 bg-light ">
                    <div class="row card ">
                        @if(!isset($showBreadCrumbs) || $showBreadCrumbs)
                            <div class=" card-header bg-dark text-light">
                                {{-- <h3>
                                    @yield('heading')
                                </h3> --}}
                                <a class="text-light" href="{{route("paper.index")}}">All Papers</a>
                            </div>
                        @endif
                        <div class="card-body content">
                            {{-- Contents --}}
                            @yield('content')
                            <div id="push"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer" style="min-height:100px; background-color:black; color:white;">
        Online Test
    </div>

    
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    {{-- <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script> --}}
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}

    <script src="{{asset("js/app.js")}}"></script>
    <script src="{{asset("js/notify.min.js")}}"></script>

    @yield('scripts')
</body>
</html>
