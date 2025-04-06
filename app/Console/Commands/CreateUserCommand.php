<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');

        // Si no se proporcionaron los datos, solicitar al usuario
        if (!$name) {
            $name = $this->ask('What is the user name?');
        }

        if (!$email) {
            $email = $this->ask('What is the user email?');
        }

        if (!$password) {
            $password = $this->secret('What is the user password?');
        }

        // Validar que el email no exista
        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists.');
            return 1;
        }

        // Crear el usuario
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('User created successfully!');
        $this->table(
            ['ID', 'Name', 'Email'],
            [[$user->id, $user->name, $user->email]]
        );

        return 0;
    }
}
