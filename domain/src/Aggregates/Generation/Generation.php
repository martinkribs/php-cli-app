<?php

namespace Domain\Aggregates\Generation;

use Domain\Aggregates\Generation\Actions\AcquireGeneration;
use Domain\Aggregates\Generation\Events\GenerationAcquired;
use Domain\Aggregates\Generation\Exceptions\GenerationException;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Throwable;

class Generation implements AggregateRoot
{
    use AggregateRootBehaviour;

    private bool $acquired = false;

    /**
     * @throws Throwable
     */
    public function acquire(AcquireGeneration $action): void
    {
        throw_if(
            $this->acquired,
            GenerationException::alreadyAcquired($this->aggregateRootId->toString()),
        );

        $this->recordThat(new GenerationAcquired(
            date: $action->date,
            costBasis: $action->costBasis,
        ));
    }

    public function applyGenerationAcquired(GenerationAcquired $event): void
    {
        $this->acquired = true;
    }
}
