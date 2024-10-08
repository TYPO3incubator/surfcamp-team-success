<?php

declare(strict_types=1);

namespace Surfcamp\Success\Content;

use Surfcamp\Success\Domain\RecordInterface;

class ResolvedRecord implements RecordInterface
{
    public function __construct(
        protected readonly RecordInterface $record,
        protected readonly array $resolvedProperties
    ) {}

    public function getUid(): int
    {
        return $this->record->getUid();
    }

    public function getPid(): int
    {
        return $this->record->getPid();
    }

    public function getFullType(): string
    {
        return $this->record->getFullType();
    }

    public function getType(): string
    {
        return $this->record->getType();
    }

    public function getRecord(): RecordInterface
    {
        return $this->record;
    }

    public function toArray(): array
    {
        return array_replace($this->record->toArray(), $this->resolvedProperties);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->properties[$offset]) || isset($this->record[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->properties[$offset] ?? $this->record[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \InvalidArgumentException('Record properties cannot be modified.', 1712139281);
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \InvalidArgumentException('Record properties cannot be unset.', 1712139282);
    }

}
