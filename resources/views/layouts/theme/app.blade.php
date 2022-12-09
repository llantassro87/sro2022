<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SISTEMA SRO</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>

    @include('layouts.theme.styles')

</head>
<body class="dashboard-analytics">

    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

     @include('layouts.theme.header')

    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

         @include('layouts.theme.sidebar')

        <div id="content" class="main-content">
            
            <div class="layout-px-spacing">
            
                @yield('content')

            </div>
            

            @include('layouts.theme.footer')
        </div>

    </div>

    @include('layouts.theme.scripts')

</body>
</html>