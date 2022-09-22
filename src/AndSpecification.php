<?php

declare(strict_types=1);

namespace ADS\Specifications;

use Exception;
use Throwable;

final class AndSpecification extends Specification
{
    /** @var array<Specification> */
    private readonly array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(mixed $value): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($value)) {
                $this->setNotSatisfiedException($specification->notSatisfiedException($value));

                return false;
            }
        }

        return true;
    }

    public function notSatisfiedException(mixed $value): Throwable
    {
        return new Exception('No exception found for AndSpecification');
    }
}
