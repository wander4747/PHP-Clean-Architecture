<?php

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Http\Controllers\ExportRegistrationController;
use App\Infra\Repositories\Mysql\PdoRegistrationRepository;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

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

$request = new Request('GET', 'http://localhost:8888');
$response = new Response();

$exportRegistrationController = new ExportRegistrationController(
    $request,
    $response,
    $exportRegistrationUseCase
);

$exportRegistrationController->handle();
