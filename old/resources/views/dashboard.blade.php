@extends('layouts.admin-layout')
@section('page-title', 'Dashboard')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    @anyrole(['Pimpinan','Amdministrator'])
      <h1 class="display-4 fw-bold">Welcome, Admin!</h1>
    @endanyrole
    @role('Kasir')
      <h1 class="display-4 fw-bold">Welcome, Salesperson!</h1>
    @endrole
  </div>
</section>
@endsection


