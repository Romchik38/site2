<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\ServerError;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use RuntimeException;

/** Tries to show nice answer */
final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{

    const DEFAULT_VIEW_NAME = 'Server Error';
    const DEFAULT_VIEW_DESCRIPTION = 'Server error page. Please try again later';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
        protected readonly string $outputFile = ''
    ) {}

    public function execute(): string
    {
        /** try to show dynamic view */
        try {
            $dto = $this->defaultViewDTOFactory->create(
                $this::DEFAULT_VIEW_NAME,
                $this::DEFAULT_VIEW_DESCRIPTION
            );
            $result = $this->view
                ->setController($this->getController())
                ->setControllerData($dto)
                ->toString();
            return $result;
        } catch (\Exception $e) {
            /** show static output  */
            if (strlen($this->outputFile) !== 0) {
                return $this->getOutput();
            }
            /** nothing to show, forward the error */
            throw new \RuntimeException($e->getMessage());
        }
    }

    /** 
     * @throws \RuntimeException Problem to read the file
     * @return string content of the server error file
     */
    protected function getOutput(): string
    {
        if (file_exists($this->outputFile) === false) {
            throw new \RuntimeException(
                sprintf(
                    'Output file %s to show nice server error response not exist',
                    $this->outputFile
                )
            );
        }
        $fp = fopen($this->outputFile, 'r');
        if ($fp === false) {
            throw new \RuntimeException(
                sprintf(
                    'Can\'t open to read output file %s to show nice server error response',
                    $this->outputFile
                )
            );
        }
        $file = '';
        $chank = fread($fp, 1024);
        while ($chank !== false && $chank !== '') {
            if ($chank !== false) {
                $file .= $chank;
            }
            $chank = fread($fp, 1024);
        }
        fclose($fp);
        if (strlen(trim($file)) === 0) {
            throw new \RuntimeException(
                sprintf(
                    'Output file %s to show nice server error response is empty',
                    $this->outputFile
                )
            );
        }
        return $file;
    }
}
