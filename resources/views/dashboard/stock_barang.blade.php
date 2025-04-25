@extends('layouts.admin-layout')

@section('page-title', 'Dashboard')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Stock Barang</h3>
    </div>
    
    <!-- Tabel stok barang -->
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</a></th>
          <th>Nama Produk</a></th>
          <th>Jumlah Stok</a></th>
          <th>Harga</a></th>
          <th>Status</a></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($products as $product)
          <tr>
            <td>{{ $products->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->product_qty }}</td>
            <td>{{ number_format($product->product_price, 2) }}</td>
            <td>
              <span class="badge {{ $product->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
                {{ $product->is_active == 1 ? 'Active' : 'Inactive' }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">No products found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
      {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection
