<?php

declare(strict_types=1);

namespace App;

use App\UserInterface;
use Illuminate\Database\Eloquent\Model;

final class User extends Model implements UserInterface
{
    protected $fillable = ['personalInfo'];

    public function getAddressString(): string
    {
        $address  = [
            $this->personalInfo->city,
            $this->personalInfo->street,
            $this->personalInfo->house,
            $this->personalInfo->apartment,
        ];

        return implode(" ", $address);
    }

    public function getFullName(): string
    {
        return $this->personalInfo->second_name . ' ' . $this->personalInfo->first_name;
    }
    public function getId() {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }
}
