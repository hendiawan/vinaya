@extends('layouts.jnb.app')

@section('content')	
<div id="main" class="clearfix">
    <div class="topTabs">

        <div id="topTabs-container-home">
            <div class="topTabs-header clearfix">

                <div class="secInfo sec-dashboard">
                    <h1 class="secTitle">Data Table</h1>
                    <span class="secExtra">Tabel daftar seluruh data:</span>
                </div> <!-- /SecInfo -->

                <ul class="etabs tabs">
                    <li class="tab">
                        <a href="#tab1">
                            <span class="to-hide">
                                <i class="fa fa-folder-open"></i><br>Data Paket
                            </span>
                            <i class="fa icon-hidden fa-folder-open ttip" data-ttip="Data "></i>
                        </a>
                    </li>
                    
                </ul> <!-- /tabs -->
            </div><!-- /topTabs-header -->

            <div class="widget-content pad20f" style="padding-bottom:0">	
                <div class="alert alert-info" style="margin-bottom:0" role="alert">
                    <h4><i class="fa fa-info-circle"></i> Informasi!</h4>
                    <ul style="padding-left: 20px !important;">
                        <li>Tabel dibawah memuat semua data Paket yang telah dimasukkan</li> 
                    </ul>
                </div>
            </div>
         
            <div class="widget-header">
                <div class="icon-grp" style="padding-top:10px;">
                    <a href="/paket" class="btn btn-blue">
                        <i class="fa fa-user-plus"></i> Tambah Paket
                    </a>
                </div>
            </div>
            
            <div class="topTabsContent" style="padding-left:0;">
                <div id="tab1">
                    <div class="widget content-tab grid12" style="padding-left:30px;">
                        <div class="widget-content">	
                            @if(Session::has('msgupdate'))
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i> {{ Session::get('msgupdate') }}
                            </div>
                            @endif
                            @if(Session::has('msgupdateaxis'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i> {{ Session::get('msgupdateaxis') }}
                            </div>
                            @endif
                            <table id="sppsb-datatable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr> 
                                        <th>Tanggal Beli</th>
                                        <th>Pelanggan</th>
                                        <th>Menu</th> 
                                        <th>Harga</th> 
                                        <th>Total Bayar</th> 
                                        <th>Status</th> 
                                        <th>Bayar</th> 
                                        @can('admin-access')   
                                        <th>Aksi</th> 
                                        @endcan
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
    </div> <!-- /fluid -->

</div> <!-- /main -->
@endsection

@push('scripts')
	<script>
  $(document).ready(function() {

var tablePaket =  	    $("#sppsb-datatable").DataTable({
                
	        processing: true,
	        serverSide: true,
	        ajax: '{{ url("/") }}/getdata-paket',
	        columns: [  
	            { data: 'tgl_beli', name: 'tgl_beli',sClass:'text-center'  }, 
                                  { data: 'pelanggan.nama_pelanggan', name: 'pelanggan.nama_pelanggan', sClass:'text-center' },
	            { data: 'menu.nama_menu', name: 'menu.nama_menu',sClass:'text-center',searchable: true  },   
	            { data: 'harga', name: 'harga', sClass:'text-center' , render:
                                    function(data){
                                        return formatNumber(data);
                                    }}, 
                                  { data: 'totalbayar', name: 'totalbayar',sClass:'text-center',searchable: true , render:
                                    function(data){
                                        return formatNumber(data);
                                    } },  
	            { data: 'status', name: 'status', sClass:'text-center', render:
                                    function(data){
                                             var label = "", title="";
//                                        alert(data);
                                         if         (data=='aktif'){ label="btn-success"; title="Aktif" ; }
                                        else if(data=='habis'){ label="btn-red"; title="Habis";}
                                        else if(data=='umum'){ label="btn-orange"; title="Umum";}
                                        else if(data=='nonAktif'){ label="btn-grey"; title="Non Aktif";}
                                        return '<a class="btn '+label+'">'+title+'</a>';
                                    }}, 
	            { data: 'bayar', name: 'bayar', sClass:'text-center' , render:
                                    function(data){
                                             var label = "", title="";
//                                        alert(data);
                                         if         (data=='hutang'){ label="btn-red"; title="Hutang" ; } 
                                        else if(data=='lunas'){ label="btn-green"; title="Lunas";}
                                        return '<a class="btn '+label+'">'+title+'</a>';
                                    }}, 
                                    @can('admin-access')              
                                        { data: 'action', name: 'action', sClass:'text-center', orderable: false, searchable: false } 
                                    @endcan
	        ],
	        aaSorting: []
	    });
 
                $(document).on('click', '.popovers', function (e) {
                            e.preventDefault();
                            $('.popovers').popover({html: true, placement: 'left', trigger: 'manual'}).popover('show').not(this).popover('hide');
                            return false;
                        });
                         
                       $(document).on('click', '.po-close', function () {
                               $('.popovers').popover('hide');
                               return false;
                       });
        
                       $(document).on('click', '.po-delete-paket', function () {
                                var id = $(this).attr('id');
                                $('#customLoad').show();
                                $('.popovers').popover('hide');
                                $.ajax({
                                    url: '{{ url("/") }}/delete-paket/' + id,
                                    type: "GET",
                                    cache: false,
                                    data: "",
                                    success: function (response) {
                                        $('#customLoad').hide();
                                        if (response) {
                                            $('#sppsb-datatable').before('<div class="alert alert-success">'
                                                    + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                                    + '<i class="fa fa-info-circle"></i> SUKSES! Anda berhasil </div>');
                                            tablePaket.ajax.reload();
                                        } else {
                                            $('#sppsb-datatable').before('<div class="alert alert-danger">'
                                                    + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                                    + '<i class="fa fa-info-circle"></i> GAGAL! </div>');
                                        }
                                    },
                                    error: function (e) {
                                        alert("there are something wrong " + e);
                                        $('#customLoad').hide();
                                    }

                                });
                                setTimeout(function () {
                                    $('.alert-success, .alert-danger').slideUp("slow", function () {
                                        $(this).remove();
                                    });
                                }, 3000);
                            });
 
                            function formatNumber(num) {
                                  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                           }
	});
	</script>    
@endpush