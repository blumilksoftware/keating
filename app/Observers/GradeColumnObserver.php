<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\GradeColumn;

class GradeColumnObserver
{
    public function creating(GradeColumn $column): void
    {
        $maxOrder = $column->group->gradeColumns()->max("priority");
        $column->priority = ++$maxOrder;
    }
}
