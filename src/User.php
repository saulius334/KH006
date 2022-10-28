<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This class is example of dirty code
 */
class User extends Model
{
    private $easyTokenReminderGenerator;

    public $email;

    public function login($email, $password) {
        $user = $this
            ->where('email', $email)
            ->get()
            ->first();

        return password_verify($password, $user->password);
    }

    public function register($email, $password) {
        // some validation
        self::create([
            'email' => $email,
            'password' => password_hash($password, 'empty'),
        ]);
    }

    public function restorePassword($email) {
        // validation
        $token = $this->createPasswordToken($email);
        self::update([
            'reset_token' => $token,
        ]);

        $this->email->send(
            $email, 'Password restore', 'views/auth/restorePassword', ['token' => $token]
        );
    }

    public function getAddressString() {
        $address  = [
            $this->p->city,
            $this->p->street,
            $this->p->house,
            $this->p->apartment,
        ];

        return implode(" ", $address);
    }

    public function getFullName() {
        return $this->p->second_name . ' ' . $this->p->first_name;
    }

    public function addBalance($sum) {
        return $this->getBalance()->addSum($sum);
    }

    public function getBalance() {
        return $this->getBalance()->sum;
    }


    public function getBillingStatistics() {
        return BillingHistory::where('user_id', $this->id)
            ->groupBy('created_at')
            ->get();
    }

    public function getPaymentsStatistics() {
        return Payments::where('user_id', $this->id)
            ->groupBy('created_at')
            ->get();
    }

    private $p;

    private function createPasswordToken($email)
    {
        return md5($email);
    }

    private function checkIfEMailIsWalid() {
        return '';
    }
}