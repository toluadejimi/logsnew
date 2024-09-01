@extends($activeTemplate . 'layouts.main')
@section('content')

    <div class="container">


        <div class="flex">
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
        </div>

        <!-- Recent -->
        <div class="mb-5">
            <div class="swiper-btn-center-lr">
                <div class="swiper-container demo-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="#"><img
                                    src="{{ url('') }}/assets/assets2/concept/assets/images/Logplace__1.png" class=""
                                    alt="..." width="100" height="50"></a></div>
                        <div class="swiper-slide"><a href=" https://t.me/logmkp"><img
                                    src="{{ url('') }}/assets/assets2/concept/assets/images/Logplace__2.png"
                                    class="d-block w-100"
                                    alt="..."></a></div>
                        <div class="swiper-slide"><a href="https://tinyurl.com/logsgroup2"><img
                                    src="{{ url('') }}/assets/assets2/concept/assets/images/Logplace__5.png"
                                    class="d-block w-100"
                                    alt="..."></a></div>
                        <div class="swiper-slide"><img
                                src="{{ url('') }}/assets/assets2/concept/assets/images/Logplace__3.png"
                                class="d-block w-100" alt="...">
                        </div>
                        <div class="swiper-slide"><a href="https://t.me/logmarketplacee"><img
                                    src="{{ url('') }}/assets/assets2/concept/assets/images/Logplace__4.png"
                                    class="d-block w-100"
                                    alt="..."></a></div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Recent -->


        <!-- Page Content -->
        <div class="page-content">

            <div class="dashboard-area">


                <!-- Recomended Start -->
                <div class="row">
                    <div style="margin-right: 126px" class="col d-flex justify-content-start">
                        @if ($categories->count())
                            <div class="category-nav">
                                <button class="category-nav__button" style="background: #10113D;"><span
                                        class="search-text text-white">@lang('
                                Category')</span>
                                    <span class="arrow"><i class="las la-angle-down"></i></span>
                                </button>
                                <ul class="dropdown--menu" style="background: #10113D; color:#ffffff">
                                    @foreach ($categories as $category)
                                        <li class="dropdown--menu__item text-white">
                                            <a href="/category-products/{{$category->name}}/{{$category->id}}" class="dropdown--menu__link text-white">  {{$category->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="col d-flex justify-content-end">
                        <h2 class="">Hi, {{ Auth::user()->username ?? "User"}}, </h2>
                    </div>
                </div>
                <div class="row mt-2">

                    <div class="col-xxl-10 col-xl-11">
                        @forelse($categories as $category)
                            @php
                                $products = $category->products;
                            @endphp



                            <div class="catalog-item-wrapper mb-2">

                                <div class="d-grid gap-2 mb-2">
                                    <strong>
                                        <p class="p-2"
                                           style="color: white; border-radius: 10px;   background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);">{{ __($category->name) }}</p>
                                    </strong>
                                </div>


                                <div class="card">
                                    <div class="card-body">


                                        <table class="table table-sm table-responsive-sm">
                                            <thead style="border-radius: 100px; background: #10113D;color: #ffffff;">
                                            <tr class>
                                                <th style="border-radius: 10px 0px 0px 10px;"></th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th></th>
                                                <th style="border-radius: 0px 10px 10px 0px;">Stock</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach ($products->take(5) as $product)
                                                @include($activeTemplate . 'partials/products')
                                            @endforeach

                                            </tbody>


                                        </table>


                                    </div>
                                </div>


                                <div class="col-12  mb-4">
                                    <a style="color:white; border-radius: 10px; background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);"
                                       href="{{ route('category.products', ['search' => request()->search, 'slug' => slug($category->name), 'id' => $category->id]) }}"
                                       class="btn  btn-block">
                                        @lang('View All')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                        </svg>


                                    </a>
                                </div>


                            </div>

                        @empty

                            <div class="empty-data text-center">
                                <div class="thumb">
                                    <img src="{{ asset($activeTemplateTrue . 'images/not-found.png') }}">
                                </div>

                                <h4 class="title">@lang('No result found for "' . request()->search . '"')</h4>
                            </div>
                        @endforelse
                        {{ paginateLinks($categories) }}
                    </div>







                    {{--                    <div class="container">--}}

{{--                        <div class="card p-3">--}}
{{--                            <div class="card-body p-3">--}}
{{--                            </div>--}}


{{--                            <h5>Why do people Buy social media--}}
{{--                                accounts?</h5>--}}
{{--                            <p class="small">A solid social media--}}
{{--                                account can be a powerful tool for--}}
{{--                                branding and marketing.</p>--}}
{{--                            <p class="small">A good social media--}}
{{--                                account--}}
{{--                                has an active and responsive--}}
{{--                                community--}}
{{--                                fired up by the--}}
{{--                                topic or niche that brought them--}}
{{--                                together.</p>--}}
{{--                            <p class="small">Sometimes it makes--}}
{{--                                sense to--}}
{{--                                buy or sell a social media account--}}
{{--                                depending on where--}}
{{--                                you are with your business and how--}}
{{--                                goals--}}
{{--                                have changed and evolved.</p>--}}
{{--                            <p class="small">There is a thriving--}}
{{--                                market--}}
{{--                                for buying/selling social media--}}
{{--                                accounts, but it’s--}}
{{--                                important to know what the best--}}
{{--                                platforms are. </p>--}}

{{--                            <p class="small"><strong>Let’s dig--}}
{{--                                    in!</strong></p>--}}



{{--                        </div>--}}


{{--                        <script>--}}
{{--                            // When the user scrolls down 20px from the top of the document, show the button--}}
{{--                            window.onscroll = function() {scrollFunction()};--}}

{{--                            function scrollFunction() {--}}
{{--                                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {--}}
{{--                                    document.getElementById("scrollToTopBtn").style.display = "block";--}}
{{--                                } else {--}}
{{--                                    document.getElementById("scrollToTopBtn").style.display = "none";--}}
{{--                                }--}}
{{--                            }--}}

{{--                            // When the user clicks on the button, scroll to the top of the document--}}
{{--                            function topFunction() {--}}
{{--                                document.body.scrollTop = 0; // For Safari--}}
{{--                                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera--}}
{{--                            }--}}

{{--                        </script>--}}






{{--                    </div>--}}
                </div>

                <div class="col-12">
                    @auth

                        <div class="card-title mt-3 text-center">
                            <h6 style="background: #565656; padding: 10px; border-radius: 10px; color: white"
                                class="text-left">LAST ORDER</h6>
                        </div>


                        <div style="height:400px; width:100%; overflow-y: scroll;" class="card">
                            <div class="card-body">



                                @if($bought_qty == 0)
                                @else
                                    @foreach($bought as $data)

                                        <div class="row justify-content-around">


                                            <div style="font-size: 10px" class="col">
                                                <svg width="10" height="10" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.61913 13.2708H4.37496C3.37163 13.2708 2.61913 13.0025 2.15246 12.4717C1.6858 11.9408 1.50496 11.1708 1.62746 10.1733L2.15246 5.79833C2.30413 4.50917 2.6308 3.35416 4.9058 3.35416H9.1058C11.375 3.35416 11.7016 4.50917 11.8591 5.79833L12.3841 10.1733C12.5008 11.1708 12.3258 11.9467 11.8591 12.4717C11.375 13.0025 10.6283 13.2708 9.61913 13.2708ZM4.89996 4.22916C3.21996 4.22916 3.13829 4.89416 3.01579 5.89749L2.4908 10.2725C2.4033 11.0133 2.50829 11.5558 2.80579 11.8883C3.10329 12.2208 3.6283 12.39 4.37496 12.39H9.61913C10.3658 12.39 10.8908 12.2208 11.1883 11.8883C11.4858 11.5558 11.5908 11.0133 11.5033 10.2725L10.9783 5.89749C10.8558 4.88832 10.78 4.22916 9.09413 4.22916H4.89996Z"
                                                        fill="url(#paint0_linear_309_90)"/>
                                                    <path
                                                        d="M9.33334 5.10416C9.09417 5.10416 8.89584 4.90583 8.89584 4.66666V2.625C8.89584 1.995 8.505 1.60416 7.87501 1.60416H6.12501C5.49501 1.60416 5.10417 1.995 5.10417 2.625V4.66666C5.10417 4.90583 4.90584 5.10416 4.66667 5.10416C4.42751 5.10416 4.22917 4.90583 4.22917 4.66666V2.625C4.22917 1.51083 5.01084 0.729164 6.12501 0.729164H7.87501C8.98917 0.729164 9.77084 1.51083 9.77084 2.625V4.66666C9.77084 4.90583 9.5725 5.10416 9.33334 5.10416Z"
                                                        fill="url(#paint1_linear_309_90)"/>
                                                    <path
                                                        d="M11.9058 10.3717H4.66667C4.42751 10.3717 4.22917 10.1733 4.22917 9.93418C4.22917 9.69501 4.42751 9.49668 4.66667 9.49668H11.9058C12.145 9.49668 12.3433 9.69501 12.3433 9.93418C12.3433 10.1733 12.145 10.3717 11.9058 10.3717Z"
                                                        fill="url(#paint2_linear_309_90)"/>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_309_90" x1="7.00467"
                                                                        y1="3.35416"
                                                                        x2="7.00467" y2="13.2708"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FF6304"/>
                                                            <stop offset="1" stop-color="#FF1888"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_309_90" x1="7.00001"
                                                                        y1="0.729164"
                                                                        x2="7.00001" y2="5.10416"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FF6304"/>
                                                            <stop offset="1" stop-color="#FF1888"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint2_linear_309_90" x1="8.28626"
                                                                        y1="9.49668"
                                                                        x2="8.28626" y2="10.3717"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FF6304"/>
                                                            <stop offset="1" stop-color="#FF1888"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                {{\Illuminate\Support\Str::limit($data->user_name,4, '.')}}, | <span style="color: #0AC028"> bought </span>|<span>{{\Illuminate\Support\Str::limit($data->item,
                                    16, '...')}}</span>|<span style="color: #FF6304">₦{{number_format($data->amount)}}</span>|<a href="#" style=" font-size: 6px; background: linear-gradient(90deg, #FF6304 0%, #FF0D9B 100%); border-radius: 5px; padding: 3px; color: white">{{ diffForHumans($data->created_at) }}</a>
                                                <hr>
                                            </div>


                                        </div>

                                    @endforeach
                                @endif


                                {{--                            <div class="text-center">--}}
                                {{--                                <p>By purchasing any product, you agree that you are fully aware of these--}}
                                {{--                                    terms/conditions and agree to follow them! 👉🏽<a href="/user/rules"> TERMS AND--}}
                                {{--                                        CONDITIONS</a></p>--}}

                                {{--                            </div>--}}


                            </div>
                        </div>
                    @else

                    @endauth

                </div>

                <div style="border-top: 50px">

                    <div class="card border-0">

                    </div>

                </div>



                <button style="margin-bottom: 70px" class="mb-5" onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i></button>


            </div>


            <style>
                #myBtn {
                        display: none;
                        position: fixed;
                        bottom: -10px;
                        z-index: 70;
                        font-size: 20px;
                        border: none;
                        outline: none;
                        background-color: red;
                        color: white;
                        cursor: pointer;
                        padding: 0;
                        border-radius: 4px;
                        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                        width: 50px;
                        margin-top: 60px;
                        height: 40px;
                }

                #myBtn:hover {
                    background-color: #555; /* Darken background color on hover */
                }
            </style>





{{--            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">--}}
{{--            <a href="#" style="position: sticky;width: 50px; height: 50px;" onclick="topFunction()" data-toggle="modal" data-target="#exampleModalCenter" class="float" target="_blank">--}}
{{--                <i class="fa fa-arrow-up"></i>--}}
{{--            </a>--}}


        </div>


        <script>
            function topFunction() {
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            }

            // Show the button when user scrolls down 20px from the top of the document
            window.onscroll = function() {
                scrollFunction();
            };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    document.getElementById("myBtn").style.display = "block";
                } else {
                    document.getElementById("myBtn").style.display = "none";
                }
            }
        </script>
    </div>



    <style>
        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 80px;
            right: 40px;
            background-color: #000000;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
        }
        .my-float {
            margin-top: 16px;
        }
    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <a style="border-top: 10px; margin-left: 170px"  href="https://t.me/logmkp" class="float my-5" target="_blank">
        <svg width="181" height="40" viewBox="0 0 181 57" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.5227 21.4545V36H10.2273L4.97159 28.358H4.88636V36H0.9375V21.4545H4.28977L9.46023 29.0682H9.57386V21.4545H13.5227Z" fill="#D9D9D9"/>
            <path d="M15.9906 36V21.4545H26.4736V24.6364H19.9395V27.1364H25.9338V30.3182H19.9395V32.8182H26.4452V36H15.9906Z" fill="#D9D9D9"/>
            <path d="M29.032 36V21.4545H39.515V24.6364H32.9809V27.1364H38.9752V30.3182H32.9809V32.8182H39.4866V36H29.032Z" fill="#D9D9D9"/>
            <path d="M47.67 36H42.0734V21.4545H47.6132C49.1094 21.4545 50.402 21.7457 51.4911 22.3281C52.5848 22.9058 53.4276 23.7391 54.0195 24.8281C54.616 25.9124 54.9143 27.2121 54.9143 28.7273C54.9143 30.2424 54.6184 31.5445 54.0266 32.6335C53.4347 33.7178 52.5966 34.5511 51.5124 35.1335C50.4281 35.7112 49.1473 36 47.67 36ZM46.0223 32.6477H47.528C48.2477 32.6477 48.8608 32.5317 49.3675 32.2997C49.8788 32.0677 50.2671 31.6676 50.5322 31.0994C50.8021 30.5313 50.9371 29.7405 50.9371 28.7273C50.9371 27.714 50.7998 26.9233 50.5251 26.3551C50.2553 25.7869 49.8575 25.3868 49.332 25.1548C48.8111 24.9228 48.1719 24.8068 47.4143 24.8068H46.0223V32.6477Z" fill="#D9D9D9"/>
            <path d="M61.9258 36V21.4545H65.8746V27.1364H71.1019V21.4545H75.0508V36H71.1019V30.3182H65.8746V36H61.9258Z" fill="#D9D9D9"/>
            <path d="M77.5258 36V21.4545H88.0087V24.6364H81.4746V27.1364H87.469V30.3182H81.4746V32.8182H87.9803V36H77.5258Z" fill="#D9D9D9"/>
            <path d="M90.5672 36V21.4545H94.516V32.8182H100.397V36H90.5672Z" fill="#D9D9D9"/>
            <path d="M102.593 36V21.4545H108.871C109.951 21.4545 110.896 21.6676 111.705 22.0938C112.515 22.5199 113.145 23.1188 113.594 23.8906C114.044 24.6624 114.269 25.5644 114.269 26.5966C114.269 27.6383 114.037 28.5402 113.573 29.3026C113.114 30.0649 112.467 30.652 111.634 31.0639C110.806 31.4759 109.837 31.6818 108.729 31.6818H104.979V28.6136H107.934C108.398 28.6136 108.793 28.5331 109.12 28.3722C109.451 28.2064 109.705 27.9721 109.88 27.669C110.06 27.366 110.15 27.0085 110.15 26.5966C110.15 26.1799 110.06 25.8248 109.88 25.5312C109.705 25.233 109.451 25.0057 109.12 24.8494C108.793 24.6884 108.398 24.608 107.934 24.608H106.542V36H102.593Z" fill="#D9D9D9"/>
            <path d="M181 28.5C181 44.2401 168.177 57 152.359 57C136.541 57 123.717 44.2401 123.717 28.5C123.717 12.7599 136.541 0 152.359 0C168.177 0 181 12.7599 181 28.5Z" fill="#D9D9D9"/>
            <path d="M142.119 21.6041C142.119 19.0438 143.198 16.5884 145.118 14.7781C147.038 12.9677 149.643 11.9506 152.359 11.9506C155.075 11.9506 157.679 12.9677 159.6 14.7781C161.52 16.5884 162.599 19.0438 162.599 21.6041C162.599 21.9699 162.753 22.3206 163.027 22.5793C163.302 22.8379 163.674 22.9832 164.062 22.9832C164.45 22.9832 164.822 22.8379 165.096 22.5793C165.37 22.3206 165.524 21.9699 165.524 21.6041C165.524 19.4874 164.95 17.4059 163.856 15.5575C162.762 13.7091 161.184 12.1552 159.274 11.0434C157.363 9.93164 155.183 9.29901 152.939 9.20563C150.696 9.11226 148.465 9.56124 146.458 10.5099C144.451 11.4586 142.734 12.8754 141.472 14.6257C140.209 16.376 139.442 18.4017 139.244 20.5101C139.046 22.6186 139.423 24.7397 140.34 26.672C141.257 28.6043 142.682 30.2835 144.481 31.55C146.024 32.6364 147.801 33.3905 149.686 33.7592C149.948 34.3131 150.396 34.7701 150.961 35.0596C151.526 35.3491 152.177 35.455 152.813 35.3608C153.448 35.2667 154.033 34.9778 154.476 34.5388C154.92 34.0998 155.198 33.5352 155.267 32.9323C155.336 32.3294 155.193 31.7219 154.858 31.2037C154.524 30.6856 154.019 30.2856 153.419 30.0657C152.82 29.8458 152.16 29.8183 151.542 29.9874C150.925 30.1565 150.383 30.5128 150.002 31.0011C147.757 30.5007 145.758 29.3005 144.327 27.595C142.896 25.8895 142.118 23.7785 142.119 21.6041ZM143.582 21.6041C143.582 20.0819 144.028 18.5893 144.87 17.2906C145.713 15.9919 146.919 14.9374 148.356 14.2432C149.793 13.549 151.405 13.2419 153.015 13.3558C154.626 13.4697 156.171 14.0001 157.482 14.8887C158.793 15.7773 159.819 16.9896 160.446 18.3923C161.074 19.7949 161.278 21.3335 161.038 22.8388C160.798 24.3441 160.122 25.7576 159.084 26.924C158.046 28.0904 156.688 28.9643 155.157 29.4496C154.37 28.8355 153.38 28.4994 152.359 28.4995C151.295 28.4995 150.321 28.8566 149.56 29.4496C147.818 28.897 146.303 27.8425 145.23 26.4348C144.158 25.0271 143.581 23.3374 143.582 21.6041ZM152.359 36.7739C153.061 36.7742 153.753 36.6157 154.377 36.3116C155.001 36.0075 155.538 35.5667 155.944 35.0262C156.349 34.4857 156.611 33.8614 156.708 33.2056C156.804 32.5498 156.733 31.8818 156.499 31.2576H164.793C166.151 31.2576 167.453 31.7661 168.413 32.6713C169.374 33.5765 169.913 34.8042 169.913 36.0844V36.7739C169.913 40.074 167.685 42.8652 164.522 44.7628C161.342 46.6715 157.037 47.8064 152.359 47.8064C147.68 47.8064 143.377 46.6715 140.195 44.7628C137.032 42.8652 134.804 40.074 134.804 36.7739V36.0844C134.804 34.8042 135.344 33.5765 136.304 32.6713C137.264 31.7661 138.566 31.2576 139.924 31.2576H141.912C143.783 33.0585 146.142 34.3416 148.732 34.9673C149.522 36.0582 150.853 36.7739 152.359 36.7739Z" fill="black"/>
        </svg>
    </a>




@endsection




