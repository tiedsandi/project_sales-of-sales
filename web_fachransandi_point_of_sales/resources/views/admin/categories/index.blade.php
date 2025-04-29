@extends('layouts.main-layout')
@section('page-name', 'POS - Category')
@section('title', 'Category - Index')

@section('main-content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="pagetitle mt-4 mb-4">
            <h1 align="center" style="text-transform: uppercase; font-weight: bold">@yield('title')</h1>
            <div align="right">
              <a  href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>
            </div>
          </div>

          <table class="table datatable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($datas as $category)
                <tr>
                  <td>{{ $category->category_name }}</td>
                  <td>
                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form class="d-inline" action="{{ route('category.destroy', $category->id) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-hapus btn-danger" data-name="{{  $category->category_name}}">
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