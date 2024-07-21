<?php

namespace Domain\Tests\Aggregates\Generation;

use Domain\Aggregates\Generation\Actions\AcquireGeneration;
use Domain\Aggregates\Generation\Generation;
use Domain\Aggregates\Generation\ValueObjects\GenerationId;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\TestUtilities\AggregateRootTestCase;

abstract class GenerationTestCase extends AggregateRootTestCase
{
    protected function newAggregateRootId(): AggregateRootId
    {
        return GenerationId::fromString('Generation1');
    }

    protected function aggregateRootClassName(): string
    {
        return Generation::class;
    }

    public function handle(object $arguments): void
    {
        $generation = $this->repository->retrieve($this->aggregateRootId);

        if ($arguments instanceof AcquireGeneration) {
            $generation->acquire($arguments);
        }

        $this->repository->persist($generation);
    }
}
