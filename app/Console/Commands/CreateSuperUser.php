<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class CreateSuperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superuser {name} {phone_number} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание пользователя с правами админа';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        {
            $name = $this->argument('name');
            $phoneNumber = $this->argument('phone_number');
            $password = bcrypt($this->argument('password'));


            try {
                User::create([
                    'name' => $name,
                    'password' => $password,
                    'phone_number' => $phoneNumber,
                    'email' => null,
                    'is_admin'=>true,
                ]);
            }catch (QueryException $e) {
                if ($e->errorInfo[1] === 1062) {
                    $this->error('User already exists with phone number!');

                }
                throw $e;
            }


            $this->info("Superuser {$name} created!");
        }
    }
}
