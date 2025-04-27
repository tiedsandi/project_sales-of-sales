@extends('layouts.admin-layout')
@section('page-title', 'Create Category')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Create Category</h3>
</div>
<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('category.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
      <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Enter category name" value="{{ old('category_name') }}" autofocus>
      @error('category_name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-check mb-3 d-flex ">
      <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
      <label for="is_active" class="form-check-label ms-2">Mark this category as active.</label>
      @error('is_active')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="d-flex justify-content-end">
      <a href="{{ route('category.index') }}" class="btn btn-outline-secondary me-2" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Cancel</a>
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Create</button>
    </div>
  </form>
</section>

@endsection