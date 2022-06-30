<?php

declare(strict_types=1);

namespace ADS\Specifications;

use Throwable;

abstract class Specification
{
    protected ?Throwable $notSatisfiedException = null;
    protected ?Throwable $oppositeNotSatisfiedException = null;

    abstract public function isSatisfiedBy(mixed $value): bool;

    public function checkSatisfied(mixed $value): void
    {
        if ($this->isSatisfiedBy($value)) {
            return;
        }

        throw $this->notSatisfiedException ?? $this->notSatisfiedException($value);
    }

    public function setNotSatisfiedException(Throwable $notSatisfiedException): static
    {
        $this->notSatisfiedException = $notSatisfiedException;

        return $this;
    }

    abstract public function notSatisfiedException(mixed $value): Throwable;

    public function oppositeNotSatisfiedException(mixed $value): ?Throwable
    {
        return null;
    }
}
