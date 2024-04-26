@extends($activeTemplate . 'layouts.main')
@section('content')

    <div style="padding-bottom: 300px" class="container min-vh-100>
        <div class=" flex">

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
    @if (session()->has('order'))
        <div class="alert alert-success">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Item purchased successfully!</strong><a href="{{ $url_data }}"> CLICK HERE TO VIEW YOUR
                    ORDER 👉🏽
                    DOWNLOAD.</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif


    <div class="d-flex justify-content-center">

        <svg width="78" height="78" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle opacity="0.150087" cx="39" cy="39" r="39" fill="#10113D"/>
            <path
                d="M38.994 44.7993C30.3363 44.7993 22.9412 46.1643 22.9412 51.6243C22.9412 57.0863 30.2901 58.4995 38.994 58.4995C47.6517 58.4995 55.0468 57.1365 55.0468 51.6745C55.0468 46.2125 47.6999 44.7993 38.994 44.7993Z"
                fill="#FF0B9E"/>
            <path opacity="0.4"
                  d="M38.9939 39.599C44.8915 39.599 49.6169 34.8717 49.6169 28.9761C49.6169 23.0805 44.8915 18.3532 38.9939 18.3532C33.0983 18.3532 28.371 23.0805 28.371 28.9761C28.371 34.8717 33.0983 39.599 38.9939 39.599Z"
                  fill="#FF0B9E"/>
        </svg>


    </div>

    <div class="d-flex justify-content-center mt-3">
        <strong> {{Auth::user()->username}}</strong>
    </div>

    <div class="d-flex justify-content-center mt-1">
        <strong> {{Auth::user()->email}}</strong>
    </div>


    <div class="card my-3">
        <div class="card-body">
            <div class="d-flex justify-content-start col-lg-12  col-sm-12 p-3 my-3 text-black-50">
                <svg class="mr-3" width="40" height="41" viewBox="0 0 40 41" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.05" cx="20" cy="20.92" r="20" fill="#0601B4"/>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M19.9873 23.7086C16.7643 23.7086 14.0119 24.1959 14.0119 26.1475C14.0119 28.099 16.7468 28.6038 19.9873 28.6038C23.2103 28.6038 25.9619 28.1157 25.9619 26.1649C25.9619 24.2141 23.2278 23.7086 19.9873 23.7086Z"
                          stroke="#161455" stroke-linecap="round" stroke-linejoin="round"/>
                    <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                          d="M19.9873 20.9249C22.1024 20.9249 23.8167 19.2098 23.8167 17.0948C23.8167 14.9797 22.1024 13.2654 19.9873 13.2654C17.8722 13.2654 16.1571 14.9797 16.1571 17.0948C16.15 19.2027 17.8532 20.9178 19.9603 20.9249H19.9873Z"
                          stroke="#161455" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="lh-100">
                    <h6 class="mb-0 text-black lh-100">Total Spent</h6>
                    <small>NGN {{ number_format($spent, 2) }}</small>
                </div>
            </div>


            <div class="d-flex align-items-center p-3 my-3 text-black-50 bg-purple rounded box-shadow">
                <svg class="mr-3" width="40" height="41" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.05" cx="20" cy="20.92" r="20" fill="#0601B4"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.7209 15.1899C26.085 15.3174 26.3284 15.6607 26.3284 16.0465V21.6907C26.3284 23.2682 25.755 24.774 24.7425 25.9407C24.2334 26.5282 23.5892 26.9857 22.905 27.3557L19.94 28.9574L16.97 27.3549C16.285 26.9849 15.64 26.5282 15.13 25.9399C14.1167 24.7732 13.5417 23.2665 13.5417 21.6874V16.0465C13.5417 15.6607 13.785 15.3174 14.1492 15.1899L19.6342 13.2624C19.8292 13.194 20.0417 13.194 20.2359 13.2624L25.7209 15.1899Z" stroke="#161455" stroke-linecap="round" stroke-linejoin="round"/>
                    <path opacity="0.4" d="M17.7688 20.8515L19.3455 22.429L22.5938 19.1807" stroke="#161455" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <div class="lh-100">
                    <h6 class="mb-0 text-black lh-100">Change Password</h6>
                    <a href="change-password"><small>Click to change your password</small></a>
                </div>
            </div>


            <div class="d-flex align-items-center p-3 my-3 text-black-50 bg-purple rounded box-shadow">
                <a href="logout">
                    <svg class="mr-3"  width="40" height="41" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle opacity="0.05" cx="20" cy="20.92" r="20" fill="#555555"/>
                        <path opacity="0.4" d="M22.5133 17.0779V16.3004C22.5133 14.6046 21.1383 13.2296 19.4425 13.2296H15.38C13.685 13.2296 12.31 14.6046 12.31 16.3004V25.5754C12.31 27.2712 13.685 28.6463 15.38 28.6463H19.4508C21.1417 28.6463 22.5133 27.2754 22.5133 25.5846V24.7988" stroke="#10113D" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M28.1746 20.9378H18.1404" stroke="#10113D" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M25.7343 18.5086L28.1743 20.9377L25.7343 23.3677" stroke="#10113D" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>


                <div class="lh-100">
                    <h6 class="mb-0 text-black lh-100">Log Out</h6>
                    <a href="/logout"><small>Click Here to Log Out</small></a>
                </div>
            </div>

        </div>
    </div>



@endsection
