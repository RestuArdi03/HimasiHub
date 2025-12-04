{{-- resources/views/frontend/dashboard/_calendar.blade.php --}}

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
            width: max-content; /* Memastikan lebar tooltip sesuai konten */
            display: none; /* Sembunyikan secara default */
        }
        /* Perbaikan untuk header kalender agar tidak bergeser */
        .fc-header-toolbar.fc-toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 0.5em 0;
        }
        .fc-header-toolbar.fc-toolbar .fc-toolbar-chunk:nth-child(2) { /* Target elemen 'title' */
            order: -1; /* Pindahkan ke paling atas */
            width: 100%; /* Ambil lebar penuh untuk memaksa baris baru */
            text-align: center;
            margin-bottom: 0.75em; /* Jarak antara judul dan tombol */
        }
    </style>
@endpush

<!-- Calendar Start -->
<div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

{{-- Tooltip Element --}}
<div id="eventTooltip" class="event-tooltip"></div>
<!-- Calendar End -->


@push('scripts')
    {{-- JS untuk FullCalendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            if (calendarEl) { // Pastikan elemen kalender ada sebelum inisialisasi
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    locale: 'id',
                    events: '{{ route("kalender-kegiatan.events", ["context" => "frontend"]) }}',
                    
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