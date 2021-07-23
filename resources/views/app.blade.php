<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>

     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/smart.wizard/smart_wizard_theme_circles.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
    
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/script.min.js') }}"></script>
    
    
    <script src="{{ asset('assets/js/vendor/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.smartWizard.min.js')}}"></script>
   
    {{-- <script src="{{ asset('assets/js/smart.wizard.script.js')}}"></script> --}}
    <script src="{{ asset('assets/js/es5/sidebar.large.script.min.js')}}"></script>
    <script src="{{ asset('assets/js/form.validation.script.js')}}"></script>
    {{-- SDK MercadoPago.js V2 --}}
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <style>
        .logo-law {
            background-color: black;
            color: white !important;
            padding: 7px 47px;
            font-weight: 900;
            font-size: 27px;
        }
    </style>
</head>
<body>
    <div >
        @inertia
    </div>
</body>
</html>
