@extends('layouts.admin-layout')
@section('page-title', 'Edit Product')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3>Edit Product</h3>
</div>
<section class="py-4 px-3 bg-white rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
  <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
      <select name="category_id" id="category_id" class="form-select">
        <option value="">Select a category</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
            {{ $category->category_name }}
          </option>
        @endforeach
      </select>
      @error('category_id')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
      <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" value="{{ old('product_name', $product->product_name) }}" autofocus>
      @error('product_name')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="product_photo" class="form-label">Product Photo</label>
      <input type="file" name="product_photo" id="product_photo" class="form-control">
      @if($product->product_photo)
        <div class="mt-2">
          <img src="{{ asset('storage/' . $product->product_photo) }}" alt="Product Photo" style="max-height: 100px;">
        </div>
      @endif
      @error('product_photo')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="product_price" class="form-label">Product Price <span class="text-danger">*</span></label>
      <input type="number" name="product_price" id="product_price" class="form-control" placeholder="Enter product price" value="{{ old('product_price', $product->product_price) }}">
      @error('product_price')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="product_description" class="form-label">Product Description</label>
      <textarea name="product_description" id="product_description" class="form-control" rows="4" placeholder="Enter product description">{{ old('product_description', $product->product_description) }}</textarea>
      @error('product_description')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-check mb-3 d-flex">
      <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
      <label for="is_active" class="form-check-label ms-2">Mark this product as active.</label>
      @error('is_active')
        <div class="text-danger small">{{ $message }}</div>
      @enderror
    </div>
    <div class="d-flex justify-content-end">
      <a href="{{ route('product.index') }}" class="btn btn-outline-secondary me-2" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Cancel</a>
      <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; height: 2.5rem; line-height: 1.5rem;">Update</button>
    </div>
  </form>
</section>

@endsection