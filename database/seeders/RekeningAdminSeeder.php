<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RekeningAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rekening_admins')->insert([
            [
                'bank_id' => 1,
                'account_name' => 'PT BosCOD Indonesia',
                'account_number' => '1234567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bank_id' => 2,
                'account_name' => 'PT BosCOD Indonesia',
                'account_number' => '0987654321',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bank_id' => 3,
                'account_name' => 'PT BosCOD Indonesia',
                'account_number' => '1122334455',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bank_id' => 4,
                'account_name' => 'PT BosCOD Indonesia',
                'account_number' => '5566778899',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bank_id' => 5,
                'account_name' => 'PT BosCOD Indonesia',
                'account_number' => '6677889900',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
