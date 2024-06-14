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


            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body " style="margin-bottom: 100px">
                        <form action="/user/pass-reset" method="POST">
                            @csrf
                            <label>Enter Registered Email</label>
                            <input type="text" class="form-control" name="email" value="{{ old('value') }}" required
                                   autofocus>
                            <button style="color: white; border-radius: 10px;   background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);"  class="btn btn-sm my-3" type="submit">Reset</button>

                        </form>
                    </div>
                </div>
            </div>

                <div style="padding-bottom: 700px" class="col-lg-12 mb-90">
                </div>
        </div>
    </div>






@endsection
