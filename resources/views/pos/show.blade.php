@extends('layouts.admin-layout')

@section('page-title', 'POS Sale Details')

@section('content')
<section class="py-5 bg-white rounded">
  <div class="container">
    <h1 class="display-4 fw-bold text-center">POS Sale Details</h1>
    <div class="row">
      <div class="col-12">
        <h2>Customer Information</h2>
        <div class="row">
          <div class="col-md-6">
            <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
            <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</p>
            <p><strong>Order Status:</strong> 
              @if($order->order_status == 0)
                <span class="badge bg-warning">Pending Payment</span>
              @else
                <span class="badge bg-success">Paid</span>
              @endif
            </p>
          </div>
        </div>
      </div>

      <div class="col-12">
        <h2>Order Details</h2>
        <div class="table-responsive" style="overflow-x: auto;">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->orderDetails as $item)
                <tr>
                  <td>{{ $item->product->product_name }}</td>
                  <td>{{ $item->qty }}</td>
                  <td>Rp {{ number_format($item->product->product_price, 2) }}</td>
                  <td>Rp {{ number_format($item->order_subtotal, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-end fw-bold">Grand Total</td>
                <td>Rp {{ number_format($order->order_amount, 2) }}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      @if($order->order_status == 0)
        <div class="col-12">
          <h2>Payment</h2>
          <form action="{{ route('pos.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
              <label for="cash_received" class="form-label">Cash Received</label>
              <input type="number" name="cash_received" id="cash_received" class="form-control" min="{{ $order->order_amount }}" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit Payment</button>
          </form>
        </div>
      @else
        <div class="col-12">
          <h2>Payment Details</h2>
          <p><strong>Change:</strong> Rp {{ number_format($order->order_change, 2) }}</p>
        </div>
        <div class="col-12 text-center">
            <a href="{{ route('print', $order->id) }}" class="btn btn-success">Print Receipt</a>
        </div>
      @endif
    </div>
  </div>
</section>
@endsection
