<?php

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Repositories\Mysql\PdoRegistrationRepository;

require_once __DIR__ . '/../vendor/autoload.php';
$appConfig = require_once __DIR__ . '/../config/app.php';

$registration = new Registration();
$registration->setName("Wander")
    ->setEmail(new Email("wander.douglas14@gmail.com"))
    ->setBirthDate(new DateTimeImmutable('1990-09-19'))
    ->setRegistrationAt(new DateTimeImmutable())
    ->setRegistrationNumber(new Cpf('261.537.790-69'));

echo '<pre>';print_r($registration);

//$loadRegistrationRepository = new PdoRegistrationRepository();
$pdfExporter = new Html2PdfAdapter();
$storage = new LocalStorageAdapter();

$content =  $pdfExporter->generate($registration);
$storage->store("test.pdf", __DIR__.'/../storage/registrations', $content);
die();
$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExporter, $storage);
$inputBoundary = new InputBoundary('261.537.790-69', 'xpto', __DIR__.'/../storage');
$output = $exportRegistrationUseCase->handle($inputBoundary);