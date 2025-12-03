{{-- Baris untuk Kartu Statistik --}}
<div class="row">
    <div class="col-6 col-lg-3 col-md-6 mb-4">
        <a href="{{ route('backend.konten.index') }}" class="text-decoration-none card-hover">
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