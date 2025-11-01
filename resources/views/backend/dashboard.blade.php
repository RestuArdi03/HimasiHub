@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('page-heading', 'Profile Statistics')

@section('content')
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <x-stat-card 
                    icon="iconly-boldShow" 
                    color="purple" 
                    title="Profile Views" 
                    value="112.000" 
                />
                <x-stat-card 
                    icon="iconly-boldProfile" 
                    color="blue" 
                    title="Followers" 
                    value="183.000" 
                />
                <x-stat-card 
                    icon="iconly-boldAdd-User" 
                    color="green" 
                    title="Following" 
                    value="80.000" 
                />
                <x-stat-card 
                    icon="iconly-boldBookmark" 
                    color="red" 
                    title="Saved Post" 
                    value="112" 
                />
            </div>
            <div class="row">
                <x-profile-visit-card />
            </div>
            <div class="row">
                <x-profile-visit-by-country-card />
                <x-recent-comments-card />
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <x-profile-card 
                avatar="/backend-assets/images/faces/1.jpg" 
                name="John Duck" 
                username="@johnducky" 
            />
            <x-recent-messages-card />
            <x-visitors-profile-card />
        </div>
    </section>
@endsection

@push('scripts')
    <script src="/backend-assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="/backend-assets/js/pages/dashboard.js"></script>
@endpush
