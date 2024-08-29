<x-mail::layout>

    <x-slot:header>
        <x-mail::header url="{{config('app.url')}}">
            Keating
        </x-mail::header>
    </x-slot:header>

    Zaloguj się, klikając w poniższy przycisk:

    <x-mail::button :url="$url">
        Zaloguj
    </x-mail::button>

    <x-slot:footer>
        <x-mail::footer>
            Keating &copy; {{ date('Y') }}
        </x-mail::footer>
    </x-slot:foot>

</x-mail::layout>
