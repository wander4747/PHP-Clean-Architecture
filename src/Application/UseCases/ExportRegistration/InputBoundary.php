<?php

declare(strict_types=1);

namespace App\Application\UseCases\ExportRegistration;

final class InputBoundary
{
    private string $registrationNumber;

    public function __construct(string $registrationNumber)
    {
        return $this->registrationNumber = $registrationNumber;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

}