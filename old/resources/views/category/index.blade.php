@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'Category')
@section('title', 'Category')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Category List</h3>
      <a href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>
    </div>
    <form action="{{ route('category.index') }}" method="GET" class="mb-3">
      <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
      <button type="submit" class="btn btn-primary">Search</button>
      @if(request('search'))
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Clear</a>
      @endif
      </div>
    </form>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($categories as $category)
          <tr>
            <td>{{ $categories->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $category->category_name }}</td>
            <td>
              <span class="badge {{ $category->is_active == 1 ? 'bg-success' : 'bg-secondary' }}">
              {{ $category->is_active == 1 ? 'Active' : 'Inactive' }}
              </span>
            </td></td>
            <td>
              <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-name="{{ $category->category_name }}">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">No categories found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
      {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    
  </div>
</section>
@endsection

@section('script')
<!-- Script kamu -->
<script>
  $('.btn-hapus').click(function(e) {
    e.preventDefault(); 
    
    var form = $(this).closest('form');
    var categoryName = $(this).data('name');

    Swal.fire({
      title: `Delete "${categoryName}"?`,
      text: "Are you sure you want to delete this category?",
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
