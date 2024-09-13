<?php

namespace App\Models;

use App\Models\TransaksiTransfer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transferFrom() {
        return $this->hasMany(TransaksiTransfer::class, 'from_bank_id');
    }

    public function transferTo() {
        return $this->hasMany(TransaksiTransfer::class, 'to_bank_id');
    }
}
