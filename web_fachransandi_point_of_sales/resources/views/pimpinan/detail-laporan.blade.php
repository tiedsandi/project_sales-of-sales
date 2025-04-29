@extends('layouts.main-layout')
@section('page-name', 'POS - Detail Report')
@section('title', 'Detail Report - Index')

@section('main-content')
<section class="py-5 bg-white rounded shadow-sm">
  <div class="container">
    <h1 class="display-5 fw-semibold text-center mb-5">POS Sale Details</h1>

    <div class="mb-4">
      <h2 class="h4">Order Information</h2>
      <div class="row g-3">
        <div class="col-md-6">
          <p class="mb-0"><strong>Order Code:</strong> {{ $order->order_code }}</p>
        </div>
        <div class="col-md-6">
          <p class="mb-0"><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
          <p class="mb-0"><strong>Order Status:</strong> 
            @if($order->order_status == 0)
              <span class="badge bg-warning text-dark">Pending Payment</span>
            @else
              <span class="badge bg-success">Paid</span>
            @endif
          </p>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <h2 class="h4">Order Details</h2>
      <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">Product</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->orderDetails as $item)
              <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->product->formatted_price }}</td>
                <td>{{ $item->formatted_subtotal }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end fw-bold">Grand Total</td>
              <td>{{ $order->formatted_amount }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <div class="mb-4">
      <h2 class="h4">Payment Details</h2>
      <p><strong>Change:</strong> {{ $order->formatted_change }}</p>
    </div>

    {{-- Uncomment if you want to enable print --}}
    {{-- 
    <div class="text-center">
      <a href="{{ route('report.print', $order->id) }}" target="_blank" class="btn btn-outline-success">
        Print Receipt
      </a>
    </div> 
    --}}
  </div>
</section>

@endsection

@section('script')


@endsection