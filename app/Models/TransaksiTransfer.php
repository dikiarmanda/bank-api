<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\User;
use App\Models\RekeningAdmin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiTransfer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function fromBank() {
        return $this->belongsTo(Bank::class, 'from_bank_id');
    }

    public function toBank() {
        return $this->belongsTo(Bank::class, 'to_bank_id');
    }

    public function adminRekening() {
        return $this->belongsTo(RekeningAdmin::class);
    }

}
