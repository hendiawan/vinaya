@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="topTabs"> 
        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

            <div class="secInfo sec-dashboard">
                <h1 class="secTitle">Dashboard</h1>
                <span class="secExtra">Selamat datang!</span>
            </div> <!-- /SecInfo -->
            
            <ul class="etabs tabs">
                <li class="tab">
                    <a href="#tab1">
                        <span class="to-hide">
                            <i class="fa fa-th"></i><br>Quick Menu
                        </span>
                        <i class="fa icon-hidden fa-th" data-toggle="tooltip" title="Quick Menu"></i>
                    </a>
                </li>
                <li class="tab">
                    <a href="#tab2">
 
                    </a>
                </li>
            </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent">
                <div id="tab1">
                    <a href="{{ url('/penjualan') }}" class="hexagon orange ttip" data-ttip="Input Penjualan "><i class="fa fa-plus"></i></a>
                     <a href="{{ url('/tabel-penjualan') }}" class="hexagon aqua ttip" data-ttip="Data Table Penjualan"><i class="fa fa-table"></i></a>
                    <a href="{{url('/tabel-paket')}}" target="blank" class="hexagon grey ttip" data-ttip="Tabel Paket"><i class="fa fa-beer"></i></a>
                     <a href="{{ url('/laporan') }}" class="hexagon lavender ttip" data-ttip="Cetak Laporan"><i class="fa fa-print"></i></a>
                    <a href="{{ url('/ganti-password') }}" class="hexagon red ttip" data-ttip="Ganti Password"><i class="fa fa-asterisk"></i></a>
                    <a href="{{ url('/profile-pengguna') }}"  class="hexagon blue ttip" data-ttip="Profil User"><i class="fa fa-user"></i></a>
                    
                </div>
                <div id="tab2" class="content-tab" style="padding-top:20px;">
                    <div id="orderChart"><div id="chart-orders" class="chart"></div></div>
                </div>
            </div> <!-- /topTabContent -->

        </div> <!-- /tab-container -->

        <!-- </div> -->
    </div> <!-- /topTabs -->
   
    <div class="divider"></div>
    
    <div class="fluid form-horizontal">             
        <div class="widget leftcontent grid12">
            <div class="widget-header">
                <h3 class="widget-title">INFORMASI PENJUALAN DALAM SATU BULAN</h3>
            </div> 
            <div class="widget-content pad20f">
                @if (Session::has('message'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-info-circle"></i> {{ Session::get('message') }}
                </div>
                @endif
                 <div class="form-group">
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>TOTAL PENJUALAN</strong> (Semua Produk)</div>
                        <h3>Rp. <span >{{number_format($data_penjualan,0,',','.')}}</span></h3>
                    </div>
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>TOTAL PENERIMAAN UANG</strong> (Semua Produk)</div>
                        <h3>Rp. <span >{{number_format($data_pembelian,0,',','.')}}</span></h3>
                    </div>
                </div>
            </div> 
            <div class="divider"></div>
             <div class="widget-header">
                <h3 class="widget-title">PENJUALAN BY MENU DALAM SATU BULAN</h3>
            </div>
            <div class="widget-content pad20">
                <div class="form-group">
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Paket 1x Minum</div>
                        <div class="stat-tab-hour">Total Penjualan : </div>
                          <a class="stat-tab-q">Rp. {{number_format($paket1xMinum,0,',','.')}}</a>
                    </div>
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Paket 10x Minum</div>
                          <div class="stat-tab-hour">Total Penjualan : </div> 
                           <a class="stat-tab-q">Rp. {{number_format($paket10xMinum,0,',','.')}}</a>
                    </div>
                    <div class="chart-desc grid4">
                        <div class="stat-tab-title">Paket 30x Minum</div>
                          <div class="stat-tab-hour">Total Penjualan : </div> 
                         <a class="stat-tab-q">Rp. {{number_format($paket30xMinum,0,',','.')}}</a>
                    </div>
                </div>
            </div>     
                
        </div> <!-- /widget -->
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('jnb/js/jquery.flot.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jnb/js/jquery.flot.resize.js') }}"></script>    
    <script type="text/javascript" src="{{ asset('jnb/js/jquery.flot.tooltip_0.4.3.min.js') }}"></script>
    <script type="text/javascript">
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "positionClass": "toast-bottom-right",
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        setTimeout(function(){
            toastr.info('<span style="color:#333;">Selamat datang di aplikasi Penjualan Vinaya</span>');  
        },2000) ;


    </script>
@endpush