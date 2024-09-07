<?php

declare(strict_types=1);

namespace Keating\Policies;

use Keating\Models\User;

class UserPolicy
{
    public function faqEnabled(User $user): bool
    {
        return config("keating.sections.faq_enabled");
    }

    public function contactEnabled(User $user): bool
    {
        return config("keating.sections.contact_enabled");
    }

    public function newsEnabled(User $user): bool
    {
        return config("keating.sections.news_enabled");
    }
}
