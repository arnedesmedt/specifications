<?php

declare(strict_types=1);

namespace ADS\Specifications;

use Throwable;

/** @template T */
abstract class Specification
{
    protected Throwable|null $notSatisfiedException = null;
    protected Throwable|null $oppositeNotSatisfiedException = null;

    /** @param T $value */
    abstract public function isSatisfiedBy(mixed $value): bool;

    /** @param T $value */
    public function checkSatisfied(mixed $value): static
    {
        if ($this->isSatisfiedBy($value)) {
            return $this;
        }

        throw $this->notSatisfiedException ?? $this->notSatisfiedException($value);
    }

    public function setNotSatisfiedException(Throwable $notSatisfiedException): static
    {
        $this->notSatisfiedException = $notSatisfiedException;

        return $this;
    }

    /** @param T $value */
    abstract public function notSatisfiedException(mixed $value): Throwable;

    /** @param T $value */
    public function oppositeNotSatisfiedException(mixed $value): Throwable|null
    {
        return null;
    }
}
