@extends('layouts.app')

@section('title')
    Wishlist
@endsection

@section('content')
    <br>
    <br>
    <div class="page-content page-wishlist">
        <div class="container">
            <section class="store-cart">
                <div class="container">
                    <div class="row" data-aos="fade-up" data-aos-delay="100">
                        <div class="col-12 table-responsive">
                            <table class="table table-borderless table-cart" aria-describedby="Cart">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlists as $wishlist)
                                        <tr>
                                            <a href="#">
                                                <td style="width: 10%;">
                                                    @if ($wishlist->product->galleries && $wishlist->product->galleries->isNotEmpty())
                                                        <img src="{{ Storage::url($wishlist->product->galleries->first()->photos) }}"
                                                            alt="" class="cart-image" />
                                                    @else
                                                        <img src="images/bgemptyproduct.png" alt=""
                                                            class="cart-image" />
                                                    @endif

                                                </td>
                                                <td style="width: 35%;">
                                                    <div class="product-title">{{ $wishlist->product->name }}</div>
                                                    <div class="product-subtitle">{{ $wishlist->product->category->name }}
                                                    </div>
                                                </td>
                                            </a>
                                            <td style="width: 20%;">
                                                <div class="product-title">{{ $wishlist->product->user->name }}</div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="product-title cart-product-price"
                                                    id="cart-product-price-{{ $wishlist->id }}">
                                                    @money($wishlist->product->price)</div>
                                                {{-- <div class="product-subtitle">USD</div> --}}
                                            </td>
                                            <td style="width: 20%;">
                                                <form action="{{ route('cart-delete', $wishlist->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-remove-cart">
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
