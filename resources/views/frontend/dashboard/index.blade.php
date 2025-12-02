@extends('layouts.frontend')

@section('title', 'Home')

@section('content')

    {{-- Carousel Component --}}
    @include('frontend.dashboard._carousel', ['carouselKonten' => $carouselKonten])
    
    {{-- About Component --}}
    @include('frontend.dashboard._about')

    {{-- Latest News Component --}}
    @include('frontend.dashboard._latest_news', ['latestNews' => $latestNews])

@endsection