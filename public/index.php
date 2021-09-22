<?php

use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;

require_once __DIR__ . '/../vendor/autoload.php';

$registration = new Registration();
$registration->setName("Wander")
    ->setEmail(new Email("wander.douglas14@gmail.com"))
    ->setBirthDate(new DateTimeImmutable('1990-09-19'))
    ->setRegistrationAt(new DateTimeImmutable())
    ->setRegistrationNumber(new Cpf('261.537.790-69'));

echo '<pre>';print_r($registration);