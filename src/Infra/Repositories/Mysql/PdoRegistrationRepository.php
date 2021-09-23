<?php

declare(strict_types=1);

namespace App\Infra\Repositories\Mysql;

use App\Domain\Entities\Registration;
use App\Domain\Repositories\Cpf;
use App\Domain\Repositories\LoadRegistrationRepository;
use PDO;

final class PdoRegistrationRepository implements LoadRegistrationRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function loadByRegistrationNumber(Cpf $cpf): Registration
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM `registrations` WHERE registration_number = :cpf"
        );

        $statement->execute([':cpf' => (string)$cpf]);
        $record = $statement->fetch();

        if (!$record) {

        }

        $registration = new Registration();
        $registration->setName($record['name'])
            ->setBirthDate(new DateTimeImmutable($record['birth_date']))
            ->setEmail(new Email($record['email']))
            ->setRegistrationAt(new DateTimeImmutable($record['created_at']))
            ->setRegistrationNumber(new Cpf($record['registration_number']));

        return $registration;
    }
}