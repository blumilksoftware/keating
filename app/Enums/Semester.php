<?php

declare(strict_types=1);

namespace App\Enums;

enum Semester: string
{
    case FIRST = "I";
    case SECOND = "II";
    case THIRD = "III";
    case FOURTH = "IV";
    case FIFTH = "V";
    case SIXTH = "VI";
    case SEVENTH = "VII";
    case EIGHTH = "VIII";
    case NINTH = "IX";
    case TENTH = "X";

    public static function labels(): array
    {
        return [
            "I" => __("I"),
            "II" => __("II"),
            "III" => __("III"),
            "IV" => __("IV"),
            "V" => __("V"),
            "VI" => __("VI"),
            "VII" => __("VII"),
            "VIII" => __("VIII"),
            "IX" => __("IX"),
            "X" => __("X"),
        ];
    }
}
