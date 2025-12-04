@extends('backend.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    {{-- CSS untuk FullCalendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
    {{-- CSS untuk efek hover pada card --}}
    <style>
        .card-hover:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, .05);
            transition: all .3s ease;
        }
        /* Styling untuk tooltip kalender */
        .event-tooltip {
            position: absolute;
            z-index: 10001;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.875rem;
            width: max-content; /* Memastikan lebar tooltip sesuai konten */
            display: none; /* Sembunyikan secara default */
        }
        /* Perbaikan untuk header kalender agar tidak bergeser */
        .fc-header-toolbar {
            display: flex;
            flex-direction: column;
        }
        .fc-header-toolbar .fc-toolbar-chunk:nth-child(2) {
            /* Pindahkan chunk kedua (tombol navigasi) ke bawah */
            order: 1;
        }
    </style>
@endpush

@section('page-heading', 'Ringkasan Sistem')

@section('content')
    {{-- Notifikasi --}}
    @include('backend.dashboard._alerts')
    
    <section class="row">
        <div class="col-12 col-lg-9">
            {{-- Baris untuk Kartu Statistik --}}
            @include('backend.dashboard._stat_cards')

            {{-- Baris untuk Kegiatan Terbaru dan Diskusi Terakhir --}}
            <div class="row">
                {{-- Kolom Kegiatan Terbaru --}}
                @include('backend.dashboard._recent_activities')

                {{-- Kolom Diskusi Terakhir --}}
                @include('backend.dashboard._last_discussion')
            </div>
        </div>
        <div class="col-12 col-lg-3">
            {{-- Kalender --}}
            @include('backend.dashboard._calendar')

            {{-- Backup & Restore --}}
            @include('backend.dashboard._backup')
        </div>
 
        {{-- Elemen Tooltip untuk Kalender (ditempatkan di luar grid utama) --}}
        <div id="eventTooltip" class="event-tooltip"></div>
    </section>

    @can('access-backup')
        {{-- Modals untuk Backup & Restore --}}
        @include('backend.dashboard._backup_modals')
    @endcan
@endsection

@push('scripts')
    {{-- JS untuk FullCalendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar-mini');
            const tooltip = document.getElementById('eventTooltip');

            if (calendarEl) {
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'title',
                        center: 'prev,next', // Letakkan tombol di tengah
                        right: '' // Kosongkan bagian kanan
                    },
                    footerToolbar: {
                        center: 'today'
                    },
                    locale: 'id',
                    height: 'auto',
                    events: '{{ route("kalender-kegiatan.events", ["context" => "backend"]) }}',

                    // --- Logika Tooltip ---
                    eventMouseEnter: function(info) {
                        const props = info.event.extendedProps;
                        const tooltipEl = document.getElementById('eventTooltip');

                        // 1. Isi konten tooltip dengan judul dan deskripsi (isi)
                        tooltipEl.innerHTML = `<strong>${info.event.title}</strong><br>${props.isi || ''}`;
                        tooltipEl.style.display = 'block';
                        tooltipEl.style.left = '-9999px'; // Pindahkan sementara ke luar layar

                        const eventRect = info.el.getBoundingClientRect();
                        const tooltipWidth = tooltipEl.offsetWidth;
                        const viewportWidth = window.innerWidth;

                        // 3. Tentukan posisi 'left' agar tidak keluar layar
                        let newLeft = eventRect.left + window.scrollX;
                        const rightEdge = newLeft + tooltipWidth;
                        const screenRightEdge = viewportWidth + window.scrollX;

                        if (rightEdge > screenRightEdge) {
                            // Jika meluap, geser tooltip ke kiri secukupnya agar pas di layar
                            newLeft -= (rightEdge - screenRightEdge) + 10; // +10 untuk sedikit padding
                        }

                        tooltipEl.style.left = `${newLeft}px`;
                        tooltipEl.style.top = `${eventRect.bottom + window.scrollY + 5}px`; // 5px di bawah acara
                    },
                    eventMouseLeave: function(info) {
                        const tooltipEl = document.getElementById('eventTooltip');
                        tooltipEl.style.display = 'none';
                    }
                });
                calendar.render();
            }
        });
    </script>
@endpush
