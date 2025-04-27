@extends('layouts.main-layout')
@section('page-name', 'POS - User')
@section('title', 'User - Index')

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
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($datas as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->role_name }}</td>
                  <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form class="d-inline" action="{{ route('users.destroy', $user->id) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-hapus btn-danger" data-name="{{ $user->name }}">
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