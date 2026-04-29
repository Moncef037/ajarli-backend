<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $first_name = $this->ask('First name');
        $last_name = $this->ask('Last name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => Hash::make($password),
            'user_type' => 'admin',
            'receive_notifications_from' => 'none',
        ]);

        $this->info('Admin user created successfully!');
    }
}
