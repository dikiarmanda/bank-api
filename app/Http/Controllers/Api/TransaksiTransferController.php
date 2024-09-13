<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Bank;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RekeningAdmin;
use App\Models\TransaksiTransfer;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TransaksiTransferController extends Controller
{
    public function createTransfer(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nilai_transfer' => 'required|numeric|min:1000',
            'bank_tujuan' => 'required|string',
            'rekening_tujuan' => 'required|string',
            'atasnama_tujuan' => 'required|string',
            'bank_pengirim' => 'required|string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'messages' => $validator->errors()], 422);
        }

        // Dapatkan nilai transfer dari request
        $nilai_transfer = $request->nilai_transfer;

        // Generate kode unik (3 digit angka acak)
        $kode_unik = mt_rand(100, 999);

        // Buat id transaksi unik dengan format TF{YYMMDD}{counter 5 digit}
        $date = Carbon::now()->format('ymd');
        $counter = Str::padLeft(TransaksiTransfer::count() + 1, 5, '0'); // Atau gunakan auto increment atau logika lain
        $id_transaksi = "TF{$date}{$counter}";

        // Hitung total transfer
        $total_transfer = $nilai_transfer + $kode_unik;

        // Cari bank perantara dari rekening admin (misalnya dari tabel rekening_admin)
        $bank_perantara = $request->bank_pengirim; // Di sini diasumsikan sama dengan bank pengirim
        $bank = Bank::where('code', $bank_perantara)->first();
        $rekening_perantara = RekeningAdmin::where('bank_id', $bank->id)->first()->rekening ?? '1234567890';

        // Simpan transaksi ke database
        $user = JWTAuth::parseToken()->authenticate();
        $bank_pengirim = Bank::where('code', $request->bank_pengirim)->first();
        $bank_tujuan = Bank::where('code', $request->bank_tujuan)->first();
        $transaksi = TransaksiTransfer::create([
            'user_id' => $user->id,
            'from_bank_id' => $bank_pengirim->id,
            'to_bank_id' => $bank_tujuan->id,
            'admin_rekening_id' => RekeningAdmin::where('bank_id', $bank_pengirim->id)->first()->id,
            'transaction_id' => $id_transaksi,
            'amount' => $nilai_transfer,
            'unique_code' => str_pad($kode_unik, 3, '0', STR_PAD_LEFT),
        ]);

        // Tanggal kadaluarsa transfer (misalnya 2 hari dari sekarang)
        $berlaku_hingga = Carbon::now()->addDays(2)->toIso8601String();

        // Return response JSON
        return response()->json([
            'id_transaksi' => $id_transaksi,
            'nilai_transfer' => $nilai_transfer,
            'kode_unik' => $kode_unik,
            'biaya_admin' => 0,
            'total_transfer' => $total_transfer,
            'bank_perantara' => $bank_perantara,
            'rekening_perantara' => $rekening_perantara,
            'berlaku_hingga' => $berlaku_hingga,
        ], 201);
    }
}
