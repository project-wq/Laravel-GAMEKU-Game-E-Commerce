@extends('layouts.app')

@section('title')
    Store Detail Page
@endsection

@section('content')
    <style>
        /***
                                                                                         *  Simple Pure CSS Star Rating Widget Bootstrap 4
                                                                                         *
                                                                                         *  www.TheMastercut.co
                                                                                         *
                                                                                         ***/

        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

        .starrating>input {
            display: none;
        }

        /* Remove radio buttons */

        .starrating>label:before {
            content: "\f005";
            margin: 2px;
            font-size: 1.5em;
            font-family: FontAwesome;
            display: inline-block;
        }

        .starrating>label {
            color: #222222;
            /* Start color when not clicked */
        }

        .starrating>input:checked~label {
            color: #007BFF;
        }

        /* Set yellow color when star checked */

        .starrating>input:hover~label {
            color: #007BFF;
        }

        /* Set yellow color when star hover */



        /* ======================================================================== */

        .starrating-no-hover>label:before {
            content: "\f005";
            margin: 2px;
            font-size: 1.5em;
            font-family: FontAwesome;
            display: inline-block;
        }

        .starrating-no-hover>label {
            color: #007BFF;
            /* Start color when not clicked */
        }

        .starOff {
            color: #636363 !important;
        }

        .starOn {
            color: #007BFF !important;
        }

        .starrating-no-hover {
            pointer-events: none;
        }


        /* ======================================================================== */

        .starrating-profile>label:before {
            content: "\f005";
            margin: 2px;
            font-size: 1.5em;
            font-family: FontAwesome;
            display: inline-block;
        }

        .starrating-profile>label {
            color: #007BFF;
            /* Start color when not clicked */
        }

        .starOnProfile {
            color: #007BFF !important;
        }

        .starrating-profile {
            pointer-events: none;
        }
    </style>
    <br>
    <!-- Page Content -->
    <div class="page-content page-details">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Product Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="store-gallery" id="gallery">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 mb-4" data-aos="zoom-in">
                        {{-- <transition name="slide-fade" mode="out-in"> --}}
                        @if ($product->galleries->count() > 0)
                            @foreach ($product->galleries as $gallery)
                                <img class="w-100 main-image shadow" alt=""
                                    style="height: 300px; object-fit: cover;" src="{{ Storage::url($gallery->photos) }}" />
                            @endforeach
                        @else
                            <img class="w-100 main-image shadow" alt="" style="height: 300px; object-fit: cover;"
                                src="{{ asset('images/bgemptyproduct.png') }}" />
                        @endif
                        {{-- </transition> --}}
                    </div>
                    <div class="col-lg-5">
                        <section class="store-heading{{--  shadow-sm --}}" data-aos="zoom-in">
                            {{--  <div class="row">
                <div
                  class="col-3 col-lg-12 mt-2 mt-lg-0"
                  v-for="(photo, index) in photos"
                  :key="photo.id"
                  data-aos="zoom-in"
                  data-aos-delay="100"
                >
                  <a href="#" @click="changeActive(index)">
                    <img
                      :src="photo.url"
                      class="w-100 thumbnail-image"
                      :class="{ active: index == activePhoto }"
                      alt=""
                    />
                  </a>
                </div>
              </div> --}}
                            <div {{-- style="padding: 10px;" --}}>
                                <h1>{{ $product->name }}</h1>
                                <div class="owner">{{ $product->category->name }}</div>
                                <div class="stock">
                                    Stok :
                                    @if ($product->quantity > 0)
                                        <span class="available" id="current-stock">{{ $product->quantity }}</span>
                                    @else
                                        <span class="empty">Barang Kosong</span>
                                    @endif
                                </div>

                                {{--  <h5>Deskripsi Produk</h5> --}}
                                <div class="starrating-profile risingstar d-flex justify-content-start no-pointer">
                                    <label for="star1" title="1 star" class="starOnProfile d-inline"
                                        style="display: flex;">
                                        <h6 class="d-inline mb-5" style="align-items: center;">{{ $rate }} / 5.0
                                        </h6>
                                    </label>
                                </div>


                                {{--  <h6 class="mt-2">{!! $product->description !!}</h6> --}}

                                <div class="price">@money($product->price)</div>



                                @auth
                                    <div style="display: flex; flex-direction: column;"></div>
                                    <form action="{{ route('detail-add', $product->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="store-qty mb-3">
                                            <div class="product-qty">
                                                <div class="field-qty">
                                                    {{--    <input type="hidden" value="{{ $cart->id }}" name="cart-id" id="cart-id"> --}}
                                                    <button class="btn-decrement">
                                                        <svg width="100%" height="100%" viewBox="0 0 24 24"
                                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M20 12.75H4a.75.75 0 1 1 0-1.5h16a.75.75 0 1 1 0 1.5Z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <input type="number" name="quantity" value="1"
                                                        class="quantity-input cart-product-qty" {{-- id="cart-product-qty-{{ $cart->id }}" --}}>
                                                    <button class="btn-increment">
                                                        <svg width="100%" height="100%" viewBox="0 0 24 24"
                                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M20 11.25h-7.25V4a.75.75 0 1 0-1.5 0v7.25H4a.75.75 0 1 0 0 1.5h7.25V20a.75.75 0 1 0 1.5 0v-7.25H20a.75.75 0 1 0 0-1.5Z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4 text-white mb-3 btn-sm"
                                            href="/cart">Add
                                            to Cart</button>
                                    </form>
                                    <form action="{{ route('wishlist-add', $product->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-white px-4 text-primary mb-3 btn-sm"
                                            href="/cart" style="border: #007BFF 1px solid; padding-top: 5px;">
                                            <i class="fa-regular fa-heart fa-lg" style="color: #007BFF;"></i> Add
                                            to Wishlist</button>
                                    </form>
                                @else
                                    <a class="btn btn-secondary px-4 text-white mb-3" href="{{ route('login') }}">Sign in to
                                        Add</a>
                                @endauth


                            </div>

                        </section>
                    </div>
                </div>
            </div>
        </section>
        <div class="store-details-container" data-aos="fade-up">
            <section class="store-detail">
                <div class="container">
                    <a href="/{{ $product->user->store_slug }}" class="store-info">
                        <img src="{{ Storage::url('assets/user-photo-profile/pBZXzHA1SQuMQt4b6IG8JgFJPbPwQZeOwOWiWTyX.png') }}"
                            alt="" class="store-avatar">

                        <div class="store-title">
                            <span class="title">{{ $product->user->store_name }}</span>
                            <span class="status">Online 7 menit yang lalu</span>
                        </div>
                    </a>

                </div>
            </section>

            <section class="product-description">
                <div class="container">
                    <div class="store-product-detail">
                        <span class="title">Deskripsi Produk</span>
                        <div class="mt-2 description">
                            <span>{!! $product->description !!}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="store-review mt-5">
                <div class="container">
                    <div class="review">
                        <div class="row">
                            <div class="col-12 col-lg-8 mt-3 mb-3">
                                <h5>Ulasan Pelanggan ({{ $reviewCount }})</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-8">
                                <div class="list-unstyled overflow-review">
                                    @foreach ($reviews as $review)
                                        <li class="media mb-3">
                                            @if ($review->user->img_profile)
                                                <img src="{{ asset('storage/' . $review->user->img_profile) }}"
                                                    class="mr-3 rounded-circle" alt=""
                                                    style="object-fit:cover;
                                                    width: 45px;
                                                    height: 45px;" />
                                            @else
                                                <img src="{{ asset('images/bgemptyprofile.png') }}"
                                                    class="mr-3 rounded-circle" alt=""
                                                    style="object-fit:cover;
                                                    width: 45px;
                                                    height: 45px;" />
                                            @endif
                                            <div class="media-body">
                                                <div class="d-inline">
                                                    <h5 class="mt-2 mb-1">{{ $review->user->name }}</h5>
                                                    <h6>{{ $review->created_at->diffForHumans() }}</h6>
                                                </div>
                                                {{ $review->comment }}

                                                @php
                                                    $rate = $review->rate;
                                                @endphp

                                                <div
                                                    class="starrating-no-hover risingstar d-flex justify-content-start no-pointer">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $rate)
                                                            <label for="star1" title="1 star" class="starOn"></label>
                                                        @else
                                                            <label for="starOn" title="starOn" class="starOff"></label>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-start">

                                    {{ $reviews->links() }}

                                </div>

                                <div style="border-radius: 10px; background-color: rgba(0, 116, 240, 0.2);">
                                    <div class="p-3">
                                        @auth
                                            <h5>Review Products : </h5>
                                            <form action="{{ route('review-add', $product->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="starrating risingstar d-flex justify-content-end flex-row-reverse">
                                                    <input type="radio" id="star5" name="rate" value="5"
                                                        required /><label for="star5" title="5 star"></label>
                                                    <input type="radio" id="star4" name="rate" value="4"
                                                        required /><label for="star4" title="4 star"></label>
                                                    <input type="radio" id="star3" name="rate" value="3"
                                                        required /><label for="star3" title="3 star"></label>
                                                    <input type="radio" id="star2" name="rate" value="2"
                                                        required /><label for="star2" title="2 star"></label>
                                                    <input type="radio" id="star1" name="rate" value="1"
                                                        required /><label for="star1" title="1 star"></label>
                                                </div>
                                                <div class="input-group mb-3 shadow-sm">
                                                    <input type="text" class="form-control" placeholder="Comment..."
                                                        name="comment" value="" required>
                                                </div>
                                                @if ($errors->any())
                                                    <div class="alert alert-danger mt-3">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <button class="btn btn-outline-primary" type="submit"><i
                                                        class="fas fa-paper-plane"></i> Send Reviews</button>
                                            </form>
                                        @else
                                            <a class="btn btn-secondary px-4 text-white" href="{{ route('login') }}">Sign in
                                                to
                                                Reviews</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="recommendation-product">
                <div class="container mt-2">
                    <div class="row">
                        <div class="col-12" data-aos="fade-up">
                            <h5>Produk Lainnya oleh {{ $product->user->name }}</h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        @php $incrementProduct = 0 @endphp
                        @forelse ($productsSeller as $product)
                            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up"
                                data-aos-delay="{{ $incrementProduct += 100 }}">
                                <a class="component-products d-block" href="{{ route('detail', $product->slug) }}">
                                    <div class="products-thumbnail shadow-sm">
                                        <div class="products-image"
                                            style="
                      @if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                      @else
                        background-image: url('images/bgemptyproduct.png') @endif
                    ">
                                        </div>
                                    </div>
                                    <div class="products-text">{{ $product->name }}</div>
                                    <div class="products-price">@money($product->price)</div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                                No Products Found
                            </div>
                        @endforelse

                    </div>
                </div>
            </section>


        </div>
    </div>

@endsection

@push('addon-script')
    <script>
        $(document).ready(function() {

            $('.btn-increment').on('click', function(e) {
                e.preventDefault();
                let currentStock = parseInt($('#current-stock').text());
                let inputQuantity = $(this).siblings('.quantity-input');
                let quantity = parseInt(inputQuantity.val()) + 1;
                let cartId = inputQuantity.siblings('input[name="cart-id"]').val();
                if (quantity <= currentStock) {
                    inputQuantity.val(quantity);
                }

            });

            $('.btn-decrement').on('click', function(e) {
                e.preventDefault();
                let inputQuantity = $(this).siblings('.quantity-input');
                let quantity = parseInt(inputQuantity.val()) - 1;
                let cartId = inputQuantity.siblings('input[name="cart-id"]').val();
                if (quantity >= 1) {
                    inputQuantity.val(quantity);
                }
            });


        });
    </script>
@endpush
{{-- @push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {  
          activePhoto: 0,
          photos: [
            @foreach ($product->galleries as $gallery)
            {
              id: {{ $gallery->id }},
              url: "{{ Storage::url($gallery->photos) }}",
            },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
@endpush --}}
