<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Asset Clerk">
    <meta name="keywords" content="Asset Clerk">
    <!-- /meta tags -->
    <title>{{$title}} | Asset Clerk</title>
    <!-- Site favicon -->
    <link href="{{url('img/logo.png')}}" rel="icon" type="image/png">
    <!-- /site favicon -->
    <!-- Font Icon Styles -->
    <link rel="stylesheet" href="{{url('assets/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/gaxon-icon/style.css')}}">
    <!-- /font icon Styles -->
    <!-- Perfect Scrollbar stylesheet -->
    <link rel="stylesheet" href="{{url('assets/perfect-scrollbar/css/perfect-scrollbar.css')}}">
    <!-- /perfect scrollbar stylesheet -->
    <!-- Load Styles -->
    <link rel="stylesheet" href="{{url('assets/css/lite-style-1.min.css')}}">
    <!-- /load styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link type="text/css" href="{{ url('css/b4-select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('css/select2.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/style.css') }}" rel="stylesheet">
    <!-- Data table stylesheet -->
    <link href="{{url('assets/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <!-- load fontawesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script>
        var baseUrl = '{{url("/")}}';
    </script>
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
</head>

<body class="dt-sidebar--fixed dt-header--fixed">
    {{-- @include('new.layouts.loader') --}}

    @auth()
    @if (auth()->user()->verified == 'no')
            @include('notification')
        @endif

        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    <div class="dt-root" style="{{ auth()->check() && auth()->user()->verified == 'no' ? 'margin-top:49px' : ''}}">
        @include('new.layouts.header')
        <main class="dt-main">
            @include('new.layouts.sidebar')

            <!-- Site Content Wrapper -->
            <div class="dt-content-wrapper">

            <!-- Site Content -->
            <div class="dt-content">
                @yield('content')
            </div>
            <!-- /site content -->

            <!-- Footer -->
            <footer class="dt-footer">
                Copyright Asset Clerk © {{date('Y')}}
            </footer>
            <!-- /footer -->

            </div>
            <!-- /site content wrapper -->


            {{-- @include('new.layouts.customizer_sidebar') --}}
        </main>
    </div>
   
     <script src="{{url('assets/jquery/dist/jquery.min.js')}}"></script>
    
    <script src="{{url('assets/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('assets/moment/moment.js')}}"></script>
    <script src="{{url('assets/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Perfect Scrollbar jQuery -->
    <script src="{{url('assets/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
    <!-- /perfect scrollbar jQuery -->
    <!-- masonry script -->
    <script src="{{url('assets/masonry-layout/dist/masonry.pkgd.min.js')}}"></script>
    <script src="{{url('assets/sweetalert2/dist/sweetalert2.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ url('js/select2.js') }}"></script>
    <script src="{{url('assets/datatables.net/js/jquery.dataTables.js')}}"></script>
    <script src="{{url('assets/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- Custom JavaScript -->
    <script src="{{url('assets/js/script.js')}}"></script>

    <script>
        const toast = swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 10000
        });

        @if(session()->has('success'))
            toast({
                type: 'success',
                title: '{{session("success")}}'
            })
        @endif

        @if(session()->has('error'))
            toast({
                type: 'error',
                title: '{{session("error")}}'
            })
        @endif
        
        @if(session()->has('info'))
            toast({
                type: 'info',
                title: '{{session("info")}}'
            })
        @endif

        $('.datatable').DataTable({
            dom: '<"html5buttons" B>lTfgitp'
        });

        $('body').on('click', '[data-confirm]', function () {
            return confirm('Are you sure?');
        });

        $(document).ready(function() {
            $("select").not('.user').select2({
                theme: "bootstrap"
            });
            $('.datatable').DataTable();
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

//activate and deactivate rental renewal
        $(document).ready(function(){
  $('div.no').click(function() {
    var rentaluuid = $.trim($(this).text());
    var row = $(this).data('row');
               if(rentaluuid){
                 var _token = $('input[name="_token"').val();
               $.ajax({
                    url: baseUrl+'/rental/no-renew-rental/'+rentaluuid,
                    type: "get",
                    data:{rentaluuid:rentaluuid, _token:_token},
                    success: function(data) {
                      if(data == 'no'){
                        $('div#rowNumber'+$.trim(row)).removeClass('active');
                               toast({
                        type: 'error',
                        title: 'Rental renewal has been deactivated successfully'
                    })
                      }
                    }
                });
            }
      });
})

$(document).ready(function(){

$('div.yes').click(function() {
    var rentaluuid = $(this).text();
     var row = $(this).data('row');
               if(rentaluuid){
                 var _token = $('input[name="_token"').val();
               $.ajax({
                    url: baseUrl+'/rental/yes-renew-rental/'+$.trim(rentaluuid),
                    type: "get",
                    data:{rentaluuid:rentaluuid, _token:_token},
                    success: function(data) {
                      if(data == 'yes'){
                        $('div#rowNumber'+$.trim(row)).addClass('active');
                           toast({
                        type: 'success',
                        title: 'Rental renewal has been activated successfully'
                    })
                      }
                    }
                });
            }
    });   
})

//validate payment dates
$(document).ready(function(){
 $("#payment_date").datepicker();
    $("#payment_date").on("change",function(event){
        event.preventDefault();
    var selected_date = $(this).val();
    var fist_date = selected_date.replace('/','-');
    var second_date = fist_date.replace('/','-');
    $.ajax({
                   url:"{{URL::to('/validate-selected-date')}}/"+second_date,
                    type: "GET",
                    data: {'selected_date':selected_date},
                    success: function(data) {
                      if(data ==='invalidate'){
                    toast({
                        type: 'warning',
                        title: 'Ooops!! Invalid payment date. Future date ('+ selected_date +') detected'
                    })
                    $("#payment_date").val('')
            }
        }
        });
    });
})
    </script>
 <script>
//Add tenant to property
        $('#input-property').change(function(){
            var property = $(this).val();
            if(property){
                $('#input-unit').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-unit');
                $.ajax({
                    url: baseUrl+'/fetch-units/'+property,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#input-unit').empty();
                        $('<option>').val('').text('Select Unit').appendTo('#input-unit');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.uuid).text(v.name+' | Qty Left: '+v.quantity_left).attr('data-price',v.standard_price).appendTo('#input-unit');
                        });
                    }
                });
            }
            else{
                $('#input-unit').empty();
                $('<option>').val('').text('Select Unit').appendTo('#input-unit');
            }
        });
        
        $('#input-unit').change(function(){
            var unit = $(this).val();
            if(unit){
                var price = $(this).find(':selected').attr('data-price')
                $('#input_price').val(price);
            }
            else{
                $('#input_price').val('');
            }
        });
    </script>
    @yield('script')
</body>
</html>