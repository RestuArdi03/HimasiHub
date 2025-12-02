{{-- resources/views/kegiatan/kalender.blade.php --}}
@extends('layouts.frontend') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Kalender Kegiatan')

@push('styles')
    {{-- CSS untuk FullCalendar (PENTING!) --}}
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
    <style>
        /* Styling sederhana untuk tooltip */
        .event-tooltip {
            position: absolute;
            z-index: 10001;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.875rem;
            display: none; /* Sembunyikan secara default */
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Kalender Kegiatan</h3>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>

{{-- Tooltip Element --}}
<div id="eventTooltip" class="event-tooltip"></div>
@endsection

@push('scripts')
    {{-- JS untuk FullCalendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const tooltip = document.getElementById('eventTooltip');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilan awal bulan
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: 'id', // Menggunakan bahasa Indonesia
                events: '{{ route("kegiatan.events") }}', // URL untuk mengambil data event
                
                // Event saat mouse masuk ke sebuah event
                eventMouseEnter: function(info) {
                    const props = info.event.extendedProps;
                    tooltip.innerHTML = `
                        <strong>${info.event.title}</strong><br>
                        Tipe: ${props.tipe || '-'}<br>
                        Tempat: ${props.tempat || '-'}
                    `;
                    tooltip.style.display = 'block';
                    document.body.appendChild(tooltip);
                },

                // Event untuk memposisikan tooltip
                eventMouseMove: function(info) {
                    tooltip.style.top = (info.jsEvent.pageY + 15) + 'px';
                    tooltip.style.left = (info.jsEvent.pageX + 15) + 'px';
                },

                // Event saat mouse keluar dari sebuah event
                eventMouseLeave: function(info) {
                    tooltip.style.display = 'none';
                },

                // Event saat event di-render
                eventDidMount: function(info) {
                    // Menambahkan kelas untuk styling jika diperlukan
                    info.el.classList.add('fc-event-custom');
                }
            });

            calendar.render();
        });
    </script>
@endpush
