<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-ipad-retina.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-iphone.png" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('jnb/css/bootstrap-3.3.7/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('jnb/css/dataTables.bootstrap.css') }}" />
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('jnb/css/font-awesome-4.7/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('jnb/css/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jnb/css/style.css') }}"/>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style>
        .topSearch {
        font-family: 'eausans_book', 'sans';
                      margin-top: 20px;
                      margin-left: 32%;
	font-size: 12px;
	padding: 5px 15px;
	width: 200px;
	height: 32px; 
	float: left;
	border-radius:15px;
	border: 1px solid rgba(0,0,0,0.6);
	box-shadow: inset 1px 1px 0 rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <!--
    <div id="loading">
        <div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    -->
    <!-- loading style -->
    <div id="customLoad">
        <div class="spinner"></div>
        <strong>MOHON TUNGGU...</strong>
        <div class="loadInfo">proses update data sedang berlangsung</div>
    </div>
    <div id="wrapper" class="container">

        <div id="top">
            <div id="topBar">
                <div class="wrapper20">
                    <a class="logo" href="#" title=""> 
                        <img style="width:18%;border-radius: 3px" src="{{ asset('assets/img') }}/logo.jpeg" rel="logo">
                    </a>
                    <!--<input   class="topSearch" type="text" placeholder="Search...">-->
                    <div class="topNav clearfix">
                       
                        <ul class="tNav clearfix btn-progress">
                              @can('pelanggan-access')
                            <li style="width: 60px; border-radius: 20px;"><a href="{{ url('/dashboard-pelanggan') }}" style="margin-left: 10%">Home</a> </li>
                            @endcan 
                              @can('owner-access')
                            <li style="width: 60px; border-radius: 20px;"><a href="{{ url('/dashboard-pelanggan') }}" style="margin-left: 10%">Home</a> </li>
                            @endcan 
                            @can('admin-access')
                             <li style="width: 60px; border-radius: 20px;"><a href="{{ url('/dashboard') }}" style="margin-left: 10%">Home</a> </li>
                            <li style="width: 50px; border-radius: 20px;"><a data-toggle="dropdown" href="#" style="margin-left: 8%">Data</a>
                             <ul class="dropdown-menu pull-right">
                                    <li><a href="{{ url('/tabel-barang') }}"><i class="fa fa-times"></i> Tabel Barang</a></li>
                                     <li><a href="{{ url('/tabel-harga') }}"><i class="fa fa-times"></i> Tabel Harga</a></li>  
                                    <li><a href="{{ url('/tabel-pelanggan') }}"><i class="fa fa-times"></i> Tabel Customer</a></li> 
                                    <li><a href="{{ url('/tabel-karyawan') }}"><i class="fa fa-times"></i> Tabel Nempeler</a></li> 
                                    <li><a href="{{ url('/tabel-sales') }}"><i class="fa fa-times"></i> Tabel Coach</a></li>  
                                    <li><a href="{{ url('/tabel-penjualan') }}"><i class="fa fa-times"></i> Tabel Penjualan</a></li>  
                                    <li><a href="{{ url('/tabel-pembelian') }}"><i class="fa fa-times"></i> Tabel Stok</a></li>  
                                    <li><a href="{{ url('/tabel-menu') }}"><i class="fa fa-times"></i> Tabel Menu</a></li>  
                                    <li><a href="{{ url('/tabel-menu-detail') }}"><i class="fa fa-times"></i> Tabel Menu Detail</a></li>  
                                    <li><a href="{{ url('/tabel-paket') }}"><i class="fa fa-times"></i> Tabel Paket</a></li>  
                                    <li><a href="{{ url('/tabel-hutang') }}"><i class="fa fa-times"></i> Tabel Hutang</a></li>  
                                  </ul>
                            </li>
                            <li style="width: 60px; border-radius: 20px;"><a data-toggle="dropdown" href="#" style="margin-left: 8%">Master</a>
                            <ul class="dropdown-menu pull-right">
                                    <li><a href="{{ url('/barang') }}"><i class="fa fa-times"></i> Tambah Barang</a></li>
                                    <li><a href="{{ url('/harga-add') }}"><i class="fa fa-times"></i> Tambah Daftar Harga</a></li>  
                                    <li><a href="{{ url('/pelanggan-add') }}"><i class="fa fa-times"></i> Tambah Customer</a></li> 
                                    <li><a href="{{ url('/karyawan-add') }}"><i class="fa fa-times"></i> Tambah Nempeler</a></li> 
                                    <li><a href="{{ url('/sales-add') }}"><i class="fa fa-times"></i> Tambah Coach</a></li>  
                                    <li><a href="{{ url('/TambahPengguna') }}"><i class="fa fa-times"></i> Tambah User</a></li> 
                                    <li><a href="{{ url('/managemen-user') }}"><i class="fa fa-times"></i> Management User</a></li>  
                                  </ul>
                            </li> 
                            <li style="width: 80px; border-radius: 20px;"><a data-toggle="dropdown" href="#" style="margin-left: 8%">Transaksi</a> 
                            <ul class="dropdown-menu pull-right"> 
                                     <li><a href="{{ url('/menu') }}"><i class="fa fa-times"></i> Tambah Menu</a></li> 
                                    <li><a href="{{ url('/menudetail') }}"><i class="fa fa-times"></i> Tambah Menu Detail</a></li> 
                                    <li><a href="{{ url('/paket') }}"><i class="fa fa-times"></i> Tambah Paket</a></li> 
                                   <li><a href="{{ url('/hutang') }}"><i class="fa fa-times"></i> Bayar Hutang</a></li> 
                                    <li><a href="{{ url('/penjualan') }}"><i class="fa fa-times"></i> Tambah Penjualan</a></li>
                                    <li><a href="{{ url('/pembelian') }}"><i class="fa fa-times"></i> Tambah Stok</a></li> 
                                 
                           </ul>
                            </li>
                           @endcan
                            <li data-toggle="tooltip" data-placement="bottom" title="Keluar (Logout)">
                                <a href="" data-toggle="modal" data-target=".logout-modal-sm">
                                    <i class="fa fa-sign-out icon-white"></i>
                                </a>
                                <!--
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out icon-white"></i>
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                -->
                            </li>
                        </ul>
                    </div> <!-- /topNav -->
                </div>
            </div> <!-- /topBar -->

            @include('layouts.jnb.header')
            
        </div> <!-- /top -->

        @include('layouts.jnb.leftsidebar')
        <!-- MODAL LOGOUT -->
        <div class="modal fade logout-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-warning"></i> Peringatan</h4>
                    </div>
                    <div class="panel-body">
                    Anda yakin akan keluar dari aplikasi?
                    </div>
                    <div class="panel-footer">
                        <form action="{{ url('/logout') }}" method="POST">
                            {{ csrf_field() }}
                        <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button>
                        <button id="logoutButton" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>        

        @yield('content')
    </div> <!-- /wrapper -->
    <div class="clearfix"></div>

    <!-- MODAL CHECK ALERT -->
    <div class="modal fade formcheck-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="panel-title" id="gridSystemModalLabel"><i class="fa fa-warning"></i> Peringatan</h4>
                </div>
                <div class="panel-body">
                Silahkan checklist kebenaran data yang anda inputkan
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-grey" data-dismiss="modal"><i class="fa fa-close"></i> Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Detail SPPSB</h4>
                </div>
                <div class="modal-body" style="max-height:460px;overflow:auto;">
                    <p>Loading...</p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-info" type="button"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

 

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('jnb/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/autoNumeric.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/jquery.sparkline.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/jquery.easytabs.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/excanvas.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/main.js') }}"></script>
    @stack('scripts')
    
</body>
</html>
