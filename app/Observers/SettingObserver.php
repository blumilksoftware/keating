<?php

declare(strict_types=1);

namespace Keating\Observers;

use Illuminate\Cache\CacheManager;

class SettingObserver
{
    public function __construct(
        protected CacheManager $cache,
    ) {}

    public function saved(): void
    {
        $this->cache->forget("pageTitle");
    }
}
