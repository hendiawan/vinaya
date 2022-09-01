
@php
 function cek_kadaluarsa($paket){
        $tanggal1 = new DateTime($paket->tgl_kadaluarsa);
        $tanggal2 = new DateTime();

        $perbedaan = $tanggal1->diff($tanggal2)->format("%a");
        echo $perbedaan;
        }
@endphp
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
                        <span >
                           <i  data-toggle="tooltip" title="Penggunaan Paket" class="fa fa-coffee"></i> 
                        <br>Digunakan : <b  style="color: red;font-size: 16px">{{$penjualan_all}}</b>
                        </span> 
                    </a>
                </li>
                <li class="tab">
                    <a href="#tab1">
                        <span >
                            <i data-toggle="tooltip" title="Sisa Paket" class="fa fa-battery-quarter"></i> 
                            <br>Sisa  :   <b  style="color: red;font-size: 17px">{{$stok_all}}</b>
                        </span> 
                    </a>
                </li>
                
            </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent">
                <div id="tab1">
                    @can('admin-access')
                    <a href="{{ url('/penjualan') }}" class="hexagon orange ttip" data-ttip="Input Penjualan "><i class="fa fa-plus"></i></a>
                     <a href="{{ url('/tabel-penjualan') }}" class="hexagon aqua ttip" data-ttip="Data Table Penjualan"><i class="fa fa-table"></i></a>
                     @endcan
                     <a href="{{ url('/laporan') }}" class="hexagon lavender ttip" data-ttip="Cetak Laporan"><i class="fa fa-print"></i></a>
                    <a href="{{ url('/ganti-password') }}" class="hexagon red ttip" data-ttip="Ganti Password"><i class="fa fa-asterisk"></i></a>
                    <a href="{{ url('/profile-pengguna') }}"  class="hexagon blue ttip" data-ttip="Profil User"><i class="fa fa-user"></i></a>
                    <a href="https://www.vinayavitclub.com" target="blank" class="hexagon grey ttip" data-ttip="website Resmi"><i class="fa fa-globe"></i></a>
                </div> 
            </div> <!-- /topTabContent -->

        </div> <!-- /tab-container -->

        <!-- </div> -->
    </div> <!-- /topTabs -->
    
    <div class="fluid form-horizontal">             
        <div class="widget leftcontent grid12">
            <div class="widget-header">
                <h3 class="widget-title">INFORMASI PEMBELIAN</h3>
            </div>
            <div class="widget-content pad20f">
                 <div class="form-group">
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>Tgl Daftar Paket</strong> (Paket Aktif)</div>
                @if(isset($paket->tgl_beli))
                        <h3><span >{{date('d-m-Y',strtotime($paket->tgl_beli))}}</span></h3>
                        
                    </div>
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>Tgl Berakhir Paket</strong> (Paket Aktif)</div>
                        <h3 style="color: red"><span >{{date('d-m-Y',strtotime($paket->tgl_kadaluarsa))}}</span></h3>
                                    @php
                                      $today 	= date('d-m-Y');
                                      $expired 	=  $paket->tgl_kadaluarsa;

                                      $today 	= strtotime( $today );
                                      $expired 	= strtotime( $expired );	 
                                    @endphp 			 
                         @if($today  > $expired)
                                <div style="width: 80%" class="stat-tab-q"><div class="alert alert-danger">Paket sudah kadaluarsa</div></div>
                        @else
                                
                                 <div class="stat-tab-q"><b style="color:red">{{cek_kadaluarsa($paket)}}</b> - Hari Lagi</div>
                        @endif
                        @else
                        <div style="width: 85%" class="stat-tab-title"><div class="alert alert-danger">Anda belum mendaftarkan Paket !</div></div>
                        @endif
                    </div>
                </div>
                 <div class="form-group">
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>TOTAL PENGGUNAAN</strong> (Paket Aktif)</div>
                        <h3>Rp. <span >{{number_format($penggunaan_paket,0,',','.')}}</span></h3>
                    </div>
                    <div class="chart-desc grid6">
                        <div class="stat-tab-title"><strong>SALDO PEMBAYARAN</strong> (Paket Aktif)</div>
                        <h3 style="color: red">Rp. <span >{{number_format($saldo,0,',','.')}}</span></h3>
                    </div>
                </div>
            </div> 
            <div class="divider"></div> 
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