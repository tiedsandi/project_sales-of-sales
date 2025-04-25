@extends('layouts.admin-layout')
@extends('layouts.main')
@section('title', 'Data Users')
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title ?? '' }}</h5>
                        <div class="mt4 mb-3">
                            <div align="right" class="mb-3">
                                <a class="btn btn-primary" href="{{ route('users.create') }}">Add Users</a>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Roles</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $user)
                                        <tr>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    <span class="badge bg-info">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-secondary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form class="d-inline" action="{{ route('users.destroy', $user->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
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
        </div>
    </section>
@endsection
