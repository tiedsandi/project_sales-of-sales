@extends('layouts.admin-layout')
@section('page-title', 'Dashboard')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <h1 class="display-4 fw-bold">Welcome!</h1>
    <p class="lead mb-4">Easily manage your sales with our powerful tools. Start creating and tracking your orders seamlessly today!</p>
    <a href="/pos-sale" class="btn btn-primary btn-lg">Go to POS Orders</a>
  </div>
</section>
@endsection


