<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Salestivity') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/icon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/custom.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('select2-4.0.7/dist/css/select2.min.css') }}">
        <!-- <link href="ExampleStyle.css" type="text/css" rel="stylesheet"/> -->
        <link rel="stylesheet" href="{{ asset('css/tablestyle.css') }}">
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        
	

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link type="text/css" href="{{ url('css/b4-select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('css/select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/style.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

<!-- Rich text editor style -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ url('richTextEditor/richtext.min.css') }}">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        

<!-- Data table stylesheet -->
    <link href="{{url('assets/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">


        <style>
        .select2-selection {
            font-size: 1rem !important;
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
            overflow: hidden;
        }
        .heading-small{
            font-weight: bold
        }
        .theme-semidark .dt-brand:before {
            background-color: #fff !important;
        }

        input[type=email] {
        border: 0.5px solid;
        border-radius: 4px;
        }
        input[type=text] {
        border: 0.5px solid;
        border-radius: 4px;
        }
        input[type=tel] {
        border: 0.5px solid;
        border-radius: 4px;
        }
         input[type=url] {
        border: 0.5px solid;
        border-radius: 4px;
        }
        input[type=number] {
        border: 0.5px solid;
        border-radius: 4px;
        }


 .table-responsive{
    overflow-x:auto;
 }

 table tr .word-wrap{
    width: 130px;
    white-space: normal;
}
    </style>
   

    @yield('style')



    <script>
        var baseUrl = '{{url("/")}}';
        
var product_categories = <?php echo json_encode(isset($categories) ? $categories : ''); ?>;

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
       
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
        
       



 <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        @stack('js')

        
        <!-- select2 JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
       
       <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- datatable script -->
       <script src="{{url('assets/datatables.net/js/jquery.dataTables.js')}}"></script>
    <script src="{{url('assets/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>


    



    
    <script src="{{ url('js/select2.js') }}"></script>
    
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@fengyuanchen/datepicker@0.6.5/dist/datepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@fengyuanchen/datepicker@0.6.5/dist/datepicker.min.css" rel="stylesheet"> 

<script type="text/javascript">

$(function() {
  $('[data-toggle="datepicker"]').datepicker({
    autoHide: true,
    zIndex: 2048,
    format: "dd/mm/yyyy",
  });
});
</script>
    <script src="{{url('js/mainjs.js')}}"></script>
  
<!-- Rich text editor script -->
  <script type="text/javascript" src="{{ url('richTextEditor/jquery.richtext.js') }}"></script>
        <script type="text/javascript" src="{{ url('richTextEditor/jquery.richtext.min.js') }}"></script>
   <script>
        $(document).ready(function() {
            $('.content').richText();
        });
        </script>

    </body>
</html>