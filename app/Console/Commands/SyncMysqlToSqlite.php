<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncMysqlToSqlite extends Command
{
    protected $signature = 'sync:mysql-to-sqlite';
    protected $description = 'Sync data from MySQL to SQLite';

    public function handle()
    {
        $this->info('Starting sync...');

        // contoh tabel users
        $users = DB::connection('mysql')->table('users')->get();

        foreach ($users as $user) {
            DB::connection('sqlite_sync')->table('users')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }

        $this->info('Sync completed!');
    }
}