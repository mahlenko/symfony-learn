<?php

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Service\UlidService;
use DateTimeImmutable;

class User
{
    private string $ulid;
    private string $email;
    private string $password;
    private DateTimeImmutable $created_at;

    public function __construct(string $email, string $password) {
        $this->ulid = UlidService::generate();
        $this->email = $email;
        $this->password = $password;
        $this->created_at = new DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function getUlid(): string {
        return $this->ulid;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable {
        return $this->created_at;
    }
}