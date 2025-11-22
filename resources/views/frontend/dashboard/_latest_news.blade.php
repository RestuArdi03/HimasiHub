<!-- Latest News Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Publikasi</h6>
            <h1 class="mb-5">Berita & Artikel Terbaru</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse ($latestNews as $news)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light h-100 d-flex flex-column">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ Str::startsWith($news->gambar, 'http') ? $news->gambar : Storage::url($news->gambar) }}" alt="{{ $news->judul }}" style="height: 250px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="text-center p-4 pb-0 flex-grow-1">
                            <h5 class="mb-4">{{ \Illuminate\Support\Str::limit($news->judul, 55) }}</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $news->created_at->format('d M Y') }}</small>
                            <small class="flex-fill text-center py-2"><a href="{{ route('frontend.konten.show', $news->slug) }}">Baca Selengkapnya</a></small>
                        </div>
                    </div>
                </div>
                
            @empty
                <div class="col-12 text-center">
                    <p>Belum ada berita untuk ditampilkan.</p>
                </div>
            @endforelse
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('frontend.konten.index') }}" class="btn btn-primary py-3 px-5 wow fadeInUp" data-wow-delay="0.1s">Lihat Lebih Banyak</a>
            </div>
        </div>
    </div>
</div>
<!-- Latest News End -->