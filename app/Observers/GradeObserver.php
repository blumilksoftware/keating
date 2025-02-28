<?php

declare(strict_types=1);

namespace Keating\Observers;

use Keating\Models\Grade;

class GradeObserver
{
    public function updating(Grade $grade): void
    {
        if (!$grade->massUpdated) {
            if ($grade->status === true && $grade->getOriginal("status") === false) {
                $grade->status = null;
            }
        }
    }
}
