<?php

declare(strict_types=1);

namespace Surfcamp\Copyright\Domain\Repository;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;

readonly class CopyrightRepository
{
    public function __construct(
        protected PageRepository $pageRepository,
        protected FileRepository $fileRepository,
        protected ConnectionPool $connectionPool
    )
    {
    }

    /**
     * @throws Exception
     */
    public function findBySite(Site $site, $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/svg+xml']): array
    {
        // first fetch all pages in a specific site
        $pageIds = $this->pageRepository->getDescendantPageIdsRecursive($site->getRootPageId(), 4);
        $pageIds[] = $site->getRootPageId();

        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('sys_file_reference');
        $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
        $fileReferences = $queryBuilder
            ->select('r.*')
            ->from('sys_file_reference', 'r')
            ->leftJoin('r', 'sys_file', 'f', 'r.uid_local = f.uid')
            ->leftJoin('f', 'sys_file_metadata', 'm', 'f.uid = m.file')
            ->where(
                $queryBuilder->expr()->in('r.pid', $queryBuilder->createNamedParameter($pageIds, Connection::PARAM_INT_ARRAY)),
                $queryBuilder->expr()->in('f.mime_type', $queryBuilder->createNamedParameter($allowedMimeTypes, Connection::PARAM_STR_ARRAY)),
                $queryBuilder->expr()->isNotNull('m.copyright')
            )
            ->orderBy('m.title')
            ->executeQuery()
            ->fetchAllAssociative();

        $result = [];
        foreach ($fileReferences as $fileReference) {
            $fileObject = $this->fileRepository->findByUid($fileReference['uid_local']);
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
