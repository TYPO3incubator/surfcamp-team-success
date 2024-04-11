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

namespace Surfcamp\Success\Domain;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Creates sanitized records out of TCA records.
 *
 * @internal not part of TYPO3 Core API yet.
 */
class RecordFactory
{
    public function createFromDatabaseRecord(string $table, array $record): Record
    {
        // Resolve CType from TCA tt_content
        $tcaConfig = $GLOBALS['TCA'][$table];
        $typeFieldName = $tcaConfig['ctrl']['type'] ?? null;
        $typeValue = null;
        if ($typeFieldName !== null) {
            $typeValue = (string)$record[$typeFieldName];
        }

        $fullType = $table;
        if ($table === 'tt_content') {
            $fullType = 'content';
        }
        if ($typeFieldName !== null) {
            $fullType .= '.' . $typeValue ?: 'default';
        }

        $rawRecord = new RawRecord((int)$record['uid'], (int)$record['pid'], $record, $fullType);

        $allFieldNames = array_keys($tcaConfig['columns']);
        $allowedFieldName = array_keys($GLOBALS['TCA'][$table]['columns']);

        $relevantFieldNames = $this->findRelevantFieldsForSubSchema($tcaConfig, $typeValue);
        $relevantFieldNames = array_intersect(array_keys($relevantFieldNames), $allowedFieldName);

        $properties = [];
        foreach ($record as $fieldName => $fieldValue) {
            if (in_array($fieldName, $allFieldNames) && !in_array($fieldName, $relevantFieldNames)) {
                continue;
            }
            $properties[$fieldName] = $fieldValue;
        }

        // Resolve language information
        $specialProperties = [];
        $languageField = $tcaConfig['ctrl']['languageField'] ?? null;
        if ($languageField !== null) {
            $specialProperties['language'] = [];
            $specialProperties['language']['id'] = (int)$record[$languageField];
            unset($properties[$languageField]);
            $transOrigPointerField = $tcaConfig['ctrl']['transOrigPointerField'] ?? null;
            if ($transOrigPointerField !== null) {
                $specialProperties['language']['translationParent'] = (int)$record[$transOrigPointerField];
                unset($properties[$transOrigPointerField]);
            }
            $translationSourceField = $tcaConfig['ctrl']['translationSource'] ?? null;
            if ($translationSourceField !== null) {
                $specialProperties['language']['translationSource'] = (int)$record[$translationSourceField];
                unset($properties[$translationSourceField]);
            }
            unset($properties['l10n_state']);
            unset($properties['transOrigDiffSourceField']);
        }
        if ($tcaConfig['ctrl']['versioningWS'] ?? false) {
            $specialProperties['version'] = [
                'workspaceId' => (int)$record['t3ver_wsid'],
                'liveId' => (int)$record['t3ver_oid'],
                'versioningState' => (int)$record['t3ver_state'],
                'versioningStage' => (int)$record['t3ver_stage'],
            ];
            unset($properties['t3ver_wsid'], $properties['t3ver_oid'], $properties['t3ver_state'], $properties['t3ver_stage']);
        }

        // Resolve system fields
        if ($tcaConfig['ctrl']['delete'] ?? false) {
            $specialProperties['isDeleted'] = (bool)$properties[$tcaConfig['ctrl']['delete']];
            unset($properties[$tcaConfig['ctrl']['delete']]);
        }
        if ($tcaConfig['ctrl']['crdate'] ?? false) {
            $specialProperties['createdAt'] = new \DateTimeImmutable('@' . $properties[$tcaConfig['ctrl']['crdate']]);
            unset($properties[$tcaConfig['ctrl']['crdate']]);
        }
        if ($tcaConfig['ctrl']['tstamp'] ?? false) {
            $specialProperties['lastUpdatedAt'] = new \DateTimeImmutable('@' . $properties[$tcaConfig['ctrl']['tstamp']]);
            unset($properties[$tcaConfig['ctrl']['tstamp']]);
        }
        if ($tcaConfig['ctrl']['descriptionColumn'] ?? false) {
            $specialProperties['description'] = $properties[$tcaConfig['ctrl']['descriptionColumn']];
            unset($properties[$tcaConfig['ctrl']['descriptionColumn']]);
        }
        if ($tcaConfig['ctrl']['sortby'] ?? false) {
            $specialProperties['sorting'] = $properties[$tcaConfig['ctrl']['sortby']];
            unset($properties[$tcaConfig['ctrl']['sortby']]);
        }
        if ($tcaConfig['ctrl']['editlock'] ?? false) {
            $specialProperties['isLockedForEditing'] = (bool)$properties[$tcaConfig['ctrl']['editlock']];
            unset($properties[$tcaConfig['ctrl']['editlock']]);
        }
        foreach ($tcaConfig['ctrl']['enablecolumns'] ?? [] as $columnType => $fieldName) {
            switch ($columnType) {
                case 'disabled':
                    $specialProperties['isDisabled'] = (bool)$record[$fieldName];
                    unset($properties[$fieldName]);
                    break;
                case 'starttime':
                    $specialProperties['publishAt'] = new \DateTimeImmutable('@' . $record[$fieldName]);
                    unset($properties[$fieldName]);
                    break;
                case 'endtime':
                    $specialProperties['publishUntil'] = new \DateTimeImmutable('@' . $record[$fieldName]);
                    unset($properties[$fieldName]);
                    break;
                case 'fe_group':
                    $specialProperties['userGroupRestriction'] = GeneralUtility::intExplode(',', $record[$fieldName], true);
                    unset($properties[$fieldName]);
                    break;
            }
        }

        if ($typeFieldName !== null) {
            unset($properties[$typeFieldName]);
        }
        unset($properties['uid'], $properties['pid']);
        return Record::createFromPreparedRecord($rawRecord, $properties, $specialProperties);
    }

