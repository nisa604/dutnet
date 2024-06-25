<?php
namespace App\Http\Controllers;

use App\Models\M_riwayat;
use App\Models\M_reward;
use App\Models\M_log_durasi;
use App\Models\M_jenis_voucher;
use App\Models\M_master_reward;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class C_segmen extends Controller
{
    public function index(Request $request)
    {
       $search = $request->input('search');
        $rewards = M_reward::with('user')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->get();

        $title = 'Data Reward';
        return view('dutanet.reward.index', compact('rewards', 'title'));
    }
    
    public function calculateRFME()
    {
        // Mengambil semua data transaksi dari tabel riwayat
        $transactions = M_riwayat::all();
        $engagements = M_log_durasi::all();

        // Menghitung Recency, Frequency, Monetary, dan Engagement untuk setiap pelanggan
        $rfmData = [];
        foreach ($transactions as $transaction) {
            $customerId = $transaction->id_pelanggan;
            $recency = now()->diffInDays($transaction->waktu_transaksi);
            $quantity = $transaction->qty;
            $totalBayar = $transaction->total_bayar;         

            // Menambah data ke dalam array rfmData
            if (!isset($rfmData[$customerId])) {
                $rfmData[$customerId] = [
                    'recency' => $recency,
                    'frequency' => $quantity,
                    'monetary' => $totalBayar,
                    'engagement' => 0, // Inisialisasi engagement
                ];
            } else {
                $rfmData[$customerId]['recency'] = min($rfmData[$customerId]['recency'], $recency);
                $rfmData[$customerId]['frequency'] += $quantity;
                $rfmData[$customerId]['monetary'] += $totalBayar;
            }
        }

        // Menggabungkan data engagement
        foreach ($engagements as $engagement) {
            $customerId = $engagement->id_pelanggan;
            $jumlahTransaksi = M_riwayat::where('id_pelanggan', $customerId)->count();

            if (isset($rfmData[$customerId])) {
                $rfmData[$customerId]['engagement'] = $engagement->engagement += $jumlahTransaksi;
            } else {
                $rfmData[$customerId] = [
                    'recency' => 0,
                    'frequency' => 0,
                    'monetary' => 0,
                    'engagement' => $engagement->engagement + $jumlahTransaksi,
                ];
            }
        }   

        // Hitung skor total dan simpan skor total ke array baru
        $totalScores = [];
        foreach ($rfmData as $customerId => $rfm) {
            $recencyScore = $this->calculateScore($rfm['recency'], $rfmData, 'recency');
            $frequencyScore = $this->calculateScore($rfm['frequency'], $rfmData, 'frequency');
            $monetaryScore = $this->calculateScore($rfm['monetary'], $rfmData, 'monetary');
            $engagementScore = $this->calculateScore($rfm['engagement'], $rfmData, 'engagement');

            $total_score = $recencyScore['score'] + $frequencyScore['score'] + $monetaryScore['score'] + $engagementScore['score'];

            $totalScores[$customerId] = [
                'total_score' => $total_score,
                'recency' => $recencyScore['score'],
                'frequency' => $frequencyScore['score'],
                'monetary' => $monetaryScore['score'],
                'engagement' => $engagementScore['score'],
            ];
        }

        // Urutkan pelanggan berdasarkan skor total
        uasort($totalScores, function ($a, $b) {
            return $b['total_score'] <=> $a['total_score'];
        });

        // Bagi pelanggan menjadi 5 segmen (20% teratas ke Very High, dst.)
        $totalCustomers = count($totalScores);
        $segmentSize = ceil($totalCustomers / 5);
        $segments = ['Very High', 'High', 'Medium', 'Low', 'Very Low']; // Segmen asli

        $currentSegmentIndex = 0;
        $currentSegmentCount = 0;
        foreach ($totalScores as $customerId => $scores) {
            if ($currentSegmentCount >= $segmentSize && $currentSegmentIndex < 4) {
                $currentSegmentIndex++;
                $currentSegmentCount = 0;
            } elseif ($currentSegmentIndex == 4 && $currentSegmentCount >= $segmentSize) {
                $currentSegmentIndex = 0; // Mulai dari Very Low lagi setelah Very High
                $currentSegmentCount = 0;
            }

            $segmentasi = $segments[$currentSegmentIndex];

            // Ambil reward dari tabel master_reward berdasarkan segmen
            $masterReward = M_master_reward::where('segmen', $segmentasi)->first();
            $reward = $masterReward ? $masterReward->reward : 0;

            $existingReward = M_reward::where('id_pelanggan', $customerId)->first();
            if ($existingReward) {
                // Jika data sudah ada, update data yang ada
                $existingReward->update([
                    'recency' => $scores['recency'],
                    'frequency' => $scores['frequency'],
                    'monetary' => $scores['monetary'],
                    'engagement' => $scores['engagement'],
                    'total_score' => $scores['total_score'],
                    'segmentasi' => $segmentasi,
                    'reward' => $reward, // Atur nilai reward sesuai kebutuhan Anda
                ]);
            } else {
                // Jika data belum ada, buat data baru
                M_reward::create([
                    'id_pelanggan' => $customerId,
                    'recency' => $scores['recency'],
                    'frequency' => $scores['frequency'],
                    'monetary' => $scores['monetary'],
                    'engagement' => $scores['engagement'],
                    'total_score' => $scores['total_score'],
                    'segmentasi' => $segmentasi,
                    'reward' => $reward, // Atur nilai reward sesuai kebutuhan Anda
                ]);
            }

            $currentSegmentCount++;
        }
    }

    public function getMostPurchasedVouchers() {
        $purchases = DB::table('detail_pembelian_voucher') 
        ->select('id_pelanggan', 'nama_jenis_voucher', DB::raw('SUM(qty) as total_qty'))
        ->groupBy('id_pelanggan', 'nama_jenis_voucher')
        ->get();
        
        $mostPurchasedVouchers = [];
        
        foreach ($purchases as $purchase) {
            $customerId = $purchase->id_pelanggan;
            $voucherName = $purchase->nama_jenis_voucher;
            $totalQty = $purchase->total_qty;
            
            if (!isset($mostPurchasedVouchers[$customerId])) {
                $mostPurchasedVouchers[$customerId] = [
                    'nama_jenis_voucher' => $voucherName,
                    'total_qty' => $totalQty
                ];
            } else {
                if ($mostPurchasedVouchers[$customerId]['total_qty'] < $totalQty) {
                    $mostPurchasedVouchers[$customerId] = [
                        'nama_jenis_voucher' => $voucherName,
                        'total_qty' => $totalQty
                    ];
                }
            }
        }
        // return response()->json($mostPurchasedVouchers);
        return $mostPurchasedVouchers;
    }

    private function calculateScore($value, $rfmData, $type)
    {
        // Mengurutkan data berdasarkan nilai $type (recency, frequency, monetary, engagement)
        $sortedData = collect($rfmData)->sortByDesc($type)->values()->all();
        // Menghitung jumlah pelanggan
        $totalCustomers = count($sortedData);

        // Membagi pelanggan ke dalam 5 segmen dengan distribusi yang sesuai
        $segments = [];
        for ($i = 0; $i < 5; $i++) {
            $segments[$i] = [];
        }

        $segmentSize = floor($totalCustomers / 5);
        $remainder = $totalCustomers % 5;

        $currentIndex = 0;
        for ($i = 0; $i < 5; $i++) {
            $extra = $i < $remainder ? 1 : 0;
            $size = $segmentSize + $extra;
            $segments[$i] = array_slice($sortedData, $currentIndex, $size);
            $currentIndex += $size;
        }

        // Menghitung skor berdasarkan indeks dengan menghindari nilai yang sama
        foreach ($segments as $index => $segment) {
            foreach ($segment as $subIndex => $item) {
                if ($item[$type] === $value) {
                    if ($type == 'recency') {
                        // Recency: nilai yang lebih kecil mendapatkan skor lebih tinggi
                        return [
                            'score' => 5 - $index - ($subIndex / count($segment)),
                            'segment' => $index + 1
                        ];
                    } else {
                        // Frequency, monetary, engagement: nilai yang lebih besar mendapatkan skor lebih tinggi
                        return [
                            'score' => $index + 1 + ($subIndex / count($segment)),
                            'segment' => $index + 1
                        ];
                    }
                }
            }
        }

        return null; // Nilai tidak ditemukan dalam data
    }
}
