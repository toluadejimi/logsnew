@extends($activeTemplate . 'layouts.main')
@section('content')
        <!-- Banner End -->
        <div class="account-box">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-7 col-xl-5">
                        <div class="d-flex justify-content-center">
                            <div class="verification-code-wrapper">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('error') }}
                                    </div>
                                @endif

                                <div class="verification-area">
                                    <form action="{{ route('user.password.verify.code') }}" method="POST"
                                          class="submit-form">
                                        @csrf
                                        <p class="mb-3">@lang('A 6 digit verification code sent to your email address')
                                            : {{ showEmailAddress($email) }}</p>
                                        <input type="hidden" name="email" value="{{ $email }}">

                                        <label>Verification Code</label>
                                        <input type="text" name="code" id="verification-code" class="form-control overflow-hidden my-2 mb-4" required autocomplete="off">

                                        <div class="form-group my-3">
                                            <button type="submit" class="btn btn-block" style="color: white; border-radius: 10px;   background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);">@lang('Submit')</button>
                                        </div>

                                        <div class="form-group" style="margin-bottom: 800px">
                                            @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                            <a href="{{ route('user.password.request') }}"
                                               class="text--base">@lang('Try to send again')</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
