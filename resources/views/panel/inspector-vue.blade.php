<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Bootstrap Admin App + jQuery">
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>پنل کاربر - مدیریت ارزیابی</title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="/panel-assets/css/iziToast.min.css">
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fa-brands.css">
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fa-regular.css">
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fa-solid.css">
    <link rel="stylesheet" href="/panel-assets/vendor/_40fortawesome/fontawesome-free-webfonts/css/fontawesome.css">
    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="/panel-assets/vendor/simple-line-icons/css/simple-line-icons.css">
    <!-- ANIMATE.CSS-->
    <link rel="stylesheet" href="/panel-assets/vendor/animate.css/animate.css">
    <!-- WHIRL (spinners)-->
    <link rel="stylesheet" href="/panel-assets/vendor/whirl/dist/whirl.css">
    <link rel="stylesheet" href="/panel-assets/vendor/loaders.css/loaders.css">
    <!-- =============== PAGE VENDOR STYLES ===============-->
    <!-- WEATHER ICONS-->
    <link rel="stylesheet" href="/panel-assets/vendor/weather-icons/css/weather-icons.css">
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="/panel-assets/css/bootstrap-rtl.css" id="bscss">
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="/panel-assets/css/app-rtl.css" id="maincss">
    <link rel="stylesheet" href="/panel-assets/css/zdmi/css/material-design-iconic-font.css" id="maincss">
    <link rel="stylesheet" href="/panel-assets/vendor/select2/dist/css/select2.min.css" id="maincss">
    <link rel="stylesheet" href="/panel-assets/vendor/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="/panel-assets/css/bootstrap-select.min.css">
    <script src="/panel-assets/vendor/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        .box-shadow {
            box-shadow: 0 0 10px 5px #ccc
        }

        .zmdi-close {
            cursor: pointer;
        }
    </style>

</head>
<body>
<div id="app" class="wrapper">
    <app></app>
</div>

<!-- =============== VENDOR SCRIPTS ===============-->
<!-- MODERNIZR-->
<script src="/panel-assets/vendor/modernizr/modernizr.custom.js"></script>
<!-- JQUERY-->
<script src="/panel-assets/vendor/jquery/dist/jquery.js"></script>
<!-- BOOTSTRAP-->
<script src="/panel-assets/vendor/popper.js/dist/umd/popper.js"></script>
<script src="/panel-assets/vendor/bootstrap/dist/js/bootstrap.js"></script>
<!-- STORAGE API-->
<script src="/panel-assets/vendor/js-storage/js.storage.js"></script>
<!-- JQUERY EASING-->
<script src="/panel-assets/vendor/jquery.easing/jquery.easing.js"></script>
<!-- ANIMO-->
<script src="/panel-assets/vendor/animo/animo.js"></script>
<!-- SCREENFULL-->
<script src="/panel-assets/vendor/screenfull/dist/screenfull.js"></script>
<!-- =============== PAGE VENDOR SCRIPTS ===============-->
<!-- SLIMSCROLL-->
<script src="/panel-assets/vendor/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- SPARKLINE-->
<script src="/panel-assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
<!-- EASY PIE CHART-->
<script src="/panel-assets/vendor/easy-pie-chart/dist/jquery.easypiechart.js"></script>
<script src="/panel-assets/vendor/select2/dist/js/select2.full.js"></script>
<script src="/panel-assets/js/iziToast.min.js"></script>
<script src="/panel-assets/vendor/jquery-localize/dist/jquery.localize.js"></script>
<script src="/panel-assets/js/app.js"></script>



<!-- MOMENT JS-->
<!-- =============== APP SCRIPTS ===============-->

{{--<script id="app-data" type="application/json">
    {!! json_encode([
    'allPermissions'=>$all_permissions,
    'userPermissions'=>$user_permissions,
    'isSUPERADMIN'=>$is_super_admin,
    'userChart'=>$user_chart,
    'userInfo'=>$user_info
    ]) !!}
</script>--}}
<script src="/panel-assets/ckeditor/ckeditor.js"></script>
<script src="/inspector-js/app.js"></script>

</body>
</html>
