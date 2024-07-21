<?php

namespace Domain\Aggregates\Generation\ValueObjects;

use EventSauce\EventSourcing\AggregateRootId;

final readonly class GenerationId implements AggregateRootId
{
    private function __construct(private string $id)
    {
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new self($aggregateRootId);
    }
}
