@extends('layouts.main-layout')
@section('page-name', 'POS - Product')
@section('title', 'Product - Index')

@section('main-content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="pagetitle mt-4 mb-4">
            <h1 align="center" style="text-transform: uppercase; font-weight: bold">@yield('title')</h1>
            <div align="right">
              <a  href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
            </div>
          </div>

          <table class="table datatable">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($datas as $product)
                <tr>
                  <td>
                    @if($product->product_photo)
                        @if(Str::startsWith($product->product_photo, ['http://', 'https://']))
                            <img src="{{ $product->product_photo }}" alt="{{ $product->product_name }}" width="50">
                        @else
                            <img src="{{ asset('storage/' . $product->product_photo) }}" alt="{{ $product->product_name }}" width="50">
                        @endif
                    @else
                        <i><small>No Image</small></i>
                    @endif
                  </td>
                  <td>{{ $product->product_name }}</td>
                  <td>{{ $product->category_name }}</td>
                  <td>{{ $product->product_qty }}</td>
                  <td>{{ $product->formatted_price }}</td>
                  <td>
                    <span class="badge {{ $product->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
                      {{ $product->is_active == 1 ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form class="d-inline" action="{{ route('product.destroy', $product->id) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-hapus btn-danger" data-name="{{ $product->product_name }}">
                            <i class="bi bi-trash"></i>
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
  </div>
</section>
@endsection

@section('script')
  <script>

      $('.btn-hapus').click(function(e) {
      e.preventDefault(); 
      
      var form = $(this).closest('form');
      var dataName = $(this).data('name');

      Swal.fire({
        title: `Delete "${dataName}"?`,
        text: "Are you sure you want to delete this product?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  </script>
@endsection