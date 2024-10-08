<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Surfcamp\Success\Content;

use Surfcamp\Success\Domain\Record;
use Surfcamp\Success\Domain\RecordFactory;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Resource\FileCollector;

/**
 * Enriches a record with resolved properties from relations.
 * It's like a DataMapper approach
 */
class RecordEnricher
{
    public function __construct(
        protected readonly RecordFactory $recordFactory
    ) {}

    public function createResolvedRecordFromRecord(Record $record): ResolvedRecord
    {
        $resolvedProperties = [];
        $mainType = $record->getMainType();
        if ($mainType === 'content') {
            $mainType = 'tt_content';
        }
        $tcaSchema = $GLOBALS['TCA'][$mainType];
        $subSchemaConfig = $this->recordFactory->getSubschemaConfig($tcaSchema, $record->getType());

        foreach ($record->toArray() as $fieldName => $fieldValue) {
            $fieldConfiguration = $this->recordFactory->getFinalFieldConfiguration($fieldName, $tcaSchema, $subSchemaConfig);
            if (isset($fieldConfiguration['config'])) {
                switch ($fieldConfiguration['config']['type']) {
                    case 'file':
                        /** @var FileCollector $fileCollector */
                        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);
                        $fileCollector->addFilesFromRelation($mainType, $fieldName, $record->getRawRecord()->toArray());
                        $resolvedProperties[$fieldName] = $fileCollector->getFiles();
                        if ((int)($fieldConfiguration['config']['maxitems'] ?? 0) === 1) {
                            $resolvedProperties[$fieldName] = reset($resolvedProperties[$fieldName]);
                        }
                        break;
                    case 'inline':
                    case 'select':
                        if (!isset($fieldConfiguration['config']['foreign_table']) || !isset($fieldConfiguration['config']['foreign_field'])) {
                            break;
                        }
                        $selectConfiguration = [
                            'where' => $fieldConfiguration['config']['foreign_field'] . '=' . (int)$record->getRawUid(),
                        ];
                        if (isset($GLOBALS['TCA'][$fieldConfiguration['config']['foreign_table']]['ctrl']['sortby'])) {
                            $selectConfiguration['orderBy'] = $GLOBALS['TCA'][$fieldConfiguration['config']['foreign_table']]['ctrl']['sortby'];
                        } elseif (isset($GLOBALS['TCA'][$fieldConfiguration['config']['foreign_table']]['ctrl']['default_sortby'])) {
                            $selectConfiguration['orderBy'] = $GLOBALS['TCA'][$fieldConfiguration['config']['foreign_table']]['ctrl']['default_sortby'];
                        }

                        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
                        $cObj->start($record->getRawRecord()->toArray(), $record->getMainType());
                        $recordFactory = new RecordFactory();
                        $subRecords = GeneralUtility::makeInstance(RecordCollector::class, $recordFactory)->collect(
                            $fieldConfiguration['config']['foreign_table'],
                            $selectConfiguration,
                            ContentSlideMode::None,
                            $cObj
                        );
                        /** @var Record $subRecord */
                        foreach ($subRecords as $subRecord) {
                            $resolvedProperties[$fieldName][] = $this->createResolvedRecordFromRecord($subRecord)->toArray(true);
                        }

                        if ((int)($fieldConfiguration['config']['maxitems'] ?? 0) === 1) {
                            $resolvedProperties[$fieldName] = reset($resolvedProperties[$fieldName]);
                        }

                        break;
                    case 'flex':
                        $resolvedProperties[$fieldName] = GeneralUtility::makeInstance(FlexFormService::class)->convertFlexFormContentToArray($fieldValue);
                        break;
                }
            }
        }
        return new ResolvedRecord($record, $resolvedProperties);
    }

}
