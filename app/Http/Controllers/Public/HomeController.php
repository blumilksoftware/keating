<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        /** @var Setting $settings */
        $settings = Setting::query()->first();

        return inertia("Public/Home", [
            "title" => $settings->teacher_titles,
            "name" => $settings->teacher_name,
            "email" => $settings->teacher_email,
            "department" => $settings->department_name,
            "university" => $settings->university_name,
            "universityLogo" => "https://irg2023.collegiumwitelona.pl/assets/logos/cwup.png",
            "sections" => [
                [
                    "header" => "Naukowo",
                    "paragraphs" => [
                        "Ukończyłem studia inżynierskie i magisterskie na kierunku Automatyka i Robotyka na Wydziale Elektroniki Politechniki Wrocławskiej. Specjalizowałem się, kolejno na studiach pierwszego i drugiego stopnia, w systemach informatycznych w automatyce oraz technologiach informacyjnych w systemach automatyki.",
                        "Od pierwszej połowy 2016 roku prowadzę zawodowe praktyki dla studentów i uczę praktycznie programowania w ramach różnych projektów. W 2017 można było usłyszeć mój wykład w ramach Otwartych Seminariów Naukowych. Od 2017 pracuję jako nauczyciel akademicki na Wydziale Nauk Technicznych i Ekonomicznych Collegium Witelona Uczelnia Państwowa, dawniej Państwowej Wyższej Szkoły Zawodowej im. Witelona w Legnicy.",
                    ],
                ],
                [
                    "header" => "Zawodowo",
                    "paragraphs" => [
                        "Od 2014 roku pracuję jako programista. Zaczynałem jako młodszy programista PHP w małym wrocławskim software housie, gdzie pod bacznym okiem specjalistów nauczyłem się realistycznego i praktycznego podejścia do zawodu. Później pracowałem w projektach dla międzynarodowych korporacji, firm z sektora MŚP oraz startupów. Od 2020 roku jestem dyrektorem ds. technologii w software housie Blumilk.",
                        "Zawsze gdy moge wybrać, programuję w PHP - najchętniej w najnowszej wersji oraz przede wszystkim w Laravelu. Mam zawodowe doświadczenie w pracy z przeróżnymi frameworkami JavaScriptu, Pythonem oraz C#.",
                    ],
                ],
                [
                    "header" => "Prywatnie",
                    "paragraphs" => [
                        "Urodziłem się i mieszkam od urodzenia w Legnicy (choć miałem w tym pięcioletnią przerwę na mieszkanie i studiowanie we Wrocławiu). W wolnym czasie lubię siedzieć nad książkami wszelkiego gatunku, śledzić przeróżne seriale oraz jeździć po legnickich i okolicznych drogach rowerowych.",
                        "Ponadto jestem piwowarem domowym, więc warzę w domu własnoręcznie piwo, jestem zapalonym fanem Gwiezdnych wojen, a także - a jakżeby inaczej! - programuję najróżniejsze rzeczy w najróżniejszych technologiach w najróżniejszym celu.",
                    ],
                ],
            ],
            "counters" => [
                ["id" => 1, "name" => "lat prowadzenia zajęć dydaktycznych na uczelni", "value" => 7],
                ["id" => 2, "name" => "kursów prowadzonych w tym semestrze", "value" => 5],
                ["id" => 3, "name" => "studentów na wykładach i innych zajęciach", "value" => 345],
                ["id" => 4, "name" => "średnia ocena wystawiona przez studentów w ankiecie nt. jakości kształcenia", "value" => 4.93],
            ],
        ]);
    }
}
