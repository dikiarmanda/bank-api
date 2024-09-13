<?php

namespace App\Models;

use App\Models\TransaksiTransfer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekeningAdmin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Transfer() {
        return $this->hasMany(TransaksiTransfer::class);
    }
}
