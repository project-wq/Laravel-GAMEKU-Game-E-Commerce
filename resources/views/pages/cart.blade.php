@extends('layouts.app')

@section('title')
    Store Cart Page
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Cart
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="store-cart">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless table-cart" aria-describedby="Cart">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Name {{-- &amp; Seller --}}</th>
                                    <th scope="col">Owner</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0 @endphp
                                @php $tempTax = 2500 @endphp
                                @php $Total = 0 @endphp
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td style="width: 10%;">
                                            @if ($cart->product->galleries && $cart->product->galleries->isNotEmpty())
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt="" class="cart-image" />
                                            @else
                                                <img src="images/bgemptyproduct.png" alt="" class="cart-image" />
                                            @endif

                                        </td>
                                        <td style="width: 15%">
                                            <div class="form-group" style="margin-top: 15px">
                                                <textarea class="form-control" id="note-each-cart" rows="3" name="notes" style="height: 50px">  {{ $cart->notes }}</textarea>
                                                <input type="hidden" value="{{ $cart->id }}" name="cart-id"
                                                    id="cart-id">
                                            </div>
                                        </td>
                                        <td style="width: 35%;">
                                            <div class="product-title">{{ $cart->product->name }}</div>
                                            <div class="product-subtitle">{{ $cart->product->category->name }}</div>
                                        </td>
                                        <td style="width: 20%;">
                                            <div class="product-title">{{ $cart->product->user->name }}</div>
                                        </td>
                                        <td style="width: 15%;">
                                            <div class="product-title cart-product-price"
                                                id="cart-product-price-{{ $cart->id }}">
                                                @money($cart->product->price)</div>
                                            {{-- <div class="product-subtitle">USD</div> --}}
                                        </td>
                                        <td style="width: 20%;">
                                            <div class="product-qty">
                                                <div class="field-qty">
                                                    <input type="hidden" value="{{ $cart->id }}" name="cart-id"
                                                        id="cart-id">
                                                    <button class="btn-decrement">
                                                        <svg width="100%" height="100%" viewBox="0 0 24 24"
                                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M20 12.75H4a.75.75 0 1 1 0-1.5h16a.75.75 0 1 1 0 1.5Z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" name="quantity" value="{{ $cart->quantity }}"
                                                        class="quantity-input cart-product-qty"
                                                        id="cart-product-qty-{{ $cart->id }}">
                                                    <button class="btn-increment">
                                                        <svg width="100%" height="100%" viewBox="0 0 24 24"
                                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M20 11.25h-7.25V4a.75.75 0 1 0-1.5 0v7.25H4a.75.75 0 1 0 0 1.5h7.25V20a.75.75 0 1 0 1.5 0v-7.25H20a.75.75 0 1 0 0-1.5Z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                {{--   <div>
                                                    <button class="btn btn-increment">+</button>
                                                </div> --}}

                                            </div>

                                        </td>
                                        <td style="width: 20%;">
                                            <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-remove-cart">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    @php
                                        $totalPrice += $cart->product->price * $cart->quantity;
                                    @endphp
                                    @php $Total = $totalPrice + $tempTax @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-4">Confirmation</h2>
                    </div>
                </div>

                <form action="{{ route('checkout') }}" id="checkout-form" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" name="total_price" value="{{ $Total }}">
                    <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">

                        @auth
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <fieldset disabled>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}" />
                                    </fieldset>
                                </div>
                            </div>
                        @endauth

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Mobile</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    value="+628 2020 11111" />
                            </div>
                        </div>

                        @auth
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Name</label>
                                    <fieldset disabled>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            value="{{ Auth::user()->name }}" />
                                    </fieldset>
                                </div>
                            </div>
                        @endauth

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="province">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="province" class="form-control">
                                    <option value="DANA">DANA</option>
                                    <option value="OVO">OVO</option>
                                    <option value="GOPAY">GOPAY</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="catatan_beli">Catatan</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="catatan_beli"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row" data-aos="fade-up" data-aos-delay="150">
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <h2>Payment Informations</h2>
                        </div>
                    </div>

                    {{--  <div class="row" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-4 col-md-2">
                            <div class="product-title" id="total-price-product">@money($Total ?? 0)</div>
                            <div class="product-subtitle">Total</div>
                        </div>


                        <div class="col-4 col-md-2">
                            <div class="product-title text-success" id="total-price">@money($Total ?? 0)</div>
                            <div class="product-subtitle">Total</div>
                        </div>


                        <div class="col-8 col-md-3">
                            <button type="submit" id="pay-button" class="btn btn-primary mt-4 px-4 btn-block">
                                Checkout Now
                            </button>

                        </div>
                    </div> --}}
                    <div>
                        <hr class="sidebar-divider">

                        <div class="row">
                            <div class="col-md-12">
                                @foreach ($carts as $cart)
                                    <div class="row">
                                        <div class="col-md-2">
                                            {{ $cart->product->name }} ( x<span
                                                id="product-qty-{{ $cart->id }}">{{ $cart->quantity }}</span> ):
                                        </div>
                                        <div class="col-md-3" id="product-price-{{ $cart->id }}">
                                            @money($cart->product->price * $cart->quantity)
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p>Layanan Aplikasi : </p>
                            </div>
                            <div class="col-md-3">
                                <p> @money($tempTax)</p>
                            </div>
                        </div>
                        <hr class="sidebar-divider">
                        <div class="row">
                            <div class="col-md-2">
                                <p>Total : </p>
                            </div>
                            <div class="col-md-3">
                                <p id="total-price">@money($Total)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">

                                @csrf
                                <button type="submit" href="" class="btn btn-primary btn-icon-split"
                                    style="width: 100%;"><span class="text"><i class="fas fa-cart-plus"
                                            style="padding-right: 5px"></i>Checkout</span></button>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
    <script>
        $(document).ready(function() {
            $('#checkout-form').on('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                /*   console.log('FormData:');
                  for (var pair of formData.entries()) {
                      console.log(pair[0] + ': ' + pair[1]);
                  }
                  return; */

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === "error") {
                            alert(response.message);
                        }

                        if (response.status === "success") {
                            snap.pay(response.snap_token, {
                                onSuccess: function(result) {
                                    console.log('Payment successful:', result);
                                    window.location.href =
                                        '{{ route('checkout-success') }}'
                                },
                                onPending: function(result) {
                                    console.log('Payment pending:', result);

                                },
                                onError: function(result) {
                                    console.error('Payment error:', result);

                                }
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.btn-increment').on('click', function(e) {
                e.preventDefault();
                let inputQuantity = $(this).siblings('.quantity-input');
                let quantity = parseInt(inputQuantity.val()) + 1;
                let cartId = inputQuantity.siblings('input[name="cart-id"]').val();
                inputQuantity.val(quantity);

                updateCartQuantity(quantity, cartId);
                updateTotalPrice(cartId);
            });

            $('.btn-decrement').on('click', function(e) {
                e.preventDefault();
                let inputQuantity = $(this).siblings('.quantity-input');
                let quantity = parseInt(inputQuantity.val()) - 1;
                let cartId = inputQuantity.siblings('input[name="cart-id"]').val();
                if (quantity >= 1) {
                    inputQuantity.val(quantity);
                    updateCartQuantity(quantity, cartId);
                    updateTotalPrice(cartId);
                }
            });

            $('.quantity-input').on('input', function(e) {
                let quantity = parseInt($(this).val());
                let cartId = $(this).siblings('input[name="cart-id"]').val();

                if (quantity >= 1) {
                    updateCartQuantity(quantity, cartId);
                    updateTotalPrice(cartId);
                } else {
                    console.log('Quantity tidak boleh kurang dari 1');
                }
            });

            $('.table-cart tbody tr').each(function() {

                let $noteTextarea = $(this).find(
                    '#note-each-cart');

                $noteTextarea.on('blur', function() {
                    let cartId = $(this).siblings('input[name="cart-id"]').val();
                    let notes = $(this).val();

                    updateCartNotes(notes, cartId);
                });
            });



            function updateTotalPrice(cartId) {
                let tax = 2500;
                let totalPrice = 0;

                $('.table-cart tbody tr').each(function() {
                    let pricePerItem = parseInt($(this).find('.cart-product-price').text().replace(/\D/g,
                        ''), 10);
                    let quantity = parseInt($(this).find('.cart-product-qty').val(), 10);
                    console.log(pricePerItem, quantity);

                    let allPricePerItem = pricePerItem * quantity;
                    totalPrice += allPricePerItem;
                });


                let pricePerItem = parseInt($(`#cart-product-price-${cartId}`).text().replace(/\D/g, ''),
                    10);
                let quantity = parseInt($(`#cart-product-qty-${cartId}`).val());

                let pricePerItemOnTotal = parseInt($('#product-price-' + cartId).text().replace(
                    /\D/g, ''), 10);
                let quantityOnTotal = parseInt($('#product-qty-' + cartId).text());

                $('#product-qty-' + cartId).text(quantity);
                pricePerItemOnTotal = pricePerItem * quantity;
                $('#product-price-' + cartId).text(moneyFormat(pricePerItemOnTotal));

                $('#total-price').text(moneyFormat(totalPrice + tax));

            }

            function moneyFormat(value) {
                return 'Rp. ' + value.toLocaleString('id-ID');
            }

            function updateCartNotes(notes, cartId) {
                $.ajax({
                    url: '/cart/' + cartId,
                    method: 'PUT',
                    data: {
                        _method: 'PUT',
                        notes: notes,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            function updateCartQuantity(quantity, cartId) {
                $.ajax({
                    url: '/cart/' + cartId,
                    method: 'PUT',
                    data: {
                        _method: 'PUT',
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endpush
