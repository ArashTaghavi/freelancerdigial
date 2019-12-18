<!DOCTYPE html>
<html lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Bootstrap Admin App + jQuery">
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title></title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fa-brands.css">
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fa-regular.css">
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fa-solid.css">
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fontawesome.css">
    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="/panel-assets/vendor/simple-line-icons/css/simple-line-icons.css">
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="/panel-assets/css/bootstrap-rtl.css" id="bscss">
    <!-- SWEET ALERT-->
    <link rel="stylesheet" href="/panel-assets/vendor/sweetalert/dist/sweetalert.css">
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="/panel-assets/css/app-custom.css" id="maincss">
    <link rel="stylesheet" href="/panel-assets/css/app-rtl.css" id="maincss">
    <style>
        body {
            background: url('/panel-assets/img/login-bg.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
        }
        .Aligner {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
<div class="wrapper Aligner">
    <div class="block-center mt-4 wd-xl">
        <!-- START card-->
    @yield('content')
    <!-- END card-->
       {{-- <div class="p-3 text-center text-white">
            <b class="text-shadow">
                <span class="mr-2">&copy;</span>
                <span>2018</span>
                <span class="mr-2">-</span>
                اداره کل فناوری و سامانه های نوین سازمان تنظیم مقررات صوت و تصویر فراگیر
            </b>
        </div>--}}
    </div>
</div>
<!-- =============== VENDOR SCRIPTS ===============-->
<!-- MODERNIZR-->
<script src="/panel-assets/vendor/modernizr/modernizr.custom.js"></script>
<!-- JQUERY-->
<script src="/panel-assets/vendor/jquery/dist/jquery.js"></script>
<!-- BOOTSTRAP-->
<script src="/panel-assets/vendor/bootstrap/dist/js/bootstrap.js"></script>
<!-- STORAGE API-->
<script src="/panel-assets/vendor/js-storage/js.storage.js"></script>
<!-- PARSLEY-->
<script src="/panel-assets/vendor/parsleyjs/dist/parsley.js"></script>
<!-- SWEET ALERT-->
<script src="/panel-assets/vendor/sweetalert/dist/sweetalert.min.js"></script>
<!-- =============== APP SCRIPTS ===============-->
<script src="/panel-assets/js/app.js"></script>

@yield('scripts')

</body>

</html>
