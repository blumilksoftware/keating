<?php

declare(strict_types=1);

namespace Keating\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
