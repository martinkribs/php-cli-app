<?php

use Domain\Aggregates\Generation\Actions\AcquireGeneration;
use Domain\Aggregates\Generation\Events\GenerationAcquired;
use Domain\Aggregates\Generation\Exceptions\GenerationException;
use Domain\Tests\Aggregates\Generation\GenerationTestCase;

use function EventSauce\EventSourcing\PestTooling\expectToFail;
use function EventSauce\EventSourcing\PestTooling\given;
use function EventSauce\EventSourcing\PestTooling\then;
use function EventSauce\EventSourcing\PestTooling\when;

uses(GenerationTestCase::class);

it('can acquire a generation', function () {
    when(new AcquireGeneration(
        asset: 'Generation1',
        date: '2015-10-21',
        costBasis: 100,
    ));

    then(new GenerationAcquired(
        date: '2015-10-21',
        costBasis: 100,
    ));
});

it('cannot acquire the same generation more than once', function () {
    given(new GenerationAcquired(
        date: '2015-10-21',
        costBasis: 100,
    ));

    when(new AcquireGeneration(
        asset: 'Generation1',
        date: '2015-10-22',
        costBasis: 100,
    ));

    expectToFail(GenerationException::alreadyAcquired('Generation1'));
});
