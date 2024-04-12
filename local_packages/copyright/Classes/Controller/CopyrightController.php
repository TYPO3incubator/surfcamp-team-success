<?php

declare(strict_types=1);

namespace Surfcamp\Copyright\Controller;

use Psr\Http\Message\ResponseInterface;
use Surfcamp\Copyright\Domain\Repository\CopyrightRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class CopyrightController extends ActionController
{
    public function imagesAction(): ResponseInterface
    {
        $copyrightRepository = GeneralUtility::makeInstance(CopyrightRepository::class);
        $site = $this->request->getAttribute('site');
        $images = $copyrightRepository->findBySite($site);
        $this->view->assign('images', $images);
//        $this->view->assign('images', [
//            [
//                'copyright' => 'Photo by <a href="https://unsplash.com/@silasbaisch?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Silas Baisch</a> on <a href="https://unsplash.com/photos/blue-and-clear-body-of-water-K785Da4A_JA?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>',
//                'usages' => [
//                    't3://page?uid=10#34',
//                    't3://page?uid=1',
//                ],
//            ],
//            [
//                'copyright' => 'foo bar baz',
//                'usages' => [
//                    't3://page?uid=10#34',
//                    't3://page?uid=1',
//                ],
//            ],
//            [
//                'copyright' => 'Sunny beach',
//                'usages' => [
//                    't3://page?uid=10#34',
//                ],
//            ],
//            [
//                'copyright' => 'Picture of myself',
//                'usages' => [
//                    't3://page?uid=10#34',
//                    't3://page?uid=1',
//                    't3://page?uid=1',
//                    't3://page?uid=1',
//                    't3://page?uid=1',
//                ],
//            ],
//        ]);
        return $this->htmlResponse();
    }
}
