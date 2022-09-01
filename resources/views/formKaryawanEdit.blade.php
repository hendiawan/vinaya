@extends('layouts.jnb.app')

@section('content')
<div id="main" class="clearfix">
    <div class="secInfo">
        <h1 class="secTitle">Form Edit Data Builder</h1>
        <span class="secExtra">Form Edit Builder  Nutrition Club</span>

    </div> <!-- /SecInfo -->
    <div class="fluid">				
        <div class="widget leftcontent grid12">
            <div class="topTabs">					
                <div id="topTabs-container-form">
                    <div class="topTabs-header clearfix">						
                        <ul class="etabs tabs">
                            <li class="tab">
                                <a href="#tab1" class="member">
                                    <span class="to-hide">
                                       
                                    </span>
                                    <i class="fa icon-hidden fa-tag" data-toggle="tooltip" data-placement="bottom" title="Member"></i>
                                </a>
                            </li>
                             
                        </ul> <!-- /tabs -->
                    </div><!-- /topTabs-header -->
                    <div class="topTabsContent" style="padding-left:0;">
                        <div id="tab1">
                            <form id="form-penjualan" class="form-horizontal" method="POST" action="{{ url('/') }}/detail-karyawan/{{$data->id}}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="PUT"> 
                            <br>
                     	 
                            <div class="widget-header">
                                <h3 class="widget-title">DATA BUILDER</h3>
                            </div>
                            <div class="widget-content pad20f">     
                               <div class="form-group">
                                    <label for="nama_karyawan" class="col-sm-3 control-label">Nama Builer <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_karyawan" value="{{ old('nama_karyawan',$data->nama_karyawan) }}" class="form-control" id="nama_karyawan">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="jabatan" class="col-sm-3 control-label">Jabatan <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select id="jabatan" name="jabatan" class="form-control">
                                            <option value="">Pilih Jabatan</option> 
                                            <option @if($data->jabatan=='Admin') selected='' @endif value="Admin">Admin</option> 
                                            <option @if($data->jabatan=='Sales') selected='' @endif value="Sales">Nempeler</option> 
                                            <option @if($data->jabatan=='Owner') selected='' @endif value="Owner">Owner</option> 
                                        </select> 
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="telp" class="col-sm-3 control-label">No Telephone</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="telp" value="{{ old('telp',$data->telp) }}" class="form-control" id="telp">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="alamat" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="alamat" value="{{ old('alamat',$data->alamat) }}" class="form-control" id="alamat">
                                    </div>
                                </div>    
                            </div> 				
                     				
                            <div class="widget-header">
                                <h3 class="widget-title">TANGGAL EDIT</h3>
                            </div>
                            <div class="widget-content pad20f">      
                                     <div class="form-group {{ $errors->has('tgl_transaksi') ? ' has-error' : '' }}">
                                    <label for="tgl_transaksi" class="col-sm-3 control-label">Tgl Transaksi <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input readonly="" type="text" name="tgl_transaksi" value="<?php echo old('tgl_transaksi', date('d-m-Y')) ?>" class="form-control  clearClone tgl_transaksi " placeholder="dd-mm-yyyy">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <a href="{{ url('/home') }}" class="btn btn-dark-grey"><i class="fa fa-undo"></i> KEMBALI</a>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <button  id="proses" type="submit" class="btn"><i class="fa fa-save"></i> PROSES</button>
                                    </div>
                                </div>
                            </div> 				
                        </form>
                        </div> 
                        <div id="tab3"></div>
                        <div id="tab4"></div>
                        <div id="tab5"></div>
                        <div id="tab6"></div>
                        	
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /fluid -->

</div> <!-- /main -->

@endsection

@push('scripts')    
<link rel="stylesheet" href="{{ asset('jnb/css/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="{{ asset('jnb/css/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('jnb/css/select2-4.0.3.css') }}" />

<script type="text/javascript" src="{{ asset('jnb/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('jnb/js/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('jnb/js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () { 
var li = 'li:first-child';
        @if (old('jenis') == 1) var li = 'li:first-child'; @endif
        @if (old('jenis') == 2) var li = 'li:nth-child(2)'; @endif 
 
 
$('a.non_member').on('click', function () {
//      alert('Non member')
});

$('a.member').on('click', function () {
//      alert('member') 
});

 
 $('#topTabs-container-form').easytabs({
        updateHash: false,
        tabs: "ul.etabs > li",
        animate: true,
        defaultTab: li,
        transitionIn: 'slideDown',
        transitionOut: 'slideUp'
});

$('.autoNumeric').autoNumeric('init');

$('#tgl_transaksi, #tgl_cetak').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
});

$('.tgl_transaksi').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
});

 if (($('#startDate').length) && ($('#expiredDate').length)) {
            $('#startDate').datepicker({
            format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
            }).on('changeDate', function (e) {
            $('#expiredDate').datepicker('setStartDate', e.date);
            });
                    $('#expiredDate').datepicker({
            format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
            }).on('changeDate', function (e) {
            $('#startDate').datepicker('setEndDate', e.date)
                    calculate();
            });
}
  
        function calculate() {
        var d1 = $('#startDate').datepicker('getDate');
                var d2 = $('#expiredDate').datepicker('getDate');
                var oneDay = 24 * 60 * 60 * 1000;
                var diff = 0;
                if (d1 && d2) {

        diff = Math.round(Math.abs((d2.getTime() - d1.getTime()) / (oneDay)));
        }
        $('#durasi').val(diff + 1);
//$('.minim').val(d1)
        }

}); 
        function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }
</script>
@endpush