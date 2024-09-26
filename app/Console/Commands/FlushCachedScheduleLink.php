<?php

declare(strict_types=1);

namespace Keating\Console\Commands;

use Illuminate\Cache\CacheManager;
use Illuminate\Console\Command;

class FlushCachedScheduleLink extends Command
{
    protected $signature = "cache:link:flush";
    protected $description = "Flush cached schedule link";

    public function handle(CacheManager $cache): void
    {
        $cache->forget("scheduleLink");
    }
}
