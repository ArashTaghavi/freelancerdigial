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
            <h5 class="block-center text-white">ثبت نام</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('doRegister')}}" class="mb-3" id="loginForm" novalidate>
                @csrf
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input class="form-control border-right-0" name="first_name" id="first_name" type="text"
                               placeholder="نام خود را وارد نمایید." autocomplete="off">
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-envelope"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input class="form-control border-right-0" name="last_name" id="last_name" type="text"
                               placeholder="نام خانوادگی خود را وارد نمایید." autocomplete="off">
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-envelope"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input class="form-control border-right-0" name="username" id="username" type="text"
                               placeholder="نام کاربری خود را وارد نمایید." autocomplete="off">
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-envelope"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input class="form-control border-right-0" name="email" id="email" type="text"
                               placeholder="ایمیل خود را وارد نمایید." autocomplete="off">
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
                               placeholder="کلمه عبور خود را وارد نمایید.">
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-lock"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group with-focus">
                        <input class="form-control border-right-0" name="password_confirmation" id="password_confirmation" type="password"
                               placeholder="تکرار کلمه عبور خود را وارد نمایید.">
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-lock"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group with-focus">
                        <select name="type" class="form-control" id="user_type">
                            <option value="<?=\App\User::USER?>">شرکت</option>
                            <option value="<?=\App\User::TEAM?>">تیم</option>
                            <option value="<?=\App\User::CLIENT?>">فریلنسر</option>
                        </select>
                        <div class="input-group-append">
                           <span class="input-group-text text-muted bg-transparent border-left-0">
                              <em class="fa fa-lock"></em>
                           </span>
                        </div>
                    </div>
                </div>
                <button class="btn btn-block btn-primary mt-3" type="submit">ثبت نام</button>
            </form>
        </div>
    </div>
@endsection