    public function getSubschemaConfig(array $tcaForTable, ?string $subSchemaName): array
    {
        return $tcaForTable['types'][$subSchemaName ?? '1'] ?? $tcaForTable['types'][1] ?? $tcaForTable[0];
    }

    public function findRelevantFieldsForSubSchema(array $tcaForTable, ?string $subSchemaName): array
    {
        $fields = [];
        $subSchemaConfig = $this->getSubschemaConfig($tcaForTable, $subSchemaName);
        $showItemArray = GeneralUtility::trimExplode(',', $subSchemaConfig['showitem']);
        foreach ($showItemArray as $aShowItemFieldString) {
            [$fieldName, $fieldLabel, $paletteName] = GeneralUtility::trimExplode(';', $aShowItemFieldString . ';;;');
            if ($fieldName === '--div--') {
                // tabs are not of interest here
                continue;
            }
            if ($fieldName === '--palette--' && !empty($paletteName)) {
                // showitem references to a palette field. unpack the palette and process
                // label overrides that may be in there.
                if (!isset($tcaForTable['palettes'][$paletteName]['showitem'])) {
                    // No palette with this name found? Skip it.
                    continue;
                }
                $palettesArray = GeneralUtility::trimExplode(
                    ',',
                    $tcaForTable['palettes'][$paletteName]['showitem']
                );
                foreach ($palettesArray as $aPalettesString) {
                    [$fieldName, $fieldLabel] = GeneralUtility::trimExplode(';', $aPalettesString . ';;');
                    if (isset($tcaForTable['columns'][$fieldName])) {
                        $fields[$fieldName] = $this->getFinalFieldConfiguration($fieldName, $tcaForTable, $subSchemaConfig, $fieldLabel);
                    }
                }
            } elseif (isset($tcaForTable['columns'][$fieldName])) {
                $fields[$fieldName] = $this->getFinalFieldConfiguration($fieldName, $tcaForTable, $subSchemaConfig, $fieldLabel);
            }
        }
        return $fields;
    }

    /**
     * Handles the label and possible columnsOverrides
     */
    public function getFinalFieldConfiguration($fieldName, array $schemaConfiguration, array $subSchemaConfiguration, ?string $fieldLabel = null): array
    {
        $fieldConfiguration = $schemaConfiguration['columns'][$fieldName] ?? [];
        if (isset($subSchemaConfiguration['columnsOverrides'][$fieldName])) {
            $fieldConfiguration = array_replace_recursive($fieldConfiguration, $subSchemaConfiguration['columnsOverrides'][$fieldName]);
        }
        if (!empty($fieldLabel)) {
            $fieldConfiguration['label'] = $fieldLabel;
        }
        return $fieldConfiguration;
    }
}
