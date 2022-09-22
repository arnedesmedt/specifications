<?php

declare(strict_types=1);

namespace ADS\Specifications;

use Exception;
use Throwable;

final class NotSpecification extends Specification
{
    public function __construct(private readonly Specification $specification)
    {
    }

    public function isSatisfiedBy(mixed $value): bool
    {
        return ! $this->specification->isSatisfiedBy($value);
    }

    public function notSatisfiedException(mixed $value): Throwable
    {
        return $this->specification->oppositeNotSatisfiedException($value) ??
            new Exception('No exception found for NotSpecification');
    }
}
