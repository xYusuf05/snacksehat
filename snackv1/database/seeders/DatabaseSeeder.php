<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Buat akun Admin ───────────────────────────────────────────────────
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@snackcheck.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Buat akun User biasa ──────────────────────────────────────────────
        User::create([
            'name'     => 'User Demo',
            'email'    => 'user@snackcheck.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $this->command->info('✅ Akun admin & user demo dibuat.');
        $this->command->info('   Admin : admin@snackcheck.com / password');
        $this->command->info('   User  : user@snackcheck.com  / password');

        // ── Seed data snack ───────────────────────────────────────────────────
        $this->call(SnackSeeder::class);
    }
}