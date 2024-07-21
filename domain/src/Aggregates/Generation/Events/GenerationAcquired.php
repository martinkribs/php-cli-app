<?php

namespace Domain\Aggregates\Generation\Events;

final readonly class GenerationAcquired
{
    public function __construct(
        public string $date,
        public int $costBasis,
    ) {
    }
}
