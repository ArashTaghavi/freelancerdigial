<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body>

<div>
    Normal Form
    <form method="POST" action="/verify">
        @csrf
        {!!  GoogleReCaptchaV3::renderField('contact_us_id','contact_us_action') !!}
        <input type="submit" value="submit">
    </form>
</div>

<hr>
Ajax Form
<form method="POST" action="/verify">
    @csrf
    {!!  GoogleReCaptchaV3::renderField('contact_us_ajax_id','contact_us_action') !!}
    <button id="test">Submit</button>
</form>
</div>
</body>

<script>
    $("#test").click(function (e) {
        console.log('11');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/verify',
            data: {
                'g-recaptcha-response': getReCaptchaV3Response('contact_us_ajax_id')
            },
            success: function (data) {
                refreshReCaptchaV3('contact_us_ajax_id', 'contact_us_action');
            },
            error: function (err) {
                refreshReCaptchaV3('contact_us_ajax_id', 'contact_us_action');
            }
        });
    });
</script>

{!!  GoogleReCaptchaV3::init() !!}
</html>
