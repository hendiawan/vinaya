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
                        <h3 align="center"><strong>LAPORAN PENJUALAN COACH</strong></h3>
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
                                        <th>Level Coach</th>
                                        <th>Nama Member</th>
                                        <th>Jenis Paket</th> 
                                        <th>Jumlah </th>
                                        <th>Harga Pokok (Rp.)</th>
                                        <th>Harga Jual (Rp.)</th>
                                        <th>Iuran Coach (%)</th>
                                        <th>Laba Kotor (Rp.)</th>  
                                        <th>Potongan Iuran (Rp.)</th>  
                                        <th>Laba Bersih (Rp.)</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $totaliuran =0;
                                        $totalLaba  =0;
                                    @endphp
                                        
                                     @foreach ($coach as $key => $item)
                                    <tr>
                                        @php
                                              $iuran              =($item->harga_pokok*$item->qty_jual)*$item->iuran/100;
                                              $lababersih   =$item->laba_kotor*$item->qty_jual-$iuran; 
                                              $totaliuran+=$iuran;
                                              $totalLaba+=$lababersih; 
                                        @endphp
                                        <td align="center">{{$key+1}}</td> 
                                        <td align="center">{{Carbon\Carbon::parse($item->tgl_jual)->format('d/m/Y')}}</td>
                                        <td>{{$item->sales->karyawan->nama_karyawan}}</td> 
                                        <td>{{$item->sales->level->level}}</td> 
                                        <td>
                                             @if($item->pelanggan->nama_pelanggan!='UMUM')
                                                {{$item->pelanggan->nama_pelanggan}}
                                             @else
                                               {{$item->non_member}}
                                             @endif
                                        </td>  
                                        <td>{{$item->paket->menu->nama_menu}}</td>  
                                        <td align="right">{{$item->qty_jual}}</td>  
                                        <td align="right">{{ number_format($item->harga_pokok*$item->qty_jual,2,",",".") }}</td>
                                        <td align="right">{{ number_format($item->harga_jual*$item->qty_jual,2,",",".") }}</td>
                                        <td align="right">{{ number_format($item->iuran,0,",",".") }}</td>
                                        <td align="right">{{ number_format($item->laba_kotor*$item->qty_jual,2,",",".") }}</td>                                   
                                        <td align="right">{{ number_format($iuran,2,",",".") }}</td>                                      
                                        <td align="right">{{ number_format($lababersih,2,",",".") }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" align="right"><strong>Total</strong></td> 
                                        <td align="right"><strong>{{ number_format($sumQtyJual   ,0,",",".") }}</strong></td>
                                        <td align="right"><strong>{{ number_format($sumHargaPokok   ,2,",",".") }}</strong></td>
                                        <td align="right"><strong>{{ number_format($sumHargaJual   ,2,",",".") }}</strong></td>
                                        <td align="right"><strong></strong></td>
                                        <td align="right"><strong>{{ number_format($sumLabaKotor ,2,",",".") }}</strong></td>  
                                        <td align="right"><strong>{{ number_format($totaliuran ,2,",",".") }}</strong></td>  
                                        <td align="right"><strong>{{ number_format($totalLaba ,2,",",".") }}</strong></td>  
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