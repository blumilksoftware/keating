<script setup>
import {ref} from 'vue'
import {Dialog, DialogPanel} from '@headlessui/vue'
import {Bars3Icon, XMarkIcon} from '@heroicons/vue/24/outline'

const navigation = [
    { name: 'Strona główna', href: '#' },
    { name: 'Aktualności', href: '#' },
    { name: 'Kursy i materiały', href: '#' },
    { name: 'Oceny', href: '#' },
    { name: 'FAQ', href: '#' },
    { name: 'Kontakt', href: '#' },
]

const mobileMenuOpen = ref(false)

const sections = [
    {
        header: 'Naukowo',
        paragraphs: ['Ukończyłem studia inżynierskie i magisterskie na kierunku Automatyka i Robotyka na Wydziale Elektroniki Politechniki Wrocławskiej. Specjalizowałem się, kolejno na studiach pierwszego i drugiego stopnia, w systemach informatycznych w automatyce oraz technologiach informacyjnych w systemach automatyki.',
            'Od pierwszej połowy 2016 roku prowadzę zawodowe praktyki dla studentów i uczę praktycznie programowania w ramach różnych projektów. W 2017 można było usłyszeć mój wykład w ramach Otwartych Seminariów Naukowych. Od 2017 pracuję jako nauczyciel akademicki na Wydziale Nauk Technicznych i Ekonomicznych Collegium Witelona Uczelnia Państwowa, dawniej Państwowej Wyższej Szkoły Zawodowej im. Witelona w Legnicy.']
    },
    {
        header: "Zawodowo",
        paragraphs: ['Od 2014 roku pracuję jako programista. Zaczynałem jako młodszy programista PHP w małym wrocławskim software housie, gdzie pod bacznym okiem specjalistów nauczyłem się realistycznego i praktycznego podejścia do zawodu. Później pracowałem w projektach dla międzynarodowych korporacji, firm z sektora MŚP oraz startupów. Od 2020 roku jestem dyrektorem ds. technologii w software housie Blumilk.', 'Zawsze gdy moge wybrać, programuję w PHP - najchętniej w najnowszej wersji oraz przede wszystkim w Laravelu. Mam zawodowe doświadczenie w pracy z przeróżnymi frameworkami JavaScriptu, Pythonem oraz C#.']
    },
    {
        header: "Prywatnie",
        paragraphs: ['Urodziłem się i mieszkam od urodzenia w Legnicy (choć miałem w tym pięcioletnią przerwę na mieszkanie i studiowanie we Wrocławiu). W wolnym czasie lubię siedzieć nad książkami wszelkiego gatunku, śledzić przeróżne seriale oraz jeździć po legnickich i okolicznych drogach rowerowych.', 'Ponadto jestem piwowarem domowym, więc warzę w domu własnoręcznie piwo, jestem zapalonym fanem Gwiezdnych wojen, a także - a jakżeby inaczej! - programuję najróżniejsze rzeczy w najróżniejszych technologiach w najróżniejszym celu.']
    }
]
</script>

<template>
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:hidden">
                    <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = true">
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a v-for="item in navigation" :key="item.name" :href="item.href" class="text-sm font-semibold leading-6 text-gray-900">{{ item.name }}</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Logowanie <span aria-hidden="true">&rarr;</span></a>
                </div>
            </nav>
            <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
                <div class="fixed inset-0 z-50" />
                <DialogPanel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
                            <span class="sr-only">Close menu</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a v-for="item in navigation" :key="item.name" :href="item.href" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ item.name }}</a>
                            </div>
                            <div class="py-6">
                                <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Logowanie</a>
                            </div>
                        </div>
                    </div>
                </DialogPanel>
            </Dialog>
        </header>

        <div class="relative isolate pt-14">
            <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                    <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
                </svg>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
            </svg>
            <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:flex lg:items-center lg:gap-x-10 lg:px-8 lg:py-40">
                <div class="mx-auto max-w-7xl lg:mx-0 lg:flex-auto text-center">
                    <h1 class="mt-10 mx-auto max-w-4xl text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        <span class="font-normal">mgr inż.</span>
                        Krzysztof Rewak
                    </h1>
                    <p class="mt-12 text-lg text-gray-600">
                        Zakład Informatyki, Wydział Nauk Technicznych i Ekonomicznych
                    </p>
                    <p class="text-lg text-gray-600">
                        Collegium Witelona Uczelnia Państwowa
                    </p>
                    <img src="https://irg2023.collegiumwitelona.pl/assets/logos/cwup.png" alt="Collegium Witelona Uczelnia Państwowa" class="w-[360px] mx-auto">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-gray-50 to-gray-100 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">O mnie</h2>
                <p class="mt-1 text-lg leading-8 text-gray-600">Kilka słów o mnie.</p>
            </div>
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 pt-10 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                <article v-for="section in sections" :key="section.title" class="flex max-w-xl flex-col items-start justify-between">
                    <div class="group relative">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                            <span class="absolute inset-0" />
                            {{ section.header }}
                        </h3>
                        <p class="mt-5 text-sm leading-6 text-gray-600" v-for="paragraph in section.paragraphs">{{ paragraph }}</p>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <footer class="bg-white">
        <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-center lg:px-8">
            <div class="mt-8 md:order-1 md:mt-0">
                <p class="text-center text-xs leading-5 text-gray-500">&copy; 2023 keating management system</p>
            </div>
        </div>
    </footer>
</template>
