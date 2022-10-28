<?php

declare(strict_types=1);

namespace App;

use App\User;
use PharIo\Manifest\InvalidEmailException;

final class LoginRegister
{
    private $easyTokenReminderGenerator; // not sure whats this for
    public function login(string $email, string $password): bool
    {
        $user = User::where('email', $email)
            ->get()
            ->first();

        return password_verify($password, $user->password);
    }
    public function register(string $email, string $password, array $personalInfo): void
    {
        if ($this->checkIfEMailIsValid($email)) {

        User::create([
            'email' => $email,
            'password' => password_hash($password, 'empty'),
            'personalInfo' => $personalInfo
        ]);
        return;
        } else {
            throw new InvalidEmailException($email);
        }

    }
    public function restorePassword(string $email): void
    {
        if ($this->checkIfEMailIsValid($email)) {
            $token = $this->createPasswordToken($email);
            self::update([
                'reset_token' => $token,
            ]);
    
            $this->email->send(
                $email,
                'Password restore',
                'views/auth/restorePassword',
                ['token' => $token]
            );
            return;
        } else {
            throw new InvalidEmailException($email);
        }

    }
    private function createPasswordToken(string $email): string
    {
        return md5($email);
    }

    private function checkIfEMailIsValid(): bool
    {
        //validation
        return true;
    }
}