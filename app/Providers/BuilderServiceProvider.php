<?php

declare(strict_types=1);

namespace Keating\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class BuilderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Builder::macro("whereLikeUnaccentInsensitive", fn($column, $search): Builder => $this->whereRaw("unaccent($column) ILIKE unaccent(?)", ["%{$search}%"]));
        Builder::macro("orWhereLikeUnaccentInsensitive", fn($column, $search): Builder => $this->orWhereRaw("unaccent($column) ILIKE unaccent(?)", ["%{$search}%"]));
    }
}
