<?php

declare(strict_types=1);

namespace Kreait\Firebase\JWT\Contract;

interface Token
{
    public function __toString(): string;

    /**
     * @return array<string, mixed>
     */
    public function headers(): array;

    /**
     * @return array<string, mixed>
     */
    public function payload(): array;

    public function toString(): string;
}
