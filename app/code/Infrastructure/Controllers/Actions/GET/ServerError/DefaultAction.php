<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError;

use Exception;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use RuntimeException;

use function fclose;
use function file_exists;
use function fopen;
use function fread;
use function sprintf;
use function strlen;
use function trim;

/** Tries to show nice answer */
final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const DEFAULT_VIEW_NAME_KEY        = 'server-error.header';
    public const DEFAULT_VIEW_DESCRIPTION_KEY = 'server-error.description';

    public function __construct(
        protected DynamicRootInterface $dynamicRootService,
        protected TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDtoFactory,
        protected readonly string $outputFile = ''
    ) {
    }

    public function execute(): ResponseInterface
    {
        /** try to show dynamic view */
        try {
            $dto    = $this->defaultViewDtoFactory->create(
                $this->translateService->t($this::DEFAULT_VIEW_NAME_KEY),
                $this->translateService->t($this::DEFAULT_VIEW_DESCRIPTION_KEY)
            );
            $result = $this->view
                ->setController($this->getController())
                ->setControllerData($dto)
                ->toString();
            return new HtmlResponse($result);
        } catch (Exception $e) {
            /** show static output  */
            if (strlen($this->outputFile) !== 0) {
                return new HtmlResponse($this->getOutput());
            }
            /** nothing to show, forward the error */
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @throws RuntimeException - Problem to read the file.
     * @return string content of the server error file
     */
    protected function getOutput(): string
    {
        if (file_exists($this->outputFile) === false) {
            throw new RuntimeException(
                sprintf(
                    'Output file not exist %s to show nice server error response',
                    $this->outputFile
                )
            );
        }
        $fp = fopen($this->outputFile, 'r');
        if ($fp === false) {
            throw new RuntimeException(
                sprintf(
                    'Can\'t open to read output file %s to show nice server error response',
                    $this->outputFile
                )
            );
        }
        $file = '';

        $chank = fread($fp, 1024);
        if ($chank === false) {
            fclose($fp);
            throw new RuntimeException(
                sprintf('Cannot read file %s', $this->outputFile)
            );
        }
        while ($chank !== '') {
            $file .= $chank;
            $chank = fread($fp, 1024);
            if ($chank === false) {
                fclose($fp);
                throw new RuntimeException(
                    sprintf('Cannot close file %s', $this->outputFile)
                );
            }
        }

        fclose($fp);
        if (strlen(trim($file)) === 0) {
            throw new RuntimeException(
                sprintf(
                    'Output file is empty %s to show nice server error response',
                    $this->outputFile
                )
            );
        }
        return $file;
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME_KEY);
    }
}
