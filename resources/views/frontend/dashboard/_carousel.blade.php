<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        @forelse ($carouselKonten as $item)
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ Str::startsWith($item->gambar, 'http') ? $item->gambar : Storage::url($item->gambar) }}" alt="{{ $item->judul }}" style="object-fit: cover; height: 100vh;">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Publikasi Terbaru</h5>
                                <h1 class="display-3 text-white animated slideInDown">{{ Str::limit($item->judul, 50) }}</h1>
                                <p class="fs-5 text-white mb-4 pb-2">{!! Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 100) !!}</p>
                                <a href="{{ route('frontend.konten.show', $item->slug) }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Tampilan fallback jika tidak ada konten --}}
        @endforelse
    </div>
</div>
<!-- Carousel End -->