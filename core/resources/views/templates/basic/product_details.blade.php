@extends($activeTemplate . 'layouts.main')
@section('content')

    <div class="container">

        <style>
            div#social-links {
                margin: 0 auto;
                max-width: 500px;
            }

            div#social-links ul li {
                display: inline-block;
            }

            div#social-links ul li a {
                padding: 10px;
                border: 1px solid #fff;
                margin: 2.5px;
                font-size: 20px;
                color: #222;
                background-color: #ff087c;
                border-radius: 10px;
                color: white;
            }
        </style>

        <!-- section start -->

            <div class="container" style="padding-bottom: 0px">
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
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">

                        <div class="card">


                            <div class="card-body">


                                <div class="product-right">


                                    <div class="page-content">
                                        <div class="d-flex justify-content-center my-4">
                                            <img class="my-2"
                                                 src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}"
                                                 width="100px" height="100px">
                                        </div>
                                    </div>


                                    <div class="detail-content mb-3 p-4 ">
                                        <div class="flex-1 mb-3">
                                            <h4>{{ __($product->name) }}</h4>
                                            <p>@php echo $product->description; @endphp</p>
                                            <input class="border-0 w-0 text-white"
                                                   style="border-right: 0px; font-size: 1px; color: white;"
                                                   id="element" value="@php echo $product->description; @endphp">
                                            <button class="copy-button form-control3"
                                                    onclick="copyToClipboard()">

                                                Copy Description
                                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.2"
                                                          d="M14.3438 2.5V10.5H11.1562V5.5H5.84375V2.5H14.3438Z"
                                                          fill="#0F0673"/>
                                                    <path
                                                        d="M14.3438 2H5.84375C5.70285 2 5.56773 2.05268 5.4681 2.14645C5.36847 2.24021 5.3125 2.36739 5.3125 2.5V5H2.65625C2.51535 5 2.38023 5.05268 2.2806 5.14645C2.18097 5.24021 2.125 5.36739 2.125 5.5V13.5C2.125 13.6326 2.18097 13.7598 2.2806 13.8536C2.38023 13.9473 2.51535 14 2.65625 14H11.1562C11.2971 14 11.4323 13.9473 11.5319 13.8536C11.6315 13.7598 11.6875 13.6326 11.6875 13.5V11H14.3438C14.4846 11 14.6198 10.9473 14.7194 10.8536C14.819 10.7598 14.875 10.6326 14.875 10.5V2.5C14.875 2.36739 14.819 2.24021 14.7194 2.14645C14.6198 2.05268 14.4846 2 14.3438 2ZM10.625 13H3.1875V6H10.625V13ZM13.8125 10H11.6875V5.5C11.6875 5.36739 11.6315 5.24021 11.5319 5.14645C11.4323 5.05268 11.2971 5 11.1562 5H6.375V3H13.8125V10Z"
                                                        fill="#0F0673"/>
                                                </svg>
                                            </button>
                                            <span id="message"></span>
                                        </div>

                                        <div class="detail-content mb-2">
                                            <div class="flex-1">

                                                <div class="row"
                                                     style="background: rgba(255,100,3,0.18); border-radius: 10px">
                                                    <div class="col-6">
                                                        <h6 class="d-flex justify-content-center my-2">Quantity</h6>
                                                    </div>

                                                    <div class="col-6">
                                                        <h6 class="d-flex justify-content-center my-2">Price</h6>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>

                                        <div class="detail-content">
                                            <div class="flex-1">

                                                <div class="row" style="background: #F2F2F2; border-radius: 10px">
                                                    <div class="col-6">
                                                        <h6 style="color: #ff4518"
                                                            class="d-flex justify-content-center my-2">{{ $product->in_stock }}
                                                            pcs</h6>
                                                    </div>

                                                    <div class="col-6">
                                                        <h6 style="color: #ff4518"
                                                            class="d-flex justify-content-center my-2">
                                                            ₦{{ number_format($product->price) }}</h6>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                    <button type="#" data-toggle="modal" data-target="#exampleModalCenter"
                                            style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                                            class="btn btn-block">
                                        <svg width="67" height="15" viewBox="0 0 67 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.868081 12V3.81818H3.72852C4.29848 3.81818 4.76856 3.91673 5.13877 4.11381C5.50897 4.30824 5.78463 4.57058 5.96574 4.90083C6.14685 5.22843 6.2374 5.59197 6.2374 5.99148C6.2374 6.34304 6.17481 6.63334 6.04963 6.86239C5.92712 7.09144 5.76465 7.27255 5.56224 7.40572C5.36249 7.53888 5.14542 7.63743 4.91105 7.70135V7.78125C5.1614 7.79723 5.41309 7.88512 5.66611 8.04492C5.91913 8.20472 6.13087 8.43377 6.30132 8.73207C6.47177 9.03036 6.557 9.39524 6.557 9.8267C6.557 10.2369 6.46378 10.6057 6.27735 10.9333C6.09091 11.2609 5.79661 11.5206 5.39445 11.7124C4.99228 11.9041 4.46893 12 3.8244 12H0.868081ZM1.85885 11.1211H3.8244C4.4716 11.1211 4.93102 10.9959 5.20269 10.7456C5.47701 10.4925 5.61417 10.1863 5.61417 9.8267C5.61417 9.54972 5.5436 9.29403 5.40244 9.05966C5.26128 8.82262 5.0602 8.63352 4.79919 8.49236C4.53818 8.34854 4.22923 8.27663 3.87234 8.27663H1.85885V11.1211ZM1.85885 7.41371H3.69656C3.99486 7.41371 4.26385 7.35511 4.50356 7.23793C4.74592 7.12074 4.93768 6.95561 5.07884 6.74254C5.22266 6.52947 5.29457 6.27912 5.29457 5.99148C5.29457 5.63192 5.16939 5.32697 4.91904 5.07662C4.66868 4.8236 4.27185 4.69709 3.72852 4.69709H1.85885V7.41371ZM11.9243 9.49112V5.86364H12.8671V12H11.9243V10.9613H11.8604C11.7166 11.2729 11.4929 11.5379 11.1892 11.7563C10.8856 11.972 10.5021 12.0799 10.0387 12.0799C9.65515 12.0799 9.31424 11.996 9.01594 11.8282C8.71765 11.6578 8.48327 11.4021 8.31282 11.0612C8.14236 10.7176 8.05713 10.2848 8.05713 9.76278V5.86364H8.99996V9.69886C8.99996 10.1463 9.12514 10.5032 9.37549 10.7695C9.62851 11.0359 9.95078 11.169 10.3423 11.169C10.5767 11.169 10.815 11.1091 11.0574 10.9893C11.3024 10.8694 11.5075 10.6856 11.6726 10.4379C11.8404 10.1903 11.9243 9.87464 11.9243 9.49112ZM15.2012 14.3011C15.0414 14.3011 14.899 14.2878 14.7738 14.2612C14.6486 14.2372 14.562 14.2132 14.5141 14.1893L14.7538 13.3583C14.9828 13.4169 15.1853 13.4382 15.361 13.4222C15.5368 13.4062 15.6926 13.3277 15.8285 13.1865C15.967 13.048 16.0935 12.823 16.208 12.5114L16.3838 12.032L14.1146 5.86364H15.1373L16.8312 10.7536H16.8951L18.589 5.86364H19.6118L17.007 12.8949C16.8898 13.2118 16.7447 13.4742 16.5715 13.6819C16.3984 13.8923 16.1973 14.0481 15.9683 14.1493C15.7419 14.2505 15.4862 14.3011 15.2012 14.3011ZM24.9631 8.30859V12H24.0203V5.86364H24.9311V6.82244H25.011C25.1549 6.51083 25.3733 6.26048 25.6662 6.07138C25.9592 5.87962 26.3374 5.78374 26.8008 5.78374C27.2163 5.78374 27.5798 5.86896 27.8915 6.03942C28.2031 6.20721 28.4454 6.46289 28.6185 6.80646C28.7917 7.14737 28.8782 7.57884 28.8782 8.10085V12H27.9354V8.16477C27.9354 7.68271 27.8102 7.30717 27.5599 7.03817C27.3095 6.76651 26.9659 6.63068 26.5291 6.63068C26.2282 6.63068 25.9592 6.69593 25.7222 6.82644C25.4878 6.95694 25.3027 7.14737 25.1668 7.39773C25.031 7.64808 24.9631 7.9517 24.9631 8.30859ZM33.094 12.1278C32.54 12.1278 32.0539 11.996 31.6358 11.7323C31.2203 11.4687 30.8954 11.0998 30.661 10.6257C30.4293 10.1516 30.3134 9.59766 30.3134 8.96378C30.3134 8.32457 30.4293 7.7666 30.661 7.28986C30.8954 6.81312 31.2203 6.44292 31.6358 6.17924C32.0539 5.91557 32.54 5.78374 33.094 5.78374C33.648 5.78374 34.1327 5.91557 34.5482 6.17924C34.9663 6.44292 35.2912 6.81312 35.523 7.28986C35.7573 7.7666 35.8745 8.32457 35.8745 8.96378C35.8745 9.59766 35.7573 10.1516 35.523 10.6257C35.2912 11.0998 34.9663 11.4687 34.5482 11.7323C34.1327 11.996 33.648 12.1278 33.094 12.1278ZM33.094 11.2809C33.5148 11.2809 33.861 11.173 34.1327 10.9573C34.4043 10.7416 34.6054 10.4579 34.7359 10.1064C34.8664 9.75479 34.9317 9.37393 34.9317 8.96378C34.9317 8.55362 34.8664 8.17143 34.7359 7.81721C34.6054 7.46298 34.4043 7.17667 34.1327 6.95827C33.861 6.73988 33.5148 6.63068 33.094 6.63068C32.6732 6.63068 32.3269 6.73988 32.0553 6.95827C31.7836 7.17667 31.5825 7.46298 31.452 7.81721C31.3215 8.17143 31.2563 8.55362 31.2563 8.96378C31.2563 9.37393 31.3215 9.75479 31.452 10.1064C31.5825 10.4579 31.7836 10.7416 32.0553 10.9573C32.3269 11.173 32.6732 11.2809 33.094 11.2809ZM38.4953 12L36.6256 5.86364H37.6163L38.9427 10.5618H39.0066L40.317 5.86364H41.3237L42.6181 10.5458H42.682L44.0084 5.86364H44.9992L43.1295 12H42.2026L40.8603 7.28587H40.7644L39.4221 12H38.4953Z"
                                                fill="white"/>
                                            <path
                                                d="M61.6491 13.9708H56.405C55.4016 13.9708 54.6491 13.7025 54.1825 13.1716C53.7158 12.6408 53.535 11.8708 53.6575 10.8733L54.1825 6.49828C54.3341 5.20912 54.6608 4.05412 56.9358 4.05412H61.1358C63.405 4.05412 63.7316 5.20912 63.8891 6.49828L64.4141 10.8733C64.5308 11.8708 64.3558 12.6466 63.8891 13.1716C63.405 13.7025 62.6583 13.9708 61.6491 13.9708ZM56.93 4.92912C55.25 4.92912 55.1683 5.59411 55.0458 6.59744L54.5208 10.9724C54.4333 11.7133 54.5383 12.2558 54.8358 12.5883C55.1333 12.9208 55.6583 13.0899 56.405 13.0899H61.6491C62.3958 13.0899 62.9208 12.9208 63.2183 12.5883C63.5158 12.2558 63.6208 11.7133 63.5333 10.9724L63.0083 6.59744C62.8858 5.58827 62.81 4.92912 61.1241 4.92912H56.93Z"
                                                fill="white"/>
                                            <path
                                                d="M61.3633 5.80412C61.1242 5.80412 60.9258 5.60578 60.9258 5.36662V3.32495C60.9258 2.69495 60.535 2.30412 59.905 2.30412H58.155C57.525 2.30412 57.1342 2.69495 57.1342 3.32495V5.36662C57.1342 5.60578 56.9358 5.80412 56.6967 5.80412C56.4575 5.80412 56.2592 5.60578 56.2592 5.36662V3.32495C56.2592 2.21078 57.0408 1.42912 58.155 1.42912H59.905C61.0192 1.42912 61.8008 2.21078 61.8008 3.32495V5.36662C61.8008 5.60578 61.6025 5.80412 61.3633 5.80412Z"
                                                fill="white"/>
                                            <path
                                                d="M63.9358 11.0716H56.6967C56.4575 11.0716 56.2592 10.8733 56.2592 10.6341C56.2592 10.395 56.4575 10.1966 56.6967 10.1966H63.9358C64.175 10.1966 64.3733 10.395 64.3733 10.6341C64.3733 10.8733 64.175 11.0716 63.9358 11.0716Z"
                                                fill="white"/>
                                        </svg>


                                    </button>


                                    <script>

                                        function copyToClipboard() {
                                            var textToCopy = document.getElementById("element");
                                            var copyMessage = document.getElementById("message");

                                            //Select the text
                                            textToCopy.select();
                                            textToCopy.setSelectionRange(0, 99999); // For mobile devices

                                            // Copy the selected text
                                            document.execCommand("copy");

                                            // Deselect the text
                                            textToCopy.blur();

                                            // Display copy message
                                            copyMessage.innerText = "Text copied!";

                                            // Clear message after 2 seconds
                                            setTimeout(function () {
                                                copyMessage.innerText = "";
                                            }, 2000);

                                        }
                                    </script>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mt-2">
                                                <h5 style="color: #ff407b; font-size: 16px;" class="mt-5">
                                                </h5>
                                                <h5 style="color: #ff407b; font-size: 16px; margin-bottom: 2px"
                                                    class="mt-3">Hello
                                                    @auth
                                                        {{Auth::user()->username ?? "User"}}
                                                    @else
                                                        User,
                                                    @endauth
                                                </h5>
                                                <h6>You are about to order</h6>

                                                <div class="mt-4">
                                                    <h2 style="font-size: 18px">Order details</h2>
                                                </div>


                                                <div class="row mt-2">
                                                    <div class="col-3">
                                                        <img class=""
                                                             src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}"
                                                             width="100px" height="100px">
                                                    </div>
                                                    <div class="col-1">

                                                    </div>

                                                    <div class="col-8">
                                                        <h4>{{ __($product->name) }}</h4>
                                                        <h6 class="text-muted" style="font-size: 10px;">The account
                                                            format includes username,
                                                            password, email, and email password.</h6>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row mt-5">
                                                    <div class="col-6">
                                                        <button style="background-color: #4d4d4d; color: white"
                                                                class="btn"
                                                                onclick="decrementQuantity()">-
                                                        </button>
                                                        <span class="p-2" id="quantity">1</span>
                                                        <button style="background-color: #FF0B9E; color: white"
                                                                class="btn"
                                                                onclick="incrementQuantity()">+
                                                        </button>
                                                    </div>

                                                    <div class="col-6">
                                                        <button type="button"
                                                                style="background-color: #10113D; color: white"
                                                                class="btn btn-block">₦<span id="total">10.00</span>
                                                        </button>

                                                    </div>
                                                </div>


                                                <hr>


                                                <form action="{{ route('user.deposit.insert') }}" method="POST">
                                                    @csrf

                                                    <h6 class="">Have a coupon?</h6>
                                                    <input class="form-control4 mb-3 p-1" name="coupon_code" type="text"
                                                           placeholder="Enter Coupon Code">

                                                    <input type="text" hidden id="quantityInput" name="qty" value="1">
                                                    <input type="text" hidden name="id" value="{{$product->id}}">
                                                    <input type="text" hidden type="text" name="payment" value="wallet">
                                                    <input type="text" hidden name="gateway" value="250">


                                                    @if($product->in_stock == 0)
                                                        <button disabled type="submit"
                                                                style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                                                                class="btn btn-block">Out of stock
                                                        </button>
                                                    @else

                                                        <button type="submit"
                                                                style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                                                                class="btn btn-block">
                                                            <svg width="67" height="15" viewBox="0 0 67 15" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.868081 12V3.81818H3.72852C4.29848 3.81818 4.76856 3.91673 5.13877 4.11381C5.50897 4.30824 5.78463 4.57058 5.96574 4.90083C6.14685 5.22843 6.2374 5.59197 6.2374 5.99148C6.2374 6.34304 6.17481 6.63334 6.04963 6.86239C5.92712 7.09144 5.76465 7.27255 5.56224 7.40572C5.36249 7.53888 5.14542 7.63743 4.91105 7.70135V7.78125C5.1614 7.79723 5.41309 7.88512 5.66611 8.04492C5.91913 8.20472 6.13087 8.43377 6.30132 8.73207C6.47177 9.03036 6.557 9.39524 6.557 9.8267C6.557 10.2369 6.46378 10.6057 6.27735 10.9333C6.09091 11.2609 5.79661 11.5206 5.39445 11.7124C4.99228 11.9041 4.46893 12 3.8244 12H0.868081ZM1.85885 11.1211H3.8244C4.4716 11.1211 4.93102 10.9959 5.20269 10.7456C5.47701 10.4925 5.61417 10.1863 5.61417 9.8267C5.61417 9.54972 5.5436 9.29403 5.40244 9.05966C5.26128 8.82262 5.0602 8.63352 4.79919 8.49236C4.53818 8.34854 4.22923 8.27663 3.87234 8.27663H1.85885V11.1211ZM1.85885 7.41371H3.69656C3.99486 7.41371 4.26385 7.35511 4.50356 7.23793C4.74592 7.12074 4.93768 6.95561 5.07884 6.74254C5.22266 6.52947 5.29457 6.27912 5.29457 5.99148C5.29457 5.63192 5.16939 5.32697 4.91904 5.07662C4.66868 4.8236 4.27185 4.69709 3.72852 4.69709H1.85885V7.41371ZM11.9243 9.49112V5.86364H12.8671V12H11.9243V10.9613H11.8604C11.7166 11.2729 11.4929 11.5379 11.1892 11.7563C10.8856 11.972 10.5021 12.0799 10.0387 12.0799C9.65515 12.0799 9.31424 11.996 9.01594 11.8282C8.71765 11.6578 8.48327 11.4021 8.31282 11.0612C8.14236 10.7176 8.05713 10.2848 8.05713 9.76278V5.86364H8.99996V9.69886C8.99996 10.1463 9.12514 10.5032 9.37549 10.7695C9.62851 11.0359 9.95078 11.169 10.3423 11.169C10.5767 11.169 10.815 11.1091 11.0574 10.9893C11.3024 10.8694 11.5075 10.6856 11.6726 10.4379C11.8404 10.1903 11.9243 9.87464 11.9243 9.49112ZM15.2012 14.3011C15.0414 14.3011 14.899 14.2878 14.7738 14.2612C14.6486 14.2372 14.562 14.2132 14.5141 14.1893L14.7538 13.3583C14.9828 13.4169 15.1853 13.4382 15.361 13.4222C15.5368 13.4062 15.6926 13.3277 15.8285 13.1865C15.967 13.048 16.0935 12.823 16.208 12.5114L16.3838 12.032L14.1146 5.86364H15.1373L16.8312 10.7536H16.8951L18.589 5.86364H19.6118L17.007 12.8949C16.8898 13.2118 16.7447 13.4742 16.5715 13.6819C16.3984 13.8923 16.1973 14.0481 15.9683 14.1493C15.7419 14.2505 15.4862 14.3011 15.2012 14.3011ZM24.9631 8.30859V12H24.0203V5.86364H24.9311V6.82244H25.011C25.1549 6.51083 25.3733 6.26048 25.6662 6.07138C25.9592 5.87962 26.3374 5.78374 26.8008 5.78374C27.2163 5.78374 27.5798 5.86896 27.8915 6.03942C28.2031 6.20721 28.4454 6.46289 28.6185 6.80646C28.7917 7.14737 28.8782 7.57884 28.8782 8.10085V12H27.9354V8.16477C27.9354 7.68271 27.8102 7.30717 27.5599 7.03817C27.3095 6.76651 26.9659 6.63068 26.5291 6.63068C26.2282 6.63068 25.9592 6.69593 25.7222 6.82644C25.4878 6.95694 25.3027 7.14737 25.1668 7.39773C25.031 7.64808 24.9631 7.9517 24.9631 8.30859ZM33.094 12.1278C32.54 12.1278 32.0539 11.996 31.6358 11.7323C31.2203 11.4687 30.8954 11.0998 30.661 10.6257C30.4293 10.1516 30.3134 9.59766 30.3134 8.96378C30.3134 8.32457 30.4293 7.7666 30.661 7.28986C30.8954 6.81312 31.2203 6.44292 31.6358 6.17924C32.0539 5.91557 32.54 5.78374 33.094 5.78374C33.648 5.78374 34.1327 5.91557 34.5482 6.17924C34.9663 6.44292 35.2912 6.81312 35.523 7.28986C35.7573 7.7666 35.8745 8.32457 35.8745 8.96378C35.8745 9.59766 35.7573 10.1516 35.523 10.6257C35.2912 11.0998 34.9663 11.4687 34.5482 11.7323C34.1327 11.996 33.648 12.1278 33.094 12.1278ZM33.094 11.2809C33.5148 11.2809 33.861 11.173 34.1327 10.9573C34.4043 10.7416 34.6054 10.4579 34.7359 10.1064C34.8664 9.75479 34.9317 9.37393 34.9317 8.96378C34.9317 8.55362 34.8664 8.17143 34.7359 7.81721C34.6054 7.46298 34.4043 7.17667 34.1327 6.95827C33.861 6.73988 33.5148 6.63068 33.094 6.63068C32.6732 6.63068 32.3269 6.73988 32.0553 6.95827C31.7836 7.17667 31.5825 7.46298 31.452 7.81721C31.3215 8.17143 31.2563 8.55362 31.2563 8.96378C31.2563 9.37393 31.3215 9.75479 31.452 10.1064C31.5825 10.4579 31.7836 10.7416 32.0553 10.9573C32.3269 11.173 32.6732 11.2809 33.094 11.2809ZM38.4953 12L36.6256 5.86364H37.6163L38.9427 10.5618H39.0066L40.317 5.86364H41.3237L42.6181 10.5458H42.682L44.0084 5.86364H44.9992L43.1295 12H42.2026L40.8603 7.28587H40.7644L39.4221 12H38.4953Z"
                                                                    fill="white"/>
                                                                <path
                                                                    d="M61.6491 13.9708H56.405C55.4016 13.9708 54.6491 13.7025 54.1825 13.1716C53.7158 12.6408 53.535 11.8708 53.6575 10.8733L54.1825 6.49828C54.3341 5.20912 54.6608 4.05412 56.9358 4.05412H61.1358C63.405 4.05412 63.7316 5.20912 63.8891 6.49828L64.4141 10.8733C64.5308 11.8708 64.3558 12.6466 63.8891 13.1716C63.405 13.7025 62.6583 13.9708 61.6491 13.9708ZM56.93 4.92912C55.25 4.92912 55.1683 5.59411 55.0458 6.59744L54.5208 10.9724C54.4333 11.7133 54.5383 12.2558 54.8358 12.5883C55.1333 12.9208 55.6583 13.0899 56.405 13.0899H61.6491C62.3958 13.0899 62.9208 12.9208 63.2183 12.5883C63.5158 12.2558 63.6208 11.7133 63.5333 10.9724L63.0083 6.59744C62.8858 5.58827 62.81 4.92912 61.1241 4.92912H56.93Z"
                                                                    fill="white"/>
                                                                <path
                                                                    d="M61.3633 5.80412C61.1242 5.80412 60.9258 5.60578 60.9258 5.36662V3.32495C60.9258 2.69495 60.535 2.30412 59.905 2.30412H58.155C57.525 2.30412 57.1342 2.69495 57.1342 3.32495V5.36662C57.1342 5.60578 56.9358 5.80412 56.6967 5.80412C56.4575 5.80412 56.2592 5.60578 56.2592 5.36662V3.32495C56.2592 2.21078 57.0408 1.42912 58.155 1.42912H59.905C61.0192 1.42912 61.8008 2.21078 61.8008 3.32495V5.36662C61.8008 5.60578 61.6025 5.80412 61.3633 5.80412Z"
                                                                    fill="white"/>
                                                                <path
                                                                    d="M63.9358 11.0716H56.6967C56.4575 11.0716 56.2592 10.8733 56.2592 10.6341C56.2592 10.395 56.4575 10.1966 56.6967 10.1966H63.9358C64.175 10.1966 64.3733 10.395 64.3733 10.6341C64.3733 10.8733 64.175 11.0716 63.9358 11.0716Z"
                                                                    fill="white"/>
                                                            </svg>
                                                        </button>
                                                    @endif

                                                </form>


                                            </div>


                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>


                    </div>
                    <div class="col-12" style="padding-bottom: 50px">
                        @auth
                            <div class="card">
                                <div class="card-body">

                                    <div class="card-title mt-3 text-center">
                                        <h6 style="background: #565656; padding: 10px; border-radius: 10px; color: white"
                                            class="text-left">LAST ORDER</h6>
                                    </div>

                                    @if($bought_qty == 0)
                                    @else
                                        @foreach($bought as $data)

                                            <div class="row">


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

                                                    {{$data->user_name}}, | <span style="color: #0AC028"> bought </span>|<span>{{\Illuminate\Support\Str::limit($data->item,
                                    16, '...')}}</span>|<span
                                                        style="color: #FF6304">₦{{number_format($data->amount)}}</span>|<a
                                                        href="#"
                                                        style=" font-size: 6px; background: linear-gradient(90deg, #FF6304 0%, #FF0D9B 100%); border-radius: 5px; padding: 3px; color: white">{{ diffForHumans($data->created_at) }}</a>
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
                </div>
            </div>

            <!-- Section ends -->


            <script>
                // Variables to track quantity and price
                let quantity = 1;
                const price = {{ $product->price }};

                // Functions to increment and decrement quantity
                function incrementQuantity() {
                    quantity++;
                    updateView();
                }

                function decrementQuantity() {
                    if (quantity > 1) {
                        quantity--;
                        updateView();
                    }
                }

                // Function to update the view with new quantity and total
                function updateView() {
                    const quantityElement = document.getElementById("quantity");
                    const totalElement = document.getElementById("total");
                    const quantityInput = document.getElementById("quantityInput");

                    const total = (quantity * price).toFixed(2);

                    quantityElement.textContent = quantity;
                    totalElement.textContent = total;
                    quantityInput.value = quantity;
                }

                // Function to submit quantity to the server
                function submitQuantity() {
                    const quantityInput = document.getElementById("quantityInput");
                    alert("Quantity submitted: " + quantityInput.value);
                    // You can send the quantityInput.value to the server here
                }

                // Initialize the view
                updateView();
            </script>

@endsection



