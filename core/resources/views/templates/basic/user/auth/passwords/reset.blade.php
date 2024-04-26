@extends($activeTemplate . 'layouts.main')
@section('content')

    <!-- Page Content -->
    <div class="page-content">

        <!-- Banner -->
        <div class="banner-wrapper">

            <div class="container inner-wrapper">
                <a href="/">
                <img src="{{url('')}}/assets/assets/images/logo.svg" width="300" height="250">
                </a>
                <p class="mb-0">Change Password</p>
            </div>


        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="mb-4">
                                <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                            </div>
                            <form method="POST" action="{{ route('user.password.update') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label class="my-2">@lang('Password')</label>
                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control @if ($general->secure_password) secure-password @endif"
                                               name="password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="my-2">@lang('Confirm Password')</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" style="color: white; border-radius: 10px;   background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);" class="btn btn-block" style="background: linear-gradient(90deg, #0F0673 0%, #B00BD9 100%); color: white;">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
