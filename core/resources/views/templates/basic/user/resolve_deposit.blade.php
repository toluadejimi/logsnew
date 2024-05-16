@extends($activeTemplate . 'layouts.main')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12" style="padding-bottom: 600px">

            <div class="card">
                <div class="card-body p-4">

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

                    <p>Resolve pending transactions by using your bank session ID / Refrence
                        No on your transaction
                        recepit</p>

                    <form action="resolve-now" method="POST">
                        @csrf

                        <label class="my-3">Select Bank</label>
                        <select class="form-control" required name="bank_type">
                            <option value="">Select option</option>
                            <option value="opay">OPAY</option>
                            <option value="palmpay">PALMPAY</option>
                            <option value="providus">PROVIDUS</option>
                        </select>

                        <label class="my-3">Enter Session ID or Reference</label>
                        <div>
                            <input type="text" name="session_id" required
                                   class="form-control2 p-2 text-dark mb-3" placeholder="Enter session ID or Reference">
                            <small class="text-danger my-2">If transaction is from OPAY OR PALMPAY use the 3 letter generated as reference</small>
                            <input hidden type="text" name="trx_ref"
                                   value="{{ $trx }}" required class="">

                        </div>


                        <button type="submit"
                                style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                                class="btn text-start w-100 btn-rounded">

                            <svg class="cart me-4" width="16" height="16" viewBox="0 0 18 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.5158 2.01275C17.9478 0.81775 16.7898 -0.34025 15.5948 0.0927503L0.989804 5.37475C-0.209196 5.80875 -0.354196 7.44475 0.748804 8.08375L5.4108 10.7828L9.5738 6.61975C9.76241 6.43759 10.015 6.3368 10.2772 6.33908C10.5394 6.34135 10.7902 6.44652 10.9756 6.63193C11.161 6.81734 11.2662 7.06815 11.2685 7.33035C11.2708 7.59255 11.17 7.84515 10.9878 8.03375L6.8248 12.1968L9.5248 16.8587C10.1628 17.9617 11.7988 17.8158 12.2328 16.6178L17.5158 2.01275Z"
                                    fill="white"/>
                            </svg>

                            CONTINUE
                        </button>


                    </form>



                </div>
            </div>
        </div>
    </div>
@endsection


