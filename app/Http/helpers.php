<?php

use Carbon\Carbon;
use App\RateSppsb;


function hitungHariLahir($tglLahir){
    $tgl_lahir        = date('d', strtotime($tglLahir));
    $bulan_lahir  = date('m', strtotime($tglLahir));
    $tahun            = date('Y');   
    $tglUltah       = date('Y-m-d', strtotime($tahun.'-'.$bulan_lahir.'-'.$tgl_lahir));

    $hariIndo = hari_indo($tglUltah).', '.tgl_indo($tglUltah);

     $tanggalSekarang       = new DateTime();  
     $ultahSekarang           = new DateTime($tglUltah); 
     $perbedaan                  = $tanggalSekarang->diff($ultahSekarang);  
     
     if ($tanggalSekarang>$ultahSekarang){
           return $hariIndo.' Ultah sudah lewat !!!';
     }else{
         if($perbedaan->m<1){
              return $hariIndo.' Tepatnya '.$perbedaan->d   ." Hari Lagi ";
         }else{
              return $hariIndo.' Tepatnya '. $perbedaan->m .' Bulan '. $perbedaan->d   ." Hari Lagi ";
         }
         
     }
//      return $hariIndo.' Tepatnya '. $perbedaan->d   ." Hari Lagi ";
}

function hitungUmurs($tglLahir){
        $tanggallahir    = new DateTime($tglLahir);  
        $sekarang = new DateTime(); 
        $perbedaan = $tanggallahir->diff($sekarang);  
        return $perbedaan->y .' Tahun '. $perbedaan->m . ' Bulan '.$perbedaan->d .' Hari';
}

function hari_indo($tgl){
	$hari = date ("D", strtotime($tgl));
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return  $hari_ini ;
 
}

function tgl_indo($tanggal)
{
    $bulan = array (1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

function terbilang($x)
{
    
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return terbilang($x / 10) . " puluh" . terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . terbilang($x - 100);
  elseif ($x < 1000)
    return terbilang($x / 100) . " ratus" . terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . terbilang($x - 1000);
  elseif ($x < 1000000)
    return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000)
    return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
  elseif ($x < 1000000000000)
    return terbilang($x / 1000000000) . " milyar" . terbilang(fmod($x,1000000000));
 
}
 
function enkripsi( $string )
{
    $output = false;
 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bismillahirrahmanirrahim';
    $secret_iv = 'bismillahirrahmanirrahim';
 
    // hash
    $key = hash('sha256', $secret_key);
     
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
 
    return $output;
}
 
function dekripsi($string)
{
    $output = false;
 
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bismillahirrahmanirrahim';
    $secret_iv = 'bismillahirrahmanirrahim';
 
    // hash
    $key = hash('sha256', $secret_key);
     
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
 
    return $output;
}

     function saveFile($file)
    {
        
//        $fileName = str_random(8).date('ymdHis') . '-' . $file->getClientOriginalName();
        $fileName = date('ymdHis') . '-' . $file->getClientOriginalName();
        // You can change this to anything you want.
        $destinationPath = 'uploads/' . Carbon::now()->year . '/' . Carbon::now()->month;
     
        // Check to see if the "destinationPath" exists if it doesn't create it.
        if (!is_dir($destinationPath))
        {
            mkdir($destinationPath, 0777, true);
        }
        //$destinationPath = public_path() . DIRECTORY_SEPARATOR . 'uploads';
        $file->move($destinationPath, $fileName);
        
        return 'uploads/' . Carbon::now()->year . '/' . Carbon::now()->month.'/'.$fileName;
        
    }
