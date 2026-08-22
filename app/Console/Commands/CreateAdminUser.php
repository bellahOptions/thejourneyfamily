<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

#[Signature('admin:create {--name=} {--email=} {--password=}')]
#[Description('Create or promote a user to admin so they can log in to the admin dashboard')]
class CreateAdminUser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->option('name') ?: text('Admin name', required: true);
        $email = $this->option('email') ?: text('Admin email', required: true);
        $password = $this->option('password') ?: password('Admin password', required: true);

        $validator = Validator::make(
            ['name' => $name, 'email' => $email, 'password' => $password],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'is_admin' => true,
            ]
        );

        $this->info("Admin user ready: {$user->email}");

        return self::SUCCESS;
    }
}
