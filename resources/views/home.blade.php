@extends('layouts.main')

@section('header-title', 'Home page of CineMagic')

@section('main')
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Bem-vindo ao CineMagic!
                , Onde cada sessão é uma experiência mágica
            </h3>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                No CineMagic, acreditamos que o cinema é muito mais do que assistir a um filme – é viver uma experiência única e inesquecível. Desde os últimos lançamentos de Hollywood até os clássicos que marcaram gerações, nosso compromisso é proporcionar momentos inesquecíveis para você e sua família.
            </p>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                
                Nossos diferenciais
                Tecnologia de Ponta: Nossas salas são equipadas com o que há de mais moderno em projeção e som, garantindo uma qualidade audiovisual incomparável.
                Conforto e Convivência: Poltronas reclináveis, amplo espaço entre assentos e uma atmosfera acolhedora para que você se sinta em casa.
                Diversidade de Gêneros: Uma seleção cuidadosa de filmes para todos os gostos – ação, comédia, drama, animação e muito mais.
                Gastronomia: Além da tradicional pipoca, oferecemos uma variada opção de snacks e bebidas para tornar sua sessão ainda mais agradável.
            </p>
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            Programação
            </h3>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                Fique por dentro dos próximos lançamentos e dos filmes em cartaz! Nosso site é atualizado constantemente para que você possa planejar sua próxima visita ao CineMagic com antecedência. Não perca as estreias mais esperadas do ano!
            </p>

              
            <div class="flex justify-center my-6">
                <img src="{{ Vite::asset('resources/img/cadeiras.jpg') }}" alt="Cadeiras de cinema" class="rounded-lg shadow-md w-56 h-56">
            </div>
        </div>

     

        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Staff
            </h3>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                A nossa equipa trabalhou arduamente para lhe entregar uma boa experiência
            <ul class="list-disc ms-12">
                <li class="py-1 font-medium text-gray-700 dark:text-gray-300">Chefe de sala, António Silva</li>
                <li class="py-1 font-medium text-gray-700 dark:text-gray-300">Marketing, Ricardo Pombinha</li>
                <li class="py-1 font-medium text-gray-700 dark:text-gray-300">Homem das pipocas, Rodrigo Camarada</li>
            </ul>
            </p>
        </div>
    </div>
</main>
@endsection
