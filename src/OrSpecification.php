<?php

declare(strict_types=1);

namespace ADS\Specifications;

use Exception;
use LogicException;
use Throwable;

use function array_map;
use function json_encode;
use function sprintf;

use const JSON_THROW_ON_ERROR;

final class OrSpecification extends Specification
{
    /** @var array<Specification> */
    private readonly array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(mixed $value): bool
    {
        if (empty($this->specifications)) {
            return true;
        }

        $exceptions = [];
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($value)) {
                return true;
            }

            $exceptions[] = $specification->notSatisfiedException($value);
        }

        if (empty($this->notSatisfiedException)) {
            $this->setNotSatisfiedException(
                new LogicException(
                    sprintf(
                        'One of the following exceptions needs to be solved: %s',
                        json_encode(
                            array_map(
                                static fn (Throwable $exception) => $exception->getMessage(),
                                $exceptions
                            ),
                            JSON_THROW_ON_ERROR
                        )
                    )
                )
            );
        }

        return false;
    }

    public function notSatisfiedException(mixed $value): Throwable
    {
        return new Exception('No exception found for OrSpecification');
    }
}
