<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Grade;

class GradeObserver
{
    public function updating(Grade $grade): void
    {
        if ($grade->status === true && $grade->getOriginal("status") === false) {
            $grade->status = null;
        }
    }
}
