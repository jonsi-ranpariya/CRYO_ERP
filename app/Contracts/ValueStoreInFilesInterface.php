<?php
/**
 * Created by Jaymeen Darji.
 * User: jaymeen
 * Date: 3/17/23
 * Time: 5:31 PM
 */

namespace App\Contracts;

interface ValueStoreInFilesInterface
{
    public static function make(string $fileName, ?array $values = null): static;

    public function put(array|string $name,mixed $value = null): static;

    public function push(string $name, mixed $pushValue): static;

    public function prepend(string $name, mixed $prependValue): static;

    public function get(string $name, mixed $default = null): mixed;

    public function has(string $name): bool;

    public function all(): array;

    public function allStartingWith(string $startingWith = ''): array;

    public function forget(string $key): static;

    public function flush(): static;

    public function flushStartingWith(string $startingWith = ''): static;

    public function pull(string $name): mixed;

    public function increment(string $name, int $by = 1): mixed;

    public function decrement(string $name, int $by = 1): array|string|int|float|null;

    public function offsetExists($offset): bool;

    public function offsetGet($offset): mixed;

    public function offsetSet($offset, $value): void;

    public function offsetUnset($offset): void;

    public function count(): int;
}
