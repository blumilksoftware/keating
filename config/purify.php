<?php

declare(strict_types=1);

use Stevebauman\Purify\Definitions\Html5Definition;

return [
    "default" => "default",
    "configs" => [
        "default" => [
            "Core.Encoding" => "utf-8",
            "HTML.Doctype" => "HTML 4.01 Transitional",
            "HTML.Allowed" => "h1,h2,b,strong,i,em,s,u,del,a[href|title],ul,ol,li,p,br,span,pre",
            "HTML.ForbiddenElements" => "",
            "CSS.AllowedProperties" => "",
            "AutoFormat.AutoParagraph" => false,
            "AutoFormat.RemoveEmpty" => true,
        ],
    ],
    "definitions" => Html5Definition::class,
    "serializer" => storage_path("app/purify"),
];
