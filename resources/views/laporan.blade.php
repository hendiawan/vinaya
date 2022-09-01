@extends('layouts.jnb.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

                <div class="secInfo sec-dashboard">
                    <h1 class="secTitle">Laporan</h1>
                    <span class="secExtra">Laporan  Monitoring &amp; Vinaya Fit Club berdasarkan:</span>
                </div> <!-- /SecInfo -->

                <ul class="etabs tabs">
                    @can('admin-access')
                    <li class="tab">
                        <a href="#tab1">
                            <span class="to-hide">
                                <i class="fa fa-bar-chart"></i><br>Penjualan
                            </span>
                            <i class="fa icon-hidden fa-address-card-o ttip" data-ttip="Agen Detail"></i>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab2">
                            <span class="to-hide">
                                <i class="fa fa-archive"></i><br>Stok
                            </span>
                            <i class="fa icon-hidden fa-users ttip" data-ttip="Rekap Agen"></i>
                        </a>
                    </li>
                     <li class="tab">
                        <a href="#tab4">
                            <span class="to-hide">
                                <i class="fa fa-credit-card"></i><br>Penerimaan
                            </span>
                            <i class="fa icon-hidden fa-users ttip" data-ttip="Rekap Paket"></i>
                        </a>
                    </li>
                    @endcan
                    
                    <li class="tab">
                        <a href="#tab3">
                            <span class="to-hide">
                                <i class="fa fa-beer"></i><br>Paket
                            </span>
                            <i class="fa icon-hidden fa-users ttip" data-ttip="Rekap Paket"></i>
                        </a>
                    </li>
                   
                    <li class="tab">
                        <a href="#tab5">
                            <span class="to-hide">
                                <i class="fa fa-user-circle"></i><br>Pelanggan
                            </span>
                            <i class="fa icon-hidden fa-users ttip" data-ttip="Rekap Customer"></i>
                        </a>
                    </li>
                   
               
                   
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="topTabsContent">
                @can('admin-access')
                <div id="tab1">	
                    <div class="widget content-tab grid12">	    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-coach-detail') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 control-label"><strong>Nama Coach</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <select id="selectCoach" name="sales_id" class="form-control" required="">
                                         <option value="all">Semua Coach</option>
                                        @foreach($coach as $key => $item) 
                                        <option value="{{$item->id}}">{{$item->karyawan->nama_karyawan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                        <!--<button id="searchAgenDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                        <button id="cetakAgenDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 col-xs-2 control-label"><strong>Periode Penjualan</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <input required="" type="text" id="startDate" class="form-control" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">s/d</span>
                                        <input required="" type="text" id="expiredDate" class="form-control" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-4 text-left">
                                    <button id="searchCoachDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    <button style="margin: 1px"  id="cetakCoachDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                    <button id="cetakSummaryCoach" name="btn_sum" value="summary" type="submit" class="btn btn-green"><i class="fa fa-print"></i></button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            <table id="coach-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                         <thead>
                                    <tr>
                                        <!--<th>id</th>-->
                                        <th>Tgl Jual</th>
                                        <th>Coach</th>
                                        <th>Pelanggan</th>
                                        <th>Qty</th>
                                        <th>Harga Jual</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tab2">		
                     <div class="widget content-tab grid12">	    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-stok-detail') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 control-label"><strong>Nama Coach</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <select id="selectCoachStok" name="sales_id" class="form-control">
                                         <option value="all">Semua Coach</option>
                                        @foreach($coach as $key => $item) 
                                        <option value="{{$item->id}}">{{$item->karyawan->nama_karyawan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
<!--                                        <button id="searchAgenDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                        <button id="cetakAgenDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 col-xs-2 control-label"><strong>Periode Stok</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <input type="text" id="startDateStok" class="form-control startDate hidden" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">s/d</span>
                                        <input type="text" id="expiredDateStok" class="form-control expiredDate" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                    <button id="searchStokDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    <button id="cetakStokDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            <table id="stok-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                 <thead>
                                    <tr>
                                        <!--<th>id</th>-->
                                         <th>Coach</th>
                                        <th>Barang ID</th>
                                        <th>Barang</th>
                                        <th>Takaran</th>
                                        <th>Stok</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
                
                <div id="tab4">	
                    <div class="widget content-tab grid12">	    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-penerimaan-uang') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 control-label"><strong>Nama Coach</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                     <select id="selectCoach2" name="sales_id" class="form-control selectCoach" required="">
                                         <option value="all">Semua Coach</option>
                                        @foreach($coach as $key => $item) 
                                        <option value="{{$item->id}}">{{$item->karyawan->nama_karyawan}}</option>
                                        @endforeach
                                      </select> 
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                        <!--<button id="searchAgenDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                        <button id="cetakAgenDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 col-xs-2 control-label"><strong>Periode Penerimaan</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <input required="" type="text" id="startDatePenerimaan" class="form-control startDate" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">s/d</span>
                                        <input required="" type="text" id="expiredDatePenerimaan" class="form-control expiredDate" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                    <button id="searchPenerimaanDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    @can('admin-access')
                                    <button id="cetakPenerimaanDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                    @endcan
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            <table id="penerimaan-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr> 
                                        <th>No</th>
                                        <th>Tgl Terima</th>
                                        <th>Coach</th>
                                        <th>Pelanggan</th>
                                        <th>Kredit</th> 
                                        <th>Id Paket</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div id="tab5">	
                    <div class="widget content-tab grid12">	    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-pelanggan') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 control-label"><strong>Nama Coach</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                     <select  name="sales_id" class="form-control selectCoach" required="">
                                         <option value="all">Semua Coach</option>
                                        @foreach($coach as $key => $item) 
                                        <option value="{{$item->id}}">{{$item->karyawan->nama_karyawan}}</option>
                                        @endforeach
                                      </select> 
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                        <!--<button id="searchAgenDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                        <button id="cetakAgenDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 col-xs-2 control-label"><strong>Periode Tgl Lahir</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <!--<input required="" type="text" id="startDateCust" class="form-control startDate" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">-->
                                        <span class="input-group-addon">s/d</span>
                                        <input required="" type="text" id="expiredDateCust" class="form-control expiredDate" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                    <button id="searchCustomerDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    @can('admin-access')
                                    <button id="cetakCustomerDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                    @endcan
                                </div>
                            </div>
                        </form>
                        <hr/>
                        
                        <div class="table-responsive">
                            <table id="customer-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr> 
                                        <!--<th>No</th>-->
                                        <th>Nama</th>
                                        <th>No Telp</th>
                                        <th>Tgl Lahir</th>
                                        <th>Umur Sekarang</th> 
                                        <th>Ultah</th>
                                         <th>Alamat</th>  
                                        <th>Coach</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
                
                @endcan
                <div id="tab3">	
                    <div class="widget content-tab grid12">	    
                        <form id="sppsbForm" class="form-horizontal" action="{{ url('/cetak-laporan-penggunaan-paket') }}" method="POST" target="_blank">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-2 control-label"><strong>Nama Pelanggan</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <select id="selectPelanggan" name="pelanggan_id" class="form-control" required="">
                                        @can('admin-access') <option value="all">Semua Pelanggan</option> @endcan
                                        @foreach($pelanggan as  $dataPelanggan) 
                                        <option value="{{$dataPelanggan->id}}">{{$dataPelanggan->nama_pelanggan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                        <!--<button id="searchAgenDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                        <button id="cetakAgenDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-2 col-xs-2 control-label"><strong>Periode Penjualan</strong></label>
                                <div class="col-sm-6 col-xs-5">
                                    <div class="input-group">
                                        <input required="" type="text" id="startDatePelanggan" class="form-control startDate" name="startDate" value="{{ old('startDate') }}" placeholder="dd-mm-yyyy">
                                        <span class="input-group-addon">s/d</span>
                                        <input required="" type="text" id="expiredDatePelanggan" class="form-control expiredDate" name="endDate" value="{{ old('endDate') }}" placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-5 text-right">
                                    <button id="searchPaketDetail" type="button" class="btn"><i class="fa fa-search"></i> CARI</button>
                                    @can('admin-access')
                                    <button id="cetakPaketDetail" type="submit" class="btn btn-green"><i class="fa fa-print"></i> CETAK</button>
                                    @endcan
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="table-responsive">
                            <table id="pelanggan-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr> 
                                        <th>Id Paket</th>
                                        @if(Auth::user()->role=='PA')
                                        <th>Tgl Transaksi</th>
                                        @else
                                         <th>Tgl Jual</th>
                                        @endif
                                        @if(Auth::user()->role!='PA')  
                                         <th>Coach</th>
                                         @endif
                                        <th>Pelanggan</th>
                                        <th>Qty</th>
                                        <th>Harga</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>	
    </div>
</div>
@endsection
@push('scripts')  
<link rel="stylesheet" href="{{ asset('jnb/css/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('jnb/css/select2-4.0.3.css') }}" />

<script type="text/javascript" src="{{ asset('jnb/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('jnb/js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#selectCoach').select2({
        placeholder: "Silahkan pilih Coach",
        allowClear: true
    });
    $('.selectCoach').select2({
        placeholder: "Silahkan pilih Coach",
        allowClear: true
    });
    
    $('#selectCoachStok').select2({
        placeholder: "Silahkan pilih Coach",
        allowClear: true
    });
 
    $('#selectPelanggan').select2({
        placeholder: "Silahkan pilih Pelanggan",
        allowClear: true
    });
 
    $("#coach-datatable").DataTable(); 
    $("#stok-datatable").DataTable(); 
    $("#pelanggan-datatable").DataTable(); 
    $("#penerimaan-datatable").DataTable(); 
    $("#customer-datatable").DataTable(); 
   
    
    if (($('#startDate').length) && ($('#expiredDate').length)) {
        $('#startDate').datepicker({
//            format: 'mm-yyyy',
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
//            viewMode: "months",
//            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('#expiredDate').datepicker('setStartDate', e.date);
        });
        $('#expiredDate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
//            viewMode: "months",
//            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('#startDate').datepicker('setEndDate', e.date);
        });
    }
    
    if (($('.startDate').length) && ($('.expiredDate').length)) {
        $('.startDate').datepicker({
//            format: 'mm-yyyy',
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
//            viewMode: "months",
//            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('.expiredDate').datepicker('setStartDate', e.date);
        });
        $('.expiredDate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
//            viewMode: "months",
//            minViewMode: "months"
        }).on('changeDate', function (e) {
            $('.startDate').datepicker('setEndDate', e.date);
        });
    }
     
    ///proses search report detail 
    $('#searchCoachDetail').on('click', function () {
        //var agenId = $('#selectCoach').val();
        $('#coach-datatable').DataTable().destroy();
        $("#coach-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-detail-penjualan-coach/{id}/{startDate}/{endDate}',
                type: 'GET',
                data: {
                    id: $('#selectCoach').val(),
                    startDate: $('#startDate').val(), 
                    endDate: $('#expiredDate').val() 
                }

            },
            columns: [
                    { data: 'tgl_jual', name: 'tgl_jual',sClass:'text-center'  }, 
                   { data: 'sales.karyawan.nama_karyawan', name: 'pelanggan.sales.karyawan.nama_karyawan',sClass:'text-center',searchable: true  }, 
//                   { data: 'pelanggan.nama_pelanggan', name: 'pelanggan.nama_pelanggan',sClass:'text-center',searchable: true  }, 
                   { data: 'nama_pelanggan', name: 'nama_pelanggan',sClass:'text-center',searchable: true,  }, 
                   { data: 'qty_jual', name: 'qty_jual', sClass:'text-center' },
                   { data: 'harga_jual', name: 'harga_jual', sClass:'text-center' ,
                                           render: function (data) {
                                               return '<strong>'+formatNumber(data)+'</strong>';
                       }},
            ],
            aaSorting: []
        });
    })
    ///proses search report All
    $('#searchStokDetail').on('click', function () {
        //var agenId = $('#selectCoach').val();
        $('#stok-datatable').DataTable().destroy();
        $("#stok-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-detail-stok-coach/{id}/{startDate}/{endDate}',
                type: 'GET',
                data: {
                    id: $('#selectCoachStok').val(),
                    startDate: $('#startDateStok').val(), 
                    endDate: $('#expiredDateStok').val() 
                },
//               success:function(data){
//                   console.log(data);
//               }
               

            },
            columns: [
             
                    { data: 'sales.karyawan.nama_karyawan', name: 'sales_id'  },  
                    { data: 'barang_id', name: 'barang_id'  },   
                    { data: 'barang.nama_barang', name: 'barang.nama_barang'  },  
                    { data: 'barang.takaran', name: 'barang.takaran'  },  
                    { data: 'stok', name: 'stok'  },  
                 
                  
            ],
            aaSorting: []
        });
    })
    ///proses search report Paket
    $('#searchPaketDetail').on('click', function () {
        //var agenId = $('#selectCoach').val();
        $('#pelanggan-datatable').DataTable().destroy();
        $("#pelanggan-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-detail-paket/{id}/{startDate}/{endDate}',
                type: 'GET',
                data: {
                    id: $('#selectPelanggan').val(),
                    startDate: $('#startDatePelanggan').val(), 
                    endDate: $('#expiredDatePelanggan').val() 
                }

            },
            columns: [
                   { data: 'paket_id', name: 'paket_id',sClass:'text-center'  }, 
                   { data: 'tgl_jual', name: 'tgl_jual',sClass:'text-center'  }, 
                    @if(Auth::user()->role!='PA')  
                    { data: 'sales.karyawan.nama_karyawan', name: 'pelanggan.sales.karyawan.nama_karyawan',sClass:'text-center',searchable: true  }, 
                    @endif
                   { data: 'pelanggan.nama_pelanggan', name: 'pelanggan.nama_pelanggan',sClass:'text-center',searchable: true  }, 
                   { data: 'qty_jual', name: 'qty_jual', sClass:'text-center' },
                   { data: 'harga_jual', name: 'harga_jual', sClass:'text-center' ,
                                           render: function (data) {
                                               return '<strong>'+formatNumber(data)+'</strong>';
                       }},
            ],
            aaSorting: []
        });
    }) 
    //proses penerimaan uang
    $('#searchPenerimaanDetail').on('click', function () { 
//    alert('halo');
        //var agenId = $('#selectCoach').val();
        $('#penerimaan-datatable').DataTable().destroy();
        $("#penerimaan-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-penerimaan-uang/{id}/{startDate}/{endDate}',
                type: 'GET',
                data: {
                    id: $('#selectCoach2').val(),
                    startDate: $('#startDatePenerimaan').val(), 
                    endDate: $('#expiredDatePenerimaan').val() 
                }

            },
            columns: [
                   { data: 'id', name: 'id',sClass:'text-center'  }, 
                   { data: 'tgl_bayar', name: 'tgl_bayar',sClass:'text-center'  }, 
                   { data: 'paket.pelanggan.sales.karyawan.nama_karyawan', name: 'debet',sClass:'text-center',searchable: true  }, 
                   { data: 'paket.pelanggan.nama_pelanggan', name: 'debet',sClass:'text-center',searchable: true  }, 
                   { data: 'kredit', name: 'kredit',sClass:'text-center',searchable: true  }, 
                   { data: 'paket_id', name: 'paket_id', sClass:'text-center' },
                 
            ],
            aaSorting: []
        });
    })
     
    //pencarian data pelanggan
    $('#searchCustomerDetail').on('click', function () { 
    
//    alert('halo');
      
    
        //var agenId = $('#selectCoach').val();
        $('#customer-datatable').DataTable().destroy();
        $("#customer-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/") }}/getdata-pelanggan/{id}/{endDate}',
                type: 'GET',
                data: {
                    id: $('.selectCoach').val(),
//                    startDate: $('#startDateCust').val(), 
                    endDate: $('#expiredDateCust').val() 
                }

            },
            columns: [
                 
//                   { data: 'id', name: 'id',sClass:'text-center'  }, 
                   { data: 'nama_pelanggan', name: 'nama_pelanggan',sClass:'text-center'  }, 
                   { data: 'telp', name: 'telp',sClass:'text-center'  }, 
                   { data: 'tgl_lahir', name: 'tgl_lahir',sClass:'text-center',searchable: true  }, 
                   { data: 'umur', name: 'umur',sClass:'text-center',searchable: true  }, 
                   { data: 'hari', name: 'hari',sClass:'text-center',searchable: true  }, 
                   { data: 'alamat', name: 'alamat',sClass:'text-center',searchable: true  }, 
                   { data: 'sales.karyawan.nama_karyawan', name: 'nama_coach',sClass:'text-center',searchable: true  }, 
//                   { data: 'kredit', name: 'kredit',sClass:'text-center',searchable: true  }, 
//                   { data: 'paket_id', name: 'paket_id', sClass:'text-center' },
                 
            ],
            aaSorting: []
        });
    })
     
     
     
     
     
    function formatNumber(num) {
                                  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                           }
});
</script>
@endpush