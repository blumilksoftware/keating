<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $question
 * @property string $answer
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Faq extends Model
{
    use HasFactory;
    use HasUlids;

    protected $guarded = [];
}
