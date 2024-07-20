@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product
@endsection

@section('content')
    <br>
    <br>
    <!-- section content-->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Products</h2>
                <p class="dashboard-subtitle">
                    Manage it well and get money
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('dashboard-product-create') }}" class="btn btn-primary">Add New Product</a>
                    </div>
                </div>
                <div class="card-dashboard-product-container mt-4">

                    @foreach ($products as $product)
                        <div class="">
                            <a href="{{ route('dashboard-product-detail', $product->id) }}" class="card-dashboard-product">
                                <div class="card-body">
                                    {{-- @if (isset($product->galleries->first()->photos))
                                        <img src="{{ Storage::url($product->galleries->first()->photos) }}" alt=""
                                            class="w-10 mb-2" />
                                    @else
                                        <img src="{{ asset('images/bgemptyproduct.png') }}" alt=""
                                            class="w-10 mb-2" />
                                    @endif --}}
                                    @if (isset($product->galleries->first()->photos))
                                        <div class="product-thumbnail mb-2">
                                            <div class="product-image"
                                                style="
                      @if (isset($product->galleries->first()->photos)) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                      @else
                        background-image: url('images/bgemptyproduct.png') @endif
                    ">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="product-title judul-produk">{{ $product->name }}</div>
                                    <div class="product-category">{{ $product->category->name }}</div>
                                    <div class="product-stock">Stock : <span style="color: #007BFF;">{{ $product->quantity }}</span></div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>


            </div>
        </div>
    </div>
    </div>
@endsection
