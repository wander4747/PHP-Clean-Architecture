<?php

declare(strict_types=1);

namespace App\Infra\Cli\Commands;

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Infra\Http\Controllers\Presentation;

final class ExportRegistrationCommand
{
    private ExportRegistration $useCase;

    public function __construct(ExportRegistration $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): string
    {
        $inputBoundary = new InputBoundary(
            '01234567890',
            'xpto-cli.pdf',
            __DIR__ . '/../../../../storage'
        );

        $output = $this->useCase->handle($inputBoundary);

        return $presentation->output([
            'fullFileName' => $output->getFullFileName()
        ]);
    }
}
