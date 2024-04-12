<?php

declare(strict_types=1);

namespace Surfcamp\Copyright\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CopyrightRepository extends Repository
{

    public function findBySite(Site $site): array
    {
        // first fetch all pages in a specific site
        $pageRepository = GeneralUtility::makeInstance(PageRepository::class);
        $pageIds = $pageRepository->getDescendantPageIdsRecursive($site->getRootPageId(), 4);
        $pageIds[] = $site->getRootPageId();

        $qb = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
        $qb->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $fileReferences = $qb
            ->select('*')
            ->from('sys_file_reference')
            ->where(
                $qb->expr()->in('pid', $qb->createNamedParameter($pageIds, Connection::PARAM_INT_ARRAY)),
            )
            ->orderBy('pid')
            ->executeQuery()
            ->fetchAllAssociative();

        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        $result = [];
        foreach ($fileReferences as $fileReference) {
            $fileObject = $fileRepository->findByUid($fileReference['uid_local']);
            if (array_key_exists($fileObject->getUid(), $result)) {
                $result[$fileObject->getUid()]['pages'][$fileReference['pid']] = $fileReference['pid'];
            } else {
                $result[$fileObject->getUid()] = [
                    'file' => $fileObject,
                    'pages' => [$fileReference['pid'] => $fileReference['pid']],
                ];
            }
        }
        return $result;
    }
}
