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




                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
                    <a href="#" style="position: sticky;width: 50px; height: 50px;" onclick="topFunction()" data-toggle="modal" data-target="#exampleModalCenter" class="float" target="_blank">
                        <i class="fa fa-arrow-up"></i>
                    </a>


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
            </div>

        </div>
    </div>



@endsection




