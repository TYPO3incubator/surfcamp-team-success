<?php

namespace Surfcamp\Success\ViewHelpers;

use TYPO3\CMS\Core\Database\ConnectionPool;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PreviewAssetsViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('localUid', 'int', 'Current item.', true);
        $this->registerArgument('foreignTable', 'string', 'Tabel name [sys_file_reference]', true);
        $this->registerArgument('foreignField', 'string', 'Foreign column containing local uid.', true);
        $this->registerArgument('hasMedia', 'boolean', 'Has media.', false);
    }

    public function render()
    {
        $uid = (int)$this->arguments['localUid'];
        $tableName = $this->arguments['foreignTable'];
        $fieldName = $this->arguments['foreignField'];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
        $records = $queryBuilder
            ->select('*')
            ->from($tableName)
            ->where(
                $queryBuilder->expr()->eq($fieldName, $queryBuilder->createNamedParameter($uid))
            )
            ->executeQuery()->fetchAllAssociative();

        if (isset($this->arguments['hasMedia'])) {
            foreach ($records as $key => $record) {
                if ((isset($record['media']) && $record['media'] > 0) || (isset($record['assets']) && $record['assets'] > 0)) {
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
                    $media = $queryBuilder
                        ->select('f.*')
                        ->from('sys_file_reference', 'r')
                        ->leftJoin('r', 'sys_file', 'f', 'r.uid_local = f.uid')
                        ->where(
                            $queryBuilder->expr()->eq('r.uid_foreign', $queryBuilder->createNamedParameter($record['uid']))
                        )
                        ->andWhere(
                            $queryBuilder->expr()->eq('r.tableNames', $queryBuilder->createNamedParameter($tableName))
                        )
                        ->andWhere(
                            $queryBuilder->expr()->eq('r.deleted', $queryBuilder->createNamedParameter(0))
                        )
                        ->executeQuery()
                        ->fetchAssociative();
                    $records[$key]['media'] = '/fileadmin' . $media['identifier'];
                }
            }
        }

        return $records;
    }
}
