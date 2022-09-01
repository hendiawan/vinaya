<div id="sidebar">
    <ul class="mainNav">

            @can('pelanggan-access')
            <li class="{{ Request::is('dashboard-pelanggan') ? 'active' : '' }}">
                <a  href="{{ url('/dashboard-pelanggan') }}"><i class="fa fa-th"></i><br>Dashboard</a>
            </li>
            @endcan
            @can('owner-access')
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a  href="{{ url('/dashboard') }}"><i class="fa fa-th"></i><br>Dashboard</a>
            </li>
            @endcan
            @can('staff-access')
            <li class="{{ Request::is('dashboard-sales') ? 'active' : '' }}">
                <a  href="{{ url('/dashboard-sales') }}"><i class="fa fa-th"></i><br>Dashboard</a>
            </li>
            @endcan
              @can('admin-access')
             <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a  href="{{ url('/dashboard') }}"><i class="fa fa-th"></i><br>Dashboard</a>
            </li>
           <li class="{{ Request::is('penjualan') ? 'active' : '' }}">
                <a href="{{ url('/penjualan') }}"><i class="fa fa-bar-chart-o"></i><br>Penjualan</a>
            </li> 
           <li class="{{ Request::is('pembelian') ? 'active' : '' }}">
                <a href="{{ url('/pembelian') }}"><i class="fa fa-bars"></i><br>Stok</a>
            </li>
           <li class="{{ Request::is('hutang') ? 'active' : '' }}">
                <a href="{{ url('/hutang') }}"><i class="fa fa-cc-mastercard"></i><br>Hutang</a>
            </li>
           @endcan
           <li class="{{ Request::is('laporan') ? 'active' : '' }}">
                <a href="{{ url('/laporan') }}"><i class="fa fa-print"></i><br>Laporan</a>
            </li>
    </ul>
</div> <!-- /sidebar -->