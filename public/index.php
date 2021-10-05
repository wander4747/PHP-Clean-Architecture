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

// usecases
$sqlite = "sqlite:../database.db";
$pdo = new PDO($sqlite);
$pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$loadRegistrationRepository = new PdoRegistrationRepository($pdo);
$pdfExporter = new Html2PdfAdapter();
$storage = new LocalStorageAdapter();

$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExporter, $storage);
$inputBoundary = new InputBoundary('01234567890', 'xpto.pdf', __DIR__.'/../storage');
$output = $exportRegistrationUseCase->handle($inputBoundary);