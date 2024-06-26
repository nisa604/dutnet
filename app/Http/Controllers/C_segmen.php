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
        $recencyWeight = 4;
        $frequencyWeight = 3;
        $monetaryWeight = 1;

        foreach ($transactions as $transaction) {
            $customerId = $transaction->id_pelanggan;
            $recency = now()->diffInDays($transaction->waktu_transaksi);
            $quantity = $transaction->qty;
            $totalBayar = $transaction->total_bayar;

            // Menambah data ke dalam array rfmData
            if (!isset($rfmData[$customerId])) {
                $rfmData[$customerId] = [
                    'recency' => $recency * $recencyWeight,
                    'frequency' => $quantity * $frequencyWeight,
                    'monetary' => $totalBayar * $monetaryWeight,
                    'engagement' => 0, // Inisialisasi engagement
                ];
            } else {
                $rfmData[$customerId]['recency'] = min($rfmData[$customerId]['recency'], $recency * $recencyWeight);
                $rfmData[$customerId]['frequency'] += $quantity * $frequencyWeight;
                $rfmData[$customerId]['monetary'] += $totalBayar * $monetaryWeight;
            }
        }

        $engagementWeight = 2;
        // Menggabungkan data engagement
        foreach ($engagements as $engagement) {
            $customerId = $engagement->id_pelanggan;
            $jumlahTransaksi = M_riwayat::where('id_pelanggan', $customerId)->count();

            if (isset($rfmData[$customerId])) {
                $rfmData[$customerId]['engagement'] += ($engagement->engagement + $jumlahTransaksi) * $engagementWeight;
            } else {
                // $rfmData[$customerId]['engagement'] = ($engagement->engagement + $jumlahTransaksi) * $engagementWeight;
                $rfmData[$customerId] = [
                    'recency' => 0,
                    'frequency' => 0,
                    'monetary' => 0,
                    'engagement' => ($engagement->engagement + $jumlahTransaksi) * $engagementWeight,
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
            $rfmData[$customerId]['total_score'] = $total_score;
            $totalScores[$customerId] = [
                'total_score' => $total_score,
                'recency' => $recencyScore['score'],
                'frequency' => $frequencyScore['score'],
                'monetary' => $monetaryScore['score'],
                'engagement' => $engagementScore['score'],
            ];
        }

        // Bagi pelanggan menjadi 5 segmen berdasarkan skor
        $totalCustomers = count($totalScores);
        $segments = ['Very Low', 'Low', 'Medium', 'High', 'Very High'];

        $arrayDump = [];
        foreach ($totalScores as $customerId => $scores) {
            $arrayDump[$customerId] = $scores;

            $segmentasiScore = $this->calculateScore($scores['total_score'], $totalScores, 'total_score');
            $arrayDump[$customerId] = $segmentasiScore;
            $segmentasi = $segments[$segmentasiScore['score'] - 1];
            $arrayDump[$customerId] = $segmentasi;

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
        if($type === 'recency') {
            $sortedData = collect($rfmData)->sortByDesc($type)->values()->all();
        } else {
            $sortedData = collect($rfmData)->sortBy($type)->values()->all();
        }
        // Menghitung jumlah pelanggan
        $totalCustomers = count($sortedData);

        // Mendapatkan nilai minimum dan maksimum untuk tipe yang diberikan
        $minValue = $sortedData[0][$type];
        $maxValue = $sortedData[$totalCustomers - 1][$type];
        $range = $maxValue - $minValue;
        $interval = floor($range / 5);

        // Membuat rentang nilai dan skor yang sesuai
        $ranges = [];
        for ($i = 0; $i < 5; $i++) {
            if($i === 0) {
                $start = $minValue;
            } else {
                $start = $ranges[$i - 1]['end'] + 1;
            }

            if($i === 4) {
                $end = $maxValue;
            } else {
                $end = $start + $interval;
            }

            $ranges[] = [
                'start' => $start,
                'end' => $end,
                'score' => $i + 1
            ];
        }

        // Menentukan skor berdasarkan nilai
        foreach ($ranges as $range) {
            if ($value >= $range['start'] && $value <= $range['end']) {
                return [
                    'score' => $range['score'],
                    'segment' => $range['score']
                ];
            }
        }

        return [
            'score' => 1,
            'segment' => $type === 'recency' || $type === 'total_score' ? 5 : 1
        ]; // Nilai tidak ditemukan dalam rentang data
    }


}
