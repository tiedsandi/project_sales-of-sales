@extends('layouts.admin-layout')

@section('page-title', 'Dashboard')

@section('content')
<section class="py-5 bg-white rounded">
  <form action="{{ route('pos-sale.store') }}" method="POST" id="transaction-form" >
    @csrf
    <div class="container">
      <h1 class="display-4 fw-bold text-center">Point of Sale</h1>
      <div class="row">
        <!-- Form Section -->
        <div class="col-12 col-md-6">
          <div class="mb-4">
            <label for="customer_name" class="form-label">
              Customer Name
              <span class="text-danger small">*</span>
            </label>
            <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name (e.g., Joko)" required>
          </div>
          <div class="mb-4">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-select" >
              <option value="" disabled selected>Select a category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-4">
            <label for="product" class="form-label">Product</label>
            <select id="product" name="product" class="form-select"  disabled>
              <option value="" disabled selected>Select a product</option>
            </select>
          </div>
          <div class="mb-4">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" min="1" disabled >
          </div>
          <div class="mb-4">
            <label for="total" class="form-label">Total</label>
            <input type="text" id="total" name="total" class="form-control" readonly>
          </div>
          <button type="button" id="add-to-cart" class="btn btn-secondary w-100 mb-3">Add to Cart</button>    
        </div>

        <div class="col-12 col-md-6">
          <h2>Shopping Cart</h2>
          <div class="table-responsive">
            <table class="table table-bordered">
          <thead>
            <tr>
              <th>Category</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="cart-items"></tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end fw-bold">Grand Total</td>
              <td id="grand-total">0.00</td>
              <td></td>
            </tr>
          </tfoot>
            </table>
          </div>

          <button type="button" id="clear-cart" class="btn btn-warning w-100 mb-3 d-none">Clear Cart</button>

          <form action="{{ route('pos-sale.store') }}" method="POST" id="transaction-form" class="d-none">
            @csrf
            <input type="hidden" id="cart-data" name="cart_data">
            <input type="hidden" name="cash_received" id="cash-received">
            <input type="hidden" name="change" id="change">
            <button type="submit" id="btn-submit" class="btn btn-primary w-100 d-none">Submit Transaction</button>
        
        </div>
      </div>
    </div>
  </form>
