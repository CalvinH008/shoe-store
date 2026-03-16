@extends('layouts.landing')

@section('content')
    @include('home.hero')
    @include('home.popular_products')
    @include('home.best_collection')
    @include('home.features')
@endsection

@section('scripts')
    <script>
        const hero = document.getElementById("hero");
        const glassItems = document.querySelectorAll(".nav-glass");
        const navTexts = document.querySelectorAll(".nav-text");
        window.addEventListener("scroll", () => {
            const heroHeight = hero.offsetHeight;
            if (window.scrollY > heroHeight - 120) {
                glassItems.forEach(el => {
                    el.classList.remove("bg-white/10");
                    el.classList.add("bg-white/80");
                });
                navTexts.forEach(el => {
                    el.classList.remove("text-slate-200");
                    el.classList.add("text-gray-900");
                });
            } else {
                glassItems.forEach(el => {
                    el.classList.remove("bg-white/80");
                    el.classList.add("bg-white/10");
                });
                navTexts.forEach(el => {
                    el.classList.remove("text-gray-900");
                    el.classList.add("text-slate-200");
                });
            }
        });
    </script>
@endsection
