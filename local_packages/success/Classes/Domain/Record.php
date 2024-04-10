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

/**
 * Represents a record with all properties valid for this record type.
 *
 * @internal not part of public API, as this needs to be streamlined and proven
 */
class Record implements \ArrayAccess, RecordInterface
{
    protected array $properties = [];
    protected array $specialProperties = [];
    protected RawRecord $rawRecord;

    public static function createFromPreparedRecord(RawRecord $rawRecord, array $properties, array $specialProperties = []): self
    {
        $obj = new self();
        $obj->rawRecord = $rawRecord;
        $obj->properties = $properties;
        $obj->specialProperties = $specialProperties;
        $obj->enhancePropertiesFromRawProperties($rawRecord->toArray());
        return $obj;
    }

    public function getUid(): int
    {
        return $this->rawRecord->getUid();
    }

    public function getPid(): int
    {
        return $this->rawRecord->getPid();
    }

    public function getLanguageId(): int
    {
        return $this->specialProperties['language']['id'] ?? 0;
    }

    public function getTranslationParent(): int
    {
        return $this->specialProperties['language']['translationParent'] ?? 0;
    }

    public function getFullType(): string
    {
        return $this->rawRecord->getFullType();
    }

    public function getType(): string
    {
        return $this->rawRecord->getType();
    }

    public function getMainType(): string
    {
        return explode('.', $this->rawRecord->getFullType())[0];
    }

    public function toArray(bool $includeSpecialProperties = false): array
    {
        if ($includeSpecialProperties) {
            return $this->properties + $this->specialProperties;
        }
        return $this->properties;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->properties[$offset]) || isset($this->rawRecord[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->properties[$offset] ?? $this->rawRecord[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \InvalidArgumentException('Record properties cannot be modified.', 1712139281);
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \InvalidArgumentException('Record properties cannot be unset.', 1712139282);
    }

    public function getRawRecord(): RawRecord
    {
        return $this->rawRecord;
    }

    /**
     * @todo: find a better name - "overlaid uid"?.
     */
    public function getRawUid(): int
    {
        if (isset($this->rawRecord['_ORIG_uid'])) {
            return (int)$this->rawRecord['_ORIG_uid'];
        }
        if (isset($this->rawRecord['_LOCALIZED_UID'])) {
            return (int)$this->rawRecord['_LOCALIZED_UID'];
        }
        return $this->getUid();
    }

    protected function enhancePropertiesFromRawProperties(array $properties): void {
        if(isset($properties['uid'])) {
            $this->properties['uid'] = $properties['uid'];
        }
        if(isset($properties['pid'])) {
            $this->properties['pid'] = $properties['pid'];
        }
        if(isset($properties['_ORIG_uid'])) {
            $this->properties['_ORIG_uid'] = $properties['_ORIG_uid'];
        }
        if(isset($properties['_LOCALIZED_UID'])) {
            $this->properties['_LOCALIZED_UID'] = $properties['_LOCALIZED_UID'];
        }
    }
}
