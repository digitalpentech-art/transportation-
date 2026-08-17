<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (\App\Models\User::where('email', $email)->exists()) {
            $this->error('User with this email already exists.');
            return 1;
        }

        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info("Admin user created successfully with email: {$email}");
        return 0;
    }
}
