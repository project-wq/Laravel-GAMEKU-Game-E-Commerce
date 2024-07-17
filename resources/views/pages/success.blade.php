@extends('layouts.success')

@section('title')
    Store Success Page
@endsection

@section('content')
  <!-- Page Content -->
    <div class="page-content page-success">
      <div class="section-success" data-aos="zoom-in">
        <div class="container">
          <div class="row align-items-center row-login justify-content-center">
            <div class="col-lg-6 text-center">
              <img src="/images/success.svg" alt="" class="mb-4" />
              <h2>
                Transaksi Sukses!
              </h2>
              <p>
                Silahkan tunggu, produk mu akan segera dikirim oleh penjual^^
                <br/>
                <span style="color: #a1a1a1;">Silahkan cek Dasbor untuk melihat detail pembelianmu.</span>
              </p>
              <div>
                <a class="btn btn-primary w-50 mt-4" href="/dashboard">
                  Dasbor
                </a>
                <a class="btn btn-signup w-50 mt-2" href="/">
                  Lanjut Belanja
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection