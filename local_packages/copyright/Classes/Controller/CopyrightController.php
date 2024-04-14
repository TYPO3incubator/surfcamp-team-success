<?php

declare(strict_types=1);

namespace Surfcamp\Copyright\Controller;

use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Surfcamp\Copyright\Domain\Repository\CopyrightRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CopyrightController extends ActionController
{
    public function __construct(
        protected readonly CopyrightRepository $copyrightRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function imagesAction(): ResponseInterface
    {
        $this->view->assign('images', $this->copyrightRepository->findBySite($this->request->getAttribute('site')));
        return $this->htmlResponse();
    }
}
