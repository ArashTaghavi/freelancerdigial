@extends('layouts.auth')
@section('scripts')
    @if($errors->any())
        <script type="text/javascript">
            swal({
                title: 'پیام سیستم',
                text: "{{ $errors->first()  }}",
                type: 'error',
                showConfirmButton: false,
                background: 'rgba(0, 0, 0, 0.96)',
                timer: 3000,
            });
        </script>
    @endif
@endsection
<style>
    .text-shadow {
        text-shadow: 0 1px 1px #000;
    }
</style>
@section('content')
    <div class="card card-flat">
        <div class="card-header text-center bg-dark">
            <h5 class="block-center text-white">ورود به پنل کاربری</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('doLogin')}}" class="mb-3" id="loginForm" novalidate>
                @csrf
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input class="form-control border-right-0" name="username" id="username" type="text"
                               placeholder="نام کاربری خود را وارد نمایید." autocomplete="off" required>
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-envelope"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input class="form-control border-right-0" name="password" id="password" type="password"
                               placeholder="کلمه عبور خود را وارد نمایید." required>
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-lock"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center ">
                    <p class="small p-2">برای تغییر کد اعتبارسنجی، روی آن کلیک کنید.</p>
                    <input type="text" id="captcha" name="captcha" class="form-control" placeholder="کد اعتبارسنجی">
                </div>
                <div class="clearfix">
                    <div class="float-right">
                        <a class="text-muted" href="recover.html">فراموشی رمز عبور</a>
                    </div>
                </div>
                <button class="btn btn-block btn-primary mt-3" type="submit">ورود</button>
            </form>
        </div>
    </div>
@endsection
