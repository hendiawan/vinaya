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
                                        <th>Nama Coach</th> 
                                        <th>Jumlah Penjualan</th>
                                        <th>Sum Harga Pokok (Rp.)</th>
                                        <th>SumHarga Jual (Rp.)</th> 
                                        <th>SumLaba Kotor (Rp.)</th>  
                                        <th>Sum Potongan Iuran (Rp.)</th>  
                                        <th>Sum Laba Bersih (Rp.)</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                              $iuran              =0;
                                              $lababersih    =0; 
                                              $sumQtyJual    =0; 
                                              $sumHargaPokok    =0; 
                                              $sumHargaJual    =0; 
                                              $sumLabaKotor    =0;
                                              $totaliuran=0;
                                              $totalLaba=0;
                                    @endphp
                                        
                                    @foreach ($summarySales as $key => $item)
                                    <tr>
                                        @php
                                              $sumQtyJual +=$item->qty_jual;
                                              $sumHargaPokok+=$item->sum_harga_pokok;
                                              $sumHargaJual+=$item->sum_harga_jual;
                                              $sumLabaKotor+=$item->sum_laba_kotor;
                                              $totaliuran+=$item->iuran;
                                              $totalLaba+=$item->laba_bersih; 
                                        @endphp
                                        <td align="center">{{$key+1}}</td>  
                                        <td>{{$item->nama_karyawan}}</td>  
                                        <td align="right">{{$item->qty_jual}}</td>  
                                        <td align="right">{{ number_format($item->sum_harga_pokok,2,",",".") }}</td>
                                        <td align="right">{{ number_format($item->sum_harga_jual,2,",",".") }}</td>
                                        <td align="right">{{ number_format($item->sum_laba_kotor,2,",",".") }}</td>                        
                                        <td align="right">{{ number_format($item->iuran,2,",",".") }}</td>                                      
                                        <td align="right">{{ number_format($item->laba_bersih,2,",",".") }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td align="right" colspan="2"><strong>Total</strong></td> 
                                        <td align="right"><strong>{{ number_format($sumQtyJual   ,0,",",".") }}</strong></td>
                                        <td align="right"><strong>{{ number_format($sumHargaPokok   ,2,",",".") }}</strong></td>
                                        <td align="right"><strong>{{ number_format($sumHargaJual   ,2,",",".") }}</strong></td>
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