@extends($activeTemplate.'layouts.main')
@section('content')

    <div class="container">

        <div class="row p-3">
            <div class="col-12">
                <form action="{{ route('user.deposit.insert') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger my-4">
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
                        <div class="alert alert-danger mt-2">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <p class="mt-3 p-3">Top up your wallet easily using Bank Transfer or Card</p>


                    <div class="card">

                        <div class="card-body">
                            <h6>Enter Amount (NGN)</h6>
                            <input type="number" name="amount" class="text-dark p-2 form-control2" required>
                            <input type="text" hidden value="enkpay" name="payment">


                        </div>

                    </div>


                    <div class="card">

                        <div class="card-body">
                            <h6 class="mb-1 mt-1">Select Payment Gateway</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="col-12">
                                    <select class="text-dark form-control2 p-2" name="gateway" required>
                                        @foreach ($gateway_currency as $data)
                                            <option value="{{ $data->method_code }}">{{ $data->name }} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>


                        </div>

                    </div>


                    <button type="submit"
                            style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                            class="btn  w-100 mt-3" id="btn-confirm">@lang('Contine')


                </form>


            </div>
            <div class="col-md-12">

                <h5 class="mt-4 mb-4">@lang('Latest Payments History')</h5>


                @forelse($deposits as $deposit)

                    <div class="card">
                        <div class="card-body " style="font-size: 11px;">
                            <div class="row">



                                <div class="col">
                                    <h6>{{number_format($deposit->amount, 2)}}</h6>
                                </div>

                                <div class="col">
                                    {{ diffForHumans($deposit->created_at) }}
                                </div>


                                <div class="col">
                                    @if($deposit->method_code == 1000)
                                        <a href="javascript:void(0);"
                                           class="item- text-small d-flex justify-content-end">
                                            @if($deposit->status == 1)
                                                <a href="#" class="btn btn-success btn-sm">Completed</a>
                                            @elseif($deposit->status == 2)
                                                <a href="#"
                                                   class="btn btn-warning btn-sm">Pending</a>
                                            @elseif($deposit->status == 3)
                                                <a href="#" class="btn btn-danger btn-sm">Rejected</a>
                                            @else
                                                <a href="#"
                                                   class="btn btn-warning btn-sm">Pending</a>

                                            @endif

                                        </a>

                                    @elseif($deposit->method_code == 250)
                                        <a href="javascript:void(0);" class="item-bookmark">
                                            @if($deposit->status == 1)
                                                <a href="#" class="btn btn-success btn-sm">Completed</a>
                                            @elseif($deposit->status == 2)
                                                <a href="/user/resolve-deposit?trx={{$deposit->trx}}"
                                                   class="btn btn-dark btn-sm">Resolve</a>
                                            @elseif($deposit->status == 3)
                                                <a href="#" class="btn btn-danger btn-sm">Rejected</a>
                                            @else
                                                <a href="/user/resolve-deposit?trx={{$deposit->trx}}"
                                                   class="btn btn-dark btn-sm">Resolve</a>
                                            @endif

                                        </a>

                                    @else
                                        @if($deposit->status == 1)
                                            <span class="text-small col-sm-12 badge bg-success mb-1">Successful</span>
                                        @elseif($deposit->status == 2)
                                            <span class="text-small col-sm-12 badge bg-warning mb-1">Pending</span>
                                        @elseif($deposit->status == 3)
                                            <span class="text-small col-sm-12 badge bg-danger mb-1">Canceled</span>
                                        @else
                                            <span class="text-small col-sm-12 badge bg-warning mb-1">Pending</span>
                                        @endif

                                </div>

                                @endif

                            </div>
                        </div>
                    </div>
            </div>

            @empty
                <div class="card">
                    <div class="card-body text-center p-4">

                        <svg width="40" height="40" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.699126 22.1299L11.4851 0.936473C11.6065 0.697285 11.7856 0.49768 12.0036 0.358621C12.2215 0.219562 12.4703 0.146179 12.7237 0.146179C12.9772 0.146179 13.2259 0.219562 13.4439 0.358621C13.6618 0.49768 13.841 0.697285 13.9624 0.936473L24.7483 22.1299C24.8658 22.3607 24.9253 22.6205 24.9209 22.8835C24.9165 23.1466 24.8484 23.4039 24.7234 23.6301C24.5983 23.8562 24.4206 24.0434 24.2078 24.1732C23.995 24.303 23.7543 24.3708 23.5097 24.3701H1.93781C1.69314 24.3708 1.45252 24.303 1.23968 24.1732C1.02684 24.0434 0.849131 23.8562 0.724084 23.6301C0.599037 23.4039 0.530969 23.1466 0.526592 22.8835C0.522216 22.6205 0.581682 22.3607 0.699126 22.1299ZM14.2252 14.2749L14.9815 9.39487C15.0039 9.25037 14.9967 9.10237 14.9605 8.96116C14.9243 8.81995 14.8599 8.6889 14.7719 8.57713C14.6838 8.46536 14.5742 8.37554 14.4506 8.31391C14.327 8.25228 14.1925 8.22033 14.0563 8.22026H11.3912C11.255 8.22033 11.1204 8.25228 10.9969 8.31391C10.8733 8.37554 10.7637 8.46536 10.6756 8.57713C10.5876 8.6889 10.5232 8.81995 10.487 8.96116C10.4508 9.10237 10.4436 9.25037 10.466 9.39487L11.2223 14.2749H14.2252ZM14.7882 18.1096C14.7882 17.5208 14.5707 16.9561 14.1835 16.5398C13.7964 16.1234 13.2713 15.8895 12.7237 15.8895C12.1762 15.8895 11.6511 16.1234 11.2639 16.5398C10.8768 16.9561 10.6593 17.5208 10.6593 18.1096C10.6593 18.6984 10.8768 19.2631 11.2639 19.6794C11.6511 20.0957 12.1762 20.3296 12.7237 20.3296C13.2713 20.3296 13.7964 20.0957 14.1835 19.6794C14.5707 19.2631 14.7882 18.6984 14.7882 18.1096Z"
                                fill="#EA4335"/>
                        </svg>
                        <br><br>

                        <h6>No data found</h6>


                    </div>
                </div>
            @endforelse


            @forelse($deposits as $deposit)
                <div class="item-box">


                    <div class="item-content">


                        <div class="item-footer">


                        </div>
                    </div>

                    @empty

                        <div class="item-box">
                            <div class="item-media">
                                <img src="assets/images/food/food2.png" alt="food">
                            </div>
                            <div class="item-content">
                                <a href="product.html"><h6 class="mb-0">Nasi Goreng Kampung Buk Minah</h6></a>
                                <div class="item-footer">
                                    <h6>$ 5.0</h6>
                                    <a href="javascript:void(0);" class="item-bookmark">
                                        <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.7843 2.04749H16.785H16.8064C17.8714 2.05009 18.9118 2.36816 19.7963 2.96157C20.681 3.55518 21.37 4.39768 21.7762 5.38265C22.1823 6.36762 22.2875 7.45087 22.0783 8.49557C21.8692 9.54028 21.3551 10.4996 20.6011 11.2522L20.6004 11.2529L12.0015 19.8519L3.43855 11.2543L3.41711 11.2328L3.39439 11.2126C2.84628 10.7254 2.40336 10.1314 2.09273 9.46713C1.7821 8.80281 1.61031 8.0821 1.58785 7.3491C1.5654 6.61609 1.69276 5.88622 1.96215 5.20414C2.23153 4.52206 2.63727 3.90213 3.15453 3.38228C3.67179 2.86243 4.28969 2.45361 4.97042 2.18082C5.65115 1.90804 6.38038 1.77704 7.11349 1.79584C7.84659 1.81464 8.56815 1.98284 9.23401 2.29015C9.89986 2.59745 10.496 3.03741 10.9859 3.58308L11.0039 3.60309L11.0229 3.6221L11.2929 3.8921L11.9812 4.58036L12.6878 3.91095L12.9728 3.64095L12.9833 3.63096L12.9936 3.62067C13.4906 3.12161 14.0814 2.72571 14.7319 2.45573C15.3825 2.18575 16.08 2.04701 16.7843 2.04749Z"
                                                stroke="#BFC9DA" stroke-width="2"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    @endforelse
                </div>

                <div class="col d-flex justify-content-start">
                    {{ paginateLinks($deposits) }}
                </div>


        </div>
    </div>

@endsection
