@extends('layouts.admin-layout')
@extends('layouts.main')
@section('title', 'Edit Users')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('users.update', $edit->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="" class="col-form-label">User Name *</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Your Name" required
                                    value="{{ $edit->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="col-form-label">Email *</label>
                                <input type="text" class="form-control" name="email" placeholder="Enter Your Email" required
                                    value="{{ $edit->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="col-form-label">Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Enter new password (optional)">
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Jurusan</label>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                                            id="role-{{ $role->id }}" {{ in_array($role->id, $edit->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection