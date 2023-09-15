<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        return inertia("Public/Home", [
            "title" => "mgr inż.",
            "name" => "Krzysztof Rewak",
            "department" => "Zakład Informatyki, Wydział Nauk Technicznych i Ekonomicznych",
            "university" => "Collegium Witelona Uczelnia Państwowa",
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
        ]);
    }
}
