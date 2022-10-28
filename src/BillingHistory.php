<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

final class BillingHistory extends Model
{
    public function getBillingStatistics(UserInterface $user)
    {
        return $this->where('user_id', $user->id)
            ->groupBy('created_at')
            ->get();
    }
}