@extends('layouts.app')

@section('title')
    Store {{ $seller->name }}
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
    <br>
    <div class="page-content page-store-profile">
        <div class="container">
            <section class="store-profile">
                <div class="store-header">
                    <div class="left-side">
                        <div class="store-image">
                            <img src="{{ asset('storage/' . $seller->img_profile) }}" alt="">
                        </div>

                        <div class="store-title">
                            <span class="title">{{ $seller->name }}</span>
                            <span class="status"> • Online</span>
                            <div class="store-button">
                                <a href="" class="follow">
                                    <span>Follow</span>
                                </a>
                                <a href="" class="store">
                                    <span>Store</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="store-rate">
                            <div class="rate">
                                <div class="top">
                                    <i class="fa-solid fa-star"></i>
                                    <span>{{ $roundedRating }}</span>
                                </div>

                                <div class="bottom">
                                    <span>Rating & Ulasan</span>
                                </div>
                            </div>

                            <div class="deliver">
                                <div class="top">
                                    <span>± 5 menit</span>
                                </div>

                                <div class="bottom">
                                    <span>Pesanan diproses</span>
                                </div>
                            </div>

                            <div class="opening-hours">
                                <div class="top">
                                    <span>Buka 25 jam</span>
                                </div>

                                <div class="bottom">
                                    <span>Jam Operasi Toko</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-selection" role="tablist">
                <a href="#" class="select selected" role="tab" aria-selected="true"
                    aria-controls="home">Beranda</a>
                <a href="#" class="select" role="tab" aria-selected="false" aria-controls="product">Produk</a>
                <a href="#" class="select" role="tab" aria-selected="false" aria-controls="rating">Ulasan</a>
            </section>

            <section id="home" class="home">
                <div class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia similique est
                    maiores aliquam ab quae error possimus aliquid ut incidunt quisquam, cupiditate a deleniti quod vel
                    ducimus. Ut perspiciatis unde, veniam commodi vitae, quae molestias necessitatibus labore tenetur odit
                    sed doloribus dicta et corporis, consequatur tempora perferendis expedita non! Vel, autem vero
                    voluptates nihil odit eveniet placeat soluta mollitia labore rem quisquam! Impedit cupiditate corporis
                    soluta accusamus iure velit veritatis ducimus beatae vero. Labore temporibus ea doloremque molestiae
                    dicta repellat esse, sunt iure, eos hic consequatur fuga id. Cum reiciendis, nostrum nihil recusandae
                    obcaecati consequuntur. Quasi delectus dolore alias ipsum.</div>
            </section>

            <section class="store-product" id="product" style="display: none;">
                <div class="mt-3">
                    <div class="row">
                        <div class="col-12" data-aos="fade-up">
                            <h5>Produk oleh {{ $seller->name }}</h5>
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

            <section id="rating" style="display: none;">
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
                                                                <label for="starOn" title="starOn"
                                                                    class="starOff"></label>
                                                            @endif
                                                        @endfor
                                                    </div>

                                                </div>
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.section-selection [role="tab"]');
            const sections = {
                home: document.getElementById('home'),
                product: document.getElementById('product'),
                rating: document.getElementById('rating')
            };

            tabs.forEach(tab => {
                tab.addEventListener('click', function(event) {
                    event.preventDefault();


                    tabs.forEach(t => {
                        t.classList.remove('selected');
                        t.setAttribute('aria-selected', 'false');
                        const sectionId = t.getAttribute('aria-controls');
                        if (sections[sectionId]) {
                            sections[sectionId].style.display = 'none';
                        }
                    });


                    this.classList.add('selected');
                    this.setAttribute('aria-selected', 'true');
                    const sectionId = this.getAttribute('aria-controls');
                    if (sections[sectionId]) {
                        sections[sectionId].style.display = 'block';
                    }
                });
            });
        });
    </script>
@endpush
