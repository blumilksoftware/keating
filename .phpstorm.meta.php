<?php

namespace Illuminate\Database\Eloquent {
    use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

    class Builder implements BuilderContract {
        public function whereLikeUnaccentInsensitive(string $column, mixed $value): static {
            return $this;
        }

        public function orWhereLikeUnaccentInsensitive(string $column, mixed $value): static {
            return $this;
        }
    }
}
