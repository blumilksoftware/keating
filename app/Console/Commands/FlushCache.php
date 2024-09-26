<?php

declare(strict_types=1);

namespace Keating\Console\Commands;

use Illuminate\Cache\CacheManager;
use Illuminate\Console\Command;

class FlushCache extends Command
{
    protected $signature = "cache:flush";
    protected $description = "Flush cached data";

    public function handle(CacheManager $cache): void
    {
        $this->call(FlushCachedPageTitle::class);
        $this->call(FlushCachedScheduleLink::class);
    }
}
