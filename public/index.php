<?php

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;

require_once __DIR__ . '/../vendor/autoload.php';
$appConfig = require_once __DIR__ . '/../config/app.php';

$registration = new Registration();
$registration->setName("Wander")
    ->setEmail(new Email("wander.douglas14@gmail.com"))
    ->setBirthDate(new DateTimeImmutable('1990-09-19'))
    ->setRegistrationAt(new DateTimeImmutable())
    ->setRegistrationNumber(new Cpf('261.537.790-69'));

echo '<pre>';print_r($registration);

$loadRegistrationRepository = new stdClass();
$pdfExporter = new stdClass();
$storage = new stdClass();

$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExporter, $storage);
$inputBoundary = new InputBoundary('261.537.790-69', 'xpto', __DIR__.'/../storage');
$output = $exportRegistrationUseCase->handle($inputBoundary);