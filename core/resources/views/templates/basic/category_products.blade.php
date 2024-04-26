@extends($activeTemplate . 'layouts.main')
@section('content')
    <div class="container">




        <div class="card">
            <div class="card-body">


                <table class="table table-sm table-responsive-sm" style="padding-bottom: 500px">
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




                        @forelse ($products as $product)
                            <tr>

                                <td class="">
                                    <a href="#" data-help="Click to read detailed description">
                                        <img src="{{ url('') }}/assets/images/product/{{ $product->image }}"
                                            height="50" width="50" loading="lazy">
                                    </a>
                                </td>
                                <td class="small col-sm-12">
                                    <a href="/product/details/{{ $product->id }}">
                                        {{ \Illuminate\Support\Str::limit($product->name, 50, '...Show more') }}</a>
                                </td>

                                <td class="small">
                                    ₦{{ number_format($product->price, 2) }}
                                </td>
                                <td>

                                </td>
                                <td>
                                    @if ($product->in_stock == 0)
                                        <div>
                                            0 pcs.
                                            <button type="button" class="form-control border-0" type="button"
                                                data-id="12005">
                                                <ion-icon class="text-dark" name="bag-add"></ion-icon>
                                            </button>
                                        </div>
                                    @else
                                        <form action="/product/details/{{ $product->id }}" method="get">
                                            @csrf
                                            <div class="button-wrap" onclick="subscribeBuyItem(6);">
                                                <div data-help="Buy Now">
                                                    {{ $product->in_stock }} pcs.
                                                    <button type="submit" class="form-control" type="button"
                                                        data-id="12005">
                                                        <ion-icon class="" style="border: 0px;"
                                                            name="bag-add"></ion-icon>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                </td>
                        @endif
                        </tr>
                    @empty
                        <td>No product found </td>
                        @endforelse




                    </tbody>

                    {{ paginateLinks($products) }}


                </table>


            </div>
        </div>










    </div>
@endsection
