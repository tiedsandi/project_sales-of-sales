@extends('layouts.admin-layout')
@extends('layouts.main')
@section('page-title', 'Order')
@section('content')

@anyrole(['Pimpinan','Administrator'])
  <section class="bg-white p-4 rounded mb-4">
    <form method="GET" action="{{ route('pos.index') }}">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label for="type" class="form-label">Jenis Laporan</label>
          <select name="type" id="type" class="form-select">
            <option value="daily" {{ request('type') == 'daily' ? 'selected' : '' }}>Harian</option>
            <option value="weekly" {{ request('type') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
            <option value="monthly" {{ request('type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="date" class="form-label">Tanggal Acuan</label>
          <input type="date" name="date" id="date" class="form-control" value="{{ request('date') ?? date('Y-m-d') }}">
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
      </div>
    </form>
  </section>

  @if(isset($report))
  <section class="bg-light p-4 rounded mb-4">
    <h4>Laporan Penjualan - {{ ucfirst(request('type')) }} ({{ request('date') }})</h4>
    <ul class="list-group">
      <li class="list-group-item d-flex justify-content-between">
        Total Transaksi
        <span>{{ $report['total_orders'] }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        Total Pendapatan
        <span>Rp. {{ number_format($report['total_amount'], 2) }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        Rata-rata Transaksi
        <span>Rp. {{ number_format($report['average'], 2) }}</span>
      </li>
    </ul>
  </section>
  @endif
@endanyrole


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
          <th>Total Amount</th>
          <th>Change</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($orders as $order)
          <tr>
            <td>{{ $orders->firstItem() + $loop->iteration - 1 }}</td>
            <td>{{ $order->order_code }}</td>
            <td>Rp. {{ number_format($order->order_amount, 2) }}</td>
            <td>Rp. {{ number_format($order->order_change, 2) }}</td>
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
              <a href="{{route('print', $order->id)}}" class="btn btn-sm btn-success" target="_blank">
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
