@extends('backend.layouts.app')

@section('title', 'Dashboard')

@push('styles')
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
        .fc .fc-toolbar.fc-header-toolbar {
            display: grid;
            grid-template-columns: auto 1fr auto;
            padding: 0 1rem; /* Menambahkan sedikit padding agar tidak terlalu mepet */
        }
    </style>
@endpush

@section('page-heading', 'Ringkasan Sistem')

@section('content')
    <section class="row">
        <div class="col-12 col-lg-9">
            {{-- Baris untuk Kartu Statistik --}}
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <a href="{{ route('backend.konten.index') }}" class="text-decoration-none">
                        <x-stat-card
                            icon="bi-newspaper"
                            color="blue"
                            title="Total Berita"
                            :value="$total_posts"
                        />
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <a href="{{ route('backend.notulen.index') }}" class="text-decoration-none card-hover">
                        <x-stat-card
                            icon="bi-calendar-event"
                            color="purple"
                            title="Total Kegiatan"
                            :value="$total_kegiatan"
                        />
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <a href="{{ route('backend.user.index') }}" class="text-decoration-none card-hover">
                        <x-stat-card
                            icon="bi-people-fill"
                            color="green"
                            title="Pengguna Terdaftar"
                            :value="$total_users"
                        />
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <a href="{{ route('backend.pesan.index') }}" class="text-decoration-none card-hover">
                        <x-stat-card
                            icon="bi-envelope"
                            color="red"
                            title="Pesan Masuk"
                            :value="$total_pesan"
                        />
                    </a>
                </div>
                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <a href="{{ route('backend.saldo.index') }}" class="text-decoration-none card-hover">
                        <x-stat-card
                            icon="bi-wallet2"
                            color="orange"
                            title="Total Saldo"
                            :value="'Rp ' . number_format($total_saldo, 0, ',', '.')"
                        />
                    </a>
                </div>
            </div>

            {{-- Baris untuk Kegiatan Terbaru dan Diskusi Terakhir --}}
            <div class="row">
                {{-- Kolom Kegiatan Terbaru --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kegiatan Terbaru</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Nama Kegiatan</th>
                                            <th>Tanggal Mulai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($kegiatan_terbaru as $kegiatan)
                                            <tr>
                                                <td class="col-auto">
                                                    <p class="font-bold ms-3 mb-0">{{ $kegiatan->nama }}</p>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">{{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('d F Y') }}</p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">Belum ada kegiatan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Diskusi Terakhir --}}
                @if ($pesan_terakhir)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Diskusi Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <div class="message-bubble received">
                                    <div class="w-100">
                                        <div class="sender-name">{{ optional($pesan_terakhir->user)->nama ?? 'Pengguna Dihapus' }}</div>
                                        <div class="sender-role">{{ optional(optional($pesan_terakhir->user)->role)->nama_role ?? 'Mantan Anggota' }}</div>
                                        <div class="message-content mt-2">
                                            {!! nl2br(e(Str::limit($pesan_terakhir->isi, 150))) !!}
                                        </div>
                                        <div class="message-time">
                                            {{ $pesan_terakhir->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('backend.diskusi.index') }}" class="btn btn-sm btn-outline-primary mt-3">Lihat Diskusi</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Kalender Kegiatan</h4>
                </div>
                <div class="card-body">
                    <div id="calendar-mini"></div>
                </div>
            </div>

            @can('access-backup') {{-- Direktif Blade untuk kontrol akses --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Database</h5>
                </div>
                <div class="card-body">
                    <p>Backup atau restore seluruh data aplikasi.</p>
                    <button class="btn btn-success w-100 mb-2">
                        <i class="bi bi-download"></i> Backup
                    </button>
                    <button class="btn btn-danger w-100">
                        <i class="bi bi-upload"></i> Restore
                    </button>
                </div>
            </div>
            @endcan
        </div>

        {{-- Elemen Tooltip untuk Kalender (ditempatkan di luar grid utama) --}}
        <div id="eventTooltip" class="event-tooltip"></div>
    </section>
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
                        left: 'prev',
                        center: 'title',
                        right: 'next',
                    },
                    footerToolbar: {
                        center: 'today'
                    },
                    locale: 'id',
                    height: 'auto',
                    events: '{{ route("kegiatan.events") }}', // Menggunakan route yang sama dengan frontend

                    // --- Logika Tooltip ---
                    eventMouseEnter: function(info) {
                        const props = info.event.extendedProps;
                        const tooltipEl = document.getElementById('eventTooltip');

                        // 1. Isi konten tooltip dan buat visibel (tapi di luar layar) untuk mengukur lebarnya
                        tooltipEl.innerHTML = `<strong>${info.event.title}</strong><br>Tipe: ${props.tipe || '-'}<br>Tempat: ${props.tempat || '-'}`;
                        tooltipEl.style.display = 'block';
                        tooltipEl.style.left = '-9999px'; // Pindahkan sementara ke luar layar

                        // 2. Dapatkan posisi acara dan lebar tooltip/viewport
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
