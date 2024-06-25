<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_tripay extends Controller
{
    public function getPaymentChannels(){
        
        $apiKey = 'DEV-oDLsXay8uCmkE3D2zGdizjS92igQKV4WzWQpGYQm';
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/merchant/payment-channel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ));
        
        $response = curl_exec($curl);
        $error = curl_error($curl);
        
        curl_close($curl);
        
        $response = json_decode($response)->data;
        // dd(json_decode ($response));
        return $response ? $response : $err;
    }
    
    public function requestTransaction(){
        
        $apiKey       = 'DEV-oDLsXay8uCmkE3D2zGdizjS92igQKV4WzWQpGYQm';
        $privateKey   = '0Cu1b-AyDd5-vx8o3-jPmMy-VhSFI';
        $merchantCode = 'T31814';
        $merchantRef  = 'nomor referensi merchant anda';
        
        $data = [
            'method'         => $jenisPembayaran,
            'merchant_ref'   => $merchantRef,
            'amount'         => $totalBelanja,
            'customer_name'  => 'Nama Pelanggan',
            'customer_email' => 'emailpelanggan@domain.com',
            'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'name'        => $item['nama_jenis_voucher'],
                    'price'       => $item['harga'] * $item['qty'],
                    'quantity'    => $item['qty']
                ]
                ],
                'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
                'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
            ];
        
            
            
            $curl = curl_init();
            
            curl_setopt_array($curl, [
                CURLOPT_FRESH_CONNECT  => true,
                CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/create',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
                CURLOPT_FAILONERROR    => false,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => http_build_query($data),
                CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
            ]);
            
            $response = curl_exec($curl);
            $error = curl_error($curl);
            
            curl_close($curl);
            return $response ?: $err;
        }
    }
    