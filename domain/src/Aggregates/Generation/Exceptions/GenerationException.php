<?php

namespace Domain\Aggregates\Generation\Exceptions;

use RuntimeException;

final class GenerationException extends RuntimeException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function alreadyAcquired(string $asset): self
    {
        return new self(sprintf('Generation %s has already been acquired', $asset));
    }
}
