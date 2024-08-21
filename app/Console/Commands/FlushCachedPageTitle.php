<?php

declare(strict_types=1);

namespace Keating\Console\Commands;

use Illuminate\Cache\CacheManager;
use Illuminate\Console\Command;

class FlushCachedPageTitle extends Command
{
    protected $signature = "cache:title:flush";
    protected $description = "Flush cached page title";

    public function handle(CacheManager $cache): void
    {
        $cache->forget("pageTitle");
    }
}
