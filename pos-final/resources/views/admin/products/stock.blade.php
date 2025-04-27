@extends('layouts.main-layout')
@section('page-name', 'POS - Stock Product')
@section('title', 'Stock - Index')

@section('main-content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="pagetitle mt-4 mb-4">
            <h1 align="center" style="text-transform: uppercase; font-weight: bold">@yield('title')</h1>
          </div>

          <table class="table datatable">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Qty</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
              <tr>
                <td>
                  @if($product['image'])
                      @if(Str::startsWith($product['image'], ['http://', 'https://']))
                          <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" width="50">
                      @else
                          <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" width="50">
                      @endif
                  @else
                      <i><small>No Image</small></i>
                  @endif
                </td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['qty'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')

@endsection