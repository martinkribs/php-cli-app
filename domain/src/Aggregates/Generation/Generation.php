<?php

namespace Domain\Aggregates\Generation;

use Domain\Aggregates\Generation\Actions\AcquireGeneration;
use Domain\Aggregates\Generation\Events\GenerationAcquired;
use Domain\Aggregates\Generation\Exceptions\GenerationException;
use Domain\Aggregates\Generation\ValueObjects\GenerationId;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;
use Throwable;

/**
 * @template AggregateRootIdType of AggregateRootId
 *
 * @implements AggregateRoot<GenerationId>
 */
class Generation implements AggregateRoot
{
    /**
     * @use AggregateRootBehaviour<GenerationId>
     */
    use AggregateRootBehaviour;

    private bool $acquired = false;

    /**
     * Handle the acquire action.
     *
     * @param AcquireGeneration $action the action to acquire generation
     *
     * @throws Throwable if the generation is already acquired
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

    /**
     * Apply the GenerationAcquired event.
     *
     * @param GenerationAcquired $event the event indicating that generation was acquired
     */
    public function applyGenerationAcquired(GenerationAcquired $event): void
    {
        $this->acquired = true;
    }
}
