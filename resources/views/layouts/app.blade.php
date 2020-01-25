<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('select2-4.0.7/dist/css/select2.min.css') }}">
        <!-- <link href="ExampleStyle.css" type="text/css" rel="stylesheet"/> -->
        <link rel="stylesheet" href="{{ asset('css/tablestyle.css') }}">
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        
	

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link type="text/css" href="{{ url('css/b4-select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('css/select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/style.css') }}" rel="stylesheet">


        <style>
        .select2-selection {
            font-size: 1.4rem !important;
            line-height: 1.5 !important;
            display: block !important;
            width: 100% !important;
            height: calc(3.42rem + 2px) !important;
            padding: .625rem .75rem !important;
            transition: all .2s cubic-bezier(.68, -.55, .265, 1.55) !important;
            color: #8898aa !important;
            border: 1px solid #cad1d7 !important;
            border-radius: .375rem !important;
            background-color: #fff !important;
            background-clip: padding-box !important;
            box-shadow: none !important;
            transition: box-shadow .15s ease !important;
            border: 1px solid #ced4da !important;
        }
        .heading-small{
            font-weight: bold
        }
        .theme-semidark .dt-brand:before {
            background-color: #fff !important;
        }
    </style>
    @yield('style')

    <script>
        var baseUrl = '{{url("/")}}';
    </script>

    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth
        
        <div class="main-content">
            @include('sweetalert::alert')
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')

        <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        
        <!-- select2 JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
       
       <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ url('js/select2.js') }}"></script>
        
        <script type="text/javascript">
            $(document).ready(function() {
            $("select").not('.user').select2({
                theme: "bootstrap"
            });
            // $('.datatable').DataTable();
        });

          var Datepicker = (function() {
    var $datepicker = $('.datepicker');
    function init($this) {
        var options = {
            disableTouchKeyboard: true,
            autoclose: false,
            format: 'dd/mm/yyyy'
        };
        $this.datepicker(options);
    }
    if ($datepicker.length) {
        $datepicker.each(function() {
            init($(this));
        });
    }
})();


    let product_price =0;
        $('#product_id').change(function(){
            var product_id = $(this).val();
            if(product_id){
                $.ajax({
                    url: baseUrl+'/fetch-product-price/'+product_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data.products.standard_price)
                        $('#productPrice').empty();
                        product_price=data.products.standard_price;
                        $('#productPrice').val(data.products.standard_price);
                    }
                });
            }
            else{
                $('#productPrice').val('');
                product_price=0;
            }
        });


        $('body').on('keyup', '#discount', function(){

            let discount = $(this).val();
           if(0 < discount && discount < 101){
            if(parseFloat(product_price) <= 0){
               alert('Please select a product to display product price')
               $('#discount').val('');
            }else{
                let billingAmount = (discount/100) * product_price;
              $('#billingAmount').val(billingAmount)
            }
        }else{
             $('#billingAmount').val('');
            alert('discount must not be more than 100')
        }
        })

$(document).on('keyup', '#discount', function(e){
    e.preventDefault();
    let value = e.target.value;
    //alert(value)
if(value <= 0){
     $(this).val('');
    
}
 });
$(document).on('keyup', '#productPrice', function(e){
    e.preventDefault();
    let value = e.target.value;
    //alert(value)
if(value <= 0){
     $(this).val('');
}
 });


        </script>
    </body>
</html>