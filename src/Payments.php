<?php

declare(strict_types=1);

namespace App;

use App\UserInterface;
use Illuminate\Database\Eloquent\Model;

final class Payments extends Model
{
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getBalance(): int
    {
        return $this->user->balance;
    }

    public function setBalance(): void
    {
        $this->balance = $this->user->balance;
    }

    public function getPaymentsStatistics()
    {
        return $this->where('user_id', $this->user->id)
            ->groupBy('created_at')
            ->get();
    }
    
    public function addToBalance(int $sum): int
    {
        return $this->user->getBalance()->addSum($sum);
    }
}