<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Author\AdminList\AdminAuthorList;
use Romchik38\Site2\Application\Author\AdminList\Filter;
use Romchik38\Site2\Application\Author\AuthorService\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const acceptHeader = ['text/html', 'application/json'];

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminAuthorList $adminAuthorList,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $responseType = $this->serializeAcceptHeader(
            $this::acceptHeader,
            $request->getHeaderLine('Accept')
        );

        try {
            $requestData = $request->getQueryParams();
            $command     = Filter::fromRequest($requestData);

            $filterResult   = $this->adminAuthorList->list($command);
            $searchCriteria = $filterResult->searchCriteria;
            $authorList     = $filterResult->list;
            $page           = $filterResult->page;
            $totalCount     = $this->adminAuthorList->totalCount();
        } catch (\Exception $e) {
            /** @todo test */
            if ($responseType === 'application/json') {
                return new JsonResponse(['error' => 'some error here']);    
            } elseif ($responseType === null) {
                return new TextResponse('Error, try later');
            } else {
                throw $e;
            }
        }

        /** @todo test */
        if ($responseType === null) {
            return new TextResponse('Author admin list page');
        }

        if ($responseType === 'application/json') {
            return new JsonResponse(['hello' => 'world']);
        }

        // HTML
        $path              = new Path($this->getPath());
        $urlGenerator      = new UrlGeneratorUseUrlBuilder($path, $this->urlbuilder);
        $additionalQueries = [
            new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
            new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
        ];
        $paginationView    = new CreatePagination(
            $urlGenerator,
            count($authorList),
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            $additionalQueries
        );

        $paginationHtml = $paginationView->create();

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            'Authors',
            'Authors page',
            $authorList,
            $paginationHtml,
            new PaginationForm(
                $searchCriteria->limit,
                $searchCriteria->orderByField,
                $searchCriteria->orderByDirection
            ),
            Delete::ID_FIELD,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Authors page';
    }

    /** 
     * @todo move to trait 
     * 
     * @param array<int,string> $expectedHeaders - Example ['text/html', 'application/json']
     * */
    private function serializeAcceptHeader(
        array $expectedHeaders, 
        string $headerLine,
        string $all = 'text/html'
    ): ?string
    {
        if ($headerLine === '') {
            return null;
        }

        $preferedType = '';
        $preferedValue = 0;
        $values = explode(',', $headerLine);
        foreach ($values as $value) {
            $parts = explode(';', $value);
            $type = $parts[0];
            if ($type === '*/*') {
                $type = $all;
            }
            $cost = (float) ($parts[1] ?? 1);
            $serializedType = array_search($type, $expectedHeaders);
            if ($serializedType === false) {
                continue;
            } else {
                if ($cost > $preferedValue) {
                    $preferedType = $type;
                }
            }
        }
        if ($preferedType !== '') {
            return $preferedType;
        } else {
            return null;
        }
    }
}
