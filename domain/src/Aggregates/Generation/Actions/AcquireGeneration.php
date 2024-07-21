<?php

namespace Domain\Aggregates\Generation\Actions;

final readonly class AcquireGeneration
{
    public function __construct(
        public string $asset,
        public string $date,
        public int $costBasis,
    ) {
    }
}
