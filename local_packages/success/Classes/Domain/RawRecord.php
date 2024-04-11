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
 * Holds all properties of a raw database row with unfiltered and unprocessed values.
 *
 * @todo: split up the properties in special / computed properties (such as _LOCALIZED_UID) and normal properties
 *
 * @internal not part of public API, as this needs to be streamlined and proven
 */
class RawRecord implements \ArrayAccess, RecordInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $properties = [];
    protected string $type = '';

    protected int $uid;
    protected int $pid;

    public function __construct(int $uid, int $pid, array $properties, string $type)
    {
        $this->uid = $uid;
        $this->pid = $pid;
        $this->properties = $properties;
        $this->type = $type;
    }

    public function getUid(): int
    {
        return $this->uid;
    }

    public function getPid(): int
    {
        return $this->pid;
    }

    public function getFullType(): string
    {
        return $this->type;
    }

    public function getType(): string
    {
        return count(GeneralUtility::revExplode('.', $this->type, 2)) === 1
            ? (GeneralUtility::revExplode('.', $this->type, 2)[1] ?: '') : '';
    }

    public function toArray(): array
    {
        return $this->properties;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->properties[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->properties[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \InvalidArgumentException('Record properties cannot be set.', 1712139284);
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \InvalidArgumentException('Record properties cannot be unset.', 1712139283);
    }
}
