<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan Rekap Detail</title>
        <style type="text/css">
            body{
                font-family: 'Dejavu Sans';
                font-size: 12px;
            }
            .widget-content.pad20f {
                padding: 0 20px 20px;
            }
            h3{
                font-size: 18px;
                line-height: 20px;
                margin-bottom: 40px
            }
            p{
                margin: 0;
                padding: 0;
                text-align: justify;
            }
            table.data thead tr{
                background: #efefef;
                padding: 4px 0;
            }
            table.data tr td{
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper" class="container">
            <div id="main" class="form-horizontal clearfix">
                <div class="widget-content pad20f">
                    <div class="form-group">
                        <h3 align="center"><strong>LAPORAN PENERIMAAN COACH</strong></h3>
                        <h4 align="center"><strong>Periode {{$tglMulai}} S/D {{$tglSelesai}} </strong></h4>
                    </div>
                    <table cellspacing="0" width="100%">
                        <tr>
                            <td width="10%">Nama Coach</td>
                            <td>: {{$namaCoach}} </td>
                        </tr> 
                    </table>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <table class="data" cellspacing="0" cellpadding="2" width="100%" border="1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Coach</th> 
                                        <th>Nama Member</th>
                                        <th>Jenis Paket</th> 
                                        <th>Jumlah </th>  
                                    </tr>
                                </thead>
                                <tbody>
                                
                                     @foreach ($hutang as $key => $item)
                                    <tr>    
                                        <td align="center">{{$key+1}}</td> 
                                        <td align="center">{{Carbon\Carbon::parse($item->tgl_bayar)->format('d/m/Y')}}</td>
                                        <td>{{$item->paket->pelanggan->sales->karyawan->nama_karyawan}}</td>  
                                        <td>{{$item->paket->pelanggan->nama_pelanggan}}</td>  
                                        <td>{{$item->paket->menu->nama_menu}}</td>  
                                        <td align="right">{{number_format($item->kredit,0,',','.')}}</td>   
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" align="center"><strong>Total</strong></td> 
                                        <td align="right">{{number_format($sumKredit,0,',','.')}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>