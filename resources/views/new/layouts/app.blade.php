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
  <script>
      var baseUrl = '{{url("/")}}';
  </script>
    @yield('style')
</head>

<body class="dt-sidebar--fixed dt-header--fixed">
    @include('new.layouts.loader')

    <div class="dt-root">
        @include('new.layouts.header')
        <main class="dt-main">
            @include('new.layouts.sidebar')

            <!-- Site Content Wrapper -->
            <div class="dt-content-wrapper">

            <!-- Site Content -->
            <div class="dt-content">

                <!-- Page Header -->
                <div class="dt-page__header">
                <h1 class="dt-page__title">Blank Page</h1>
                </div>
                <!-- /page header -->

            </div>
            <!-- /site content -->

            <!-- Footer -->
            <footer class="dt-footer">
                Copyright Asset Clerk © {{date('Y')}}
            </footer>
            <!-- /footer -->

            </div>
            <!-- /site content wrapper -->

            @include('new.layouts.customizer_sidebar')
        </main>
    </div>
    
    <script src="{{url('assets/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('assets/moment/moment.js')}}"></script>
    <script src="{{url('assets/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Perfect Scrollbar jQuery -->
    <script src="{{url('assets/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
    <!-- /perfect scrollbar jQuery -->
    <!-- masonry script -->
    <script src="{{url('assets/masonry-layout/dist/masonry.pkgd.min.js')}}"></script>
    <script src="{{url('assets/sweetalert2/dist/sweetalert2.js')}}"></script>
    <!-- Custom JavaScript -->
    <script src="{{url('assets/js/script.js')}}"></script>

    <script>
        const toast = swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
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
    </script>

    @yield('script')
</body>
</html>