</section>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
  const cart = [];

  $('#category').on('change', populateProducts);
  $('#product').on('change', enableQuantity);
  $('#quantity, #product').on('input change', updateTotal);
  $('#add-to-cart').on('click', addToCart);
  $('#clear-cart').on('click', clearCart);

  function populateProducts() {
    const categoryId = $(this).val();
    const $product = $('#product').empty().append('<option value="" disabled selected>Select a product</option>').prop('disabled', false);

    @foreach($products as $product)
      if ({{ $product->category_id }} == categoryId) {
        $product.append(`<option value="{{ $product->id }}" data-price="{{ $product->product_price }}">{{ $product->product_name }}</option>`);
      }
    @endforeach
  }

  function enableQuantity() {
    $('#quantity').val(1).prop('disabled', false).trigger('input');
  }

  function updateTotal() {
    const price = $('#product option:selected').data('price');
    const qty = $('#quantity').val();

    $('#total').val(price && qty ? (price * qty).toFixed(2) : '');
  }

  function addToCart() {
    const category = $('#category option:selected').text();
    const product = $('#product option:selected').text();
    const productId = $('#product').val();
    const quantity = parseInt($('#quantity').val(), 10);
    const price = $('#product option:selected').data('price');

    if (!productId || !quantity || !price) {
      return showError("Please fill all fields correctly.");
    }

    const itemIndex = cart.findIndex(item => item.productId == productId);

    if (itemIndex !== -1) {
      cart[itemIndex].quantity += quantity;
      cart[itemIndex].total = (cart[itemIndex].price * cart[itemIndex].quantity).toFixed(2);
    } else {
      cart.push({ category, product, productId, quantity, price, total: (price * quantity).toFixed(2) });
    }

    updateCart();
    resetForm();
  }

  function updateCart() {
    const $cartItems = $('#cart-items').empty();

    cart.forEach((item, index) => {
      $cartItems.append(`
        <tr>
          <td>${item.category}</td>
          <td>${item.product}</td>
          <td><input type="number" class="form-control form-control-sm cart-quantity" data-index="${index}" value="${item.quantity}" min="1"></td>
          <td>${item.total}</td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${index})">Remove</button></td>
        </tr>
      `);
    });

    $('.cart-quantity').on('input', updateQuantity);
    const grandTotal = cart.reduce((sum, item) => sum + parseFloat(item.total), 0);

    $('#grand-total').text(grandTotal.toFixed(2));
    $('#cart-data').val(JSON.stringify({
      total: grandTotal,
      orders: cart.map(({ productId, quantity, price, total }) => ({ productId, quantity, price, total }))
    }));

    toggleCartActions();
  }

  function updateQuantity() {
    const index = $(this).data('index');
    const qty = parseInt($(this).val(), 10);

    if (qty > 0) {
      cart[index].quantity = qty;
      cart[index].total = (cart[index].price * qty).toFixed(2);
      updateCart();
    }
  }

  window.removeItem = function(index) {
    confirmAction(`Delete ${cart[index].product}?`, 'This cannot be undone.').then(result => {
      if (result.isConfirmed) {
        cart.splice(index, 1);
        updateCart();
      }
    });
  };

  function clearCart() {
    confirmAction('Clear Cart?', 'Remove all items from cart?').then(result => {
      if (result.isConfirmed) {
        cart.length = 0;
        updateCart();
      }
    });
  }

  function resetForm() {
    $('#category').val('');
    $('#product').empty().append('<option value="" disabled selected>Select a product</option>').prop('disabled', true);
    $('#quantity').val('').prop('disabled', true);
    $('#total').val('');
  }

  function toggleCartActions() {
    const hasItems = cart.length > 0;
    $('#clear-cart').toggleClass('d-none', !hasItems);
    $('#btn-submit').toggleClass('d-none', !hasItems);
  }

  function showError(message) {
    Swal.fire({
      icon: "error",
      title: "Oops!",
      text: message,
      timer: 2000,
      showConfirmButton: false
    });
  }

  function confirmAction(title, text) {
    return Swal.fire({
      title,
      text,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes'
    });
  }

  $('#transaction-form').on('submit', function(e) {
    e.preventDefault(); 

    Swal.fire({
      title: 'Choose Payment Option',
      text: 'Would you like to pay now or later?',
      icon: 'question',
      showCancelButton: true,
      showDenyButton: true,
      confirmButtonText: 'Pay Now',
      denyButtonText: 'Pay Later',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
      payNow();
      } else if (result.isDenied) {
      $('#transaction-form')[0].submit();
      } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        icon: 'info',
        title: 'Cancelled',
        text: 'Payment process has been cancelled.',
        timer: 1500,
        showConfirmButton: false
      });
      }
    });
    });
  });

  function payNow() {
    const grandTotal = parseFloat($('#grand-total').text());

    Swal.fire({
      title: 'Enter Payment Amount',
      input: 'number',
      inputLabel: `Total: Rp ${grandTotal.toFixed(2)}`,
      showCancelButton: true,
      confirmButtonText: 'Pay',
      cancelButtonText: 'Cancel',
      inputAttributes: {
        min: grandTotal,
      },
      preConfirm: (payment) => {
        payment = parseFloat(payment);
        if (isNaN(payment)) {
          Swal.showValidationMessage('Please enter a valid payment amount!');
        } else if (payment < grandTotal) {
          Swal.showValidationMessage('The payment amount is less than the total!');
        }
        return payment;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const bayar = parseFloat(result.value);
        const kembalian = bayar - grandTotal;

        Swal.fire({
          icon: 'success',
          title: 'Transaction Successful!',
          html: `
            Total: Rp ${grandTotal.toFixed(2)}<br>
            Paid: Rp ${bayar.toFixed(2)}<br>
            <b>Change: Rp ${kembalian.toFixed(2)}</b>
          `,
          confirmButtonText: 'OK'
        }).then(() => {
          $('#cash-received').val(bayar);
          $('#change').val(kembalian);

          $('#transaction-form')[0].submit();
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          icon: 'info',
          title: 'Cancelled',
          text: 'Payment input has been cancelled.',
          timer: 1500,
          showConfirmButton: false
        });
      }
    });
  }


</script>
@endsection
