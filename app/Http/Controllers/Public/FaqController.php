<?php

declare(strict_types=1);

namespace Keating\Http\Controllers\Public;

use Inertia\Response;
use Keating\Models\Faq;

class FaqController
{
    public function __invoke(): Response
    {
        $faqs = Faq::query()->get();

        return inertia("Public/Faq", [
            "faqs" => $faqs,
        ]);
    }
}
