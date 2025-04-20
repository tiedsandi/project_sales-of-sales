@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'Order')
@section('content')
<section class="py-5 text-center bg-white rounded">
  <div class="container">
    <div class="d-flex justify-content-between mb-3">
      <h3>Order List</h3>
    </div>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Order ID</th>
          <th>Customer Name</th>
          <th>Total Amount</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($orders as $order)
          <tr>
            <td>{{ $orders->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $order->order_code }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>Rp. {{ number_format($order->order_amount, 2) }}</td>
            <td>
              <span class="badge {{ $order->order_status == 1 ? 'bg-success' : 'bg-secondary' }}">
                {{ $order->order_status == 1 ? 'Paid' : 'Unpaid' }}
              </span>
            </td>
            <td>
              <a href="{{route('pos.show', $order->id)}}" class="btn btn-sm btn-secondary">
              <i class="bi bi-eye"></i>
              </a>
              @if($order->order_status == 1)
              <a href="{{route('print', $order->id)}}" class="btn btn-sm btn-success">
                <i class="bi bi-printer"></i>
              </a>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center">No orders found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
      {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@endsection
