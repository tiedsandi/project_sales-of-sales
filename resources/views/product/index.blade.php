@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'Product')
@section('title', 'Product')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Product List</h3>
      <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
    </div>
    <form action="{{ route('product.index') }}" method="GET" class="mb-3">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
        @if(request('search'))
          <a href="{{ route('product.index') }}" class="btn btn-secondary">Clear</a>
        @endif
      </div>
    </form>

    <table class="table table-bordered table-striped ">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Category</th>
          <th>Photo</th>
          <th>Price</th>
          <th>Description</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($products as $product)
          <tr>
            <td>{{ $products->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->category->category_name }}</td>
            <td>
              @if($product->product_photo)
                <img src="{{ asset('storage/' . $product->product_photo) }}" alt="{{ $product->product_name }}" width="50">
              @else
                <span>No Photo</span>
              @endif
            </td>
            <td>{{ number_format($product->product_price, 2) }}</td>
            <td>{{ $product->product_description }}</td>
            <td>
              <span class="badge {{ $product->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $product->is_active == 1 ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td>
              <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $product->product_name }}">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">No products found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
      {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection

@section('script')
<script>
  $('.btn-hapus').click(function(e) {
    e.preventDefault(); 
    
    var form = $(this).closest('form');
    var productName = $(this).data('name');

    Swal.fire({
      title: `Delete "${productName}"?`,
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
