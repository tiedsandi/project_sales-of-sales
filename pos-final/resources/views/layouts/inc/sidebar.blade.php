<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="/">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <!-- Pimpinan (Role 2) -->
    @if(auth()->user()->role_id == 2)
      <li class="nav-heading">Stock & Reports</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#stock-reports-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Stock & Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="stock-reports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/stock">
              <i class="bi bi-circle"></i><span>Stock Product</span>
            </a>
          </li>
          <li>
            <a href="/report">
              <i class="bi bi-circle"></i><span>Report Orders</span>
            </a>
          </li>
        </ul>
      </li>
    @endif

    <!-- Kasir (Role 3) -->
    @if(auth()->user()->role_id == 3)
      <li class="nav-heading">Stock & Casheer</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/kasir">
          <i class="bi bi-grid"></i>
          <span>Casheer</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/stock">
          <i class="bi bi-grid"></i>
          <span>Stock Product</span>
        </a>
      </li>
    @endif

    <!-- Administrator (Role 1) -->
    @if(auth()->user()->role_id == 1)
      <li class="nav-heading">Master Data</li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#master-data-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="master-data-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/product">
              <i class="bi bi-circle"></i><span>Product</span>
            </a>
          </li>
          <li>
            <a href="/users">
              <i class="bi bi-circle"></i><span>User</span>
            </a>
          </li>
          <li>
            <a href="/category">
              <i class="bi bi-circle"></i><span>Category</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-heading">Order</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/report">
          <i class="bi bi-grid"></i>
          <span>Order</span>
        </a>
      </li>
    @endif

  </ul>

</aside><!-- End Sidebar -->
