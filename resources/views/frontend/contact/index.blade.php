@extends('layouts.frontend')

@section('title', 'Kontak Kami - HimasiHub')

@section('content')
    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kontak Kami</h6>
                <h1 class="mb-5">Hubungi Kami Sesuai Keperluan Anda</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h5>Hubungi Kami</h5>
                    <p class="mb-4" style="text-align:justify">Halaman ini disediakan untuk Anda yang ingin terhubung dengan HIMASI UBSI Yogyakarta. Silakan kirim pertanyaan, saran, atau permintaan informasi melalui formulir email dan media sosial kami, atau bisa langsung datangi kami pada alamat yang tertera.</p>
                    <div class="d-flex align-items-center mb-3">
                        <a href="https://maps.app.goo.gl/MYNaBq3LUtDJ9ScbA" target="_blank">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                                <i class="bi bi-geo-alt-fill text-white"></i>
                            </div>
                        </a>
                        <div class="ms-3">
                            <h5 class="text-primary">Sekretariat</h5>
                            <p class="mb-0">UBSI Yogyakarta, Jl. Ringroad Barat, D.I.Y</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <a href="https://www.instagram.com/himasi_ubsiyogyakarta" target="_blank">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                                <i class="bi bi-instagram text-white"></i>
                            </div>
                        </a>
                        <div class="ms-3">
                            <h5 class="text-primary">Instagram</h5>
                            <p class="mb-0">@himasi_ubsiyogyakarta</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=himasi.yog@bsi.ac.id" target="_blank">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                                <i class="bi bi-envelope text-white"></i>
                            </div>
                        </a>    
                        <div class="ms-3">
                            <h5 class="text-primary">Email</h5>
                            <p class="mb-0">himasi.yog@bsi.ac.id</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <iframe class="position-relative rounded w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1013.9187064751442!2d110.32540408045921!3d-7.802309077120493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7af8015817dcb3%3A0x44265c0cf8f29b43!2sUniversitas%20Bina%20Sarana%20Informatika%20Kampus%20Yogyakarta%20(UBSI%20Yogyakarta)!5e0!3m2!1sid!2sid!4v1763960584679!5m2!1sid!2sid"
                        frameborder="0" style="min-height: 300px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
                <div class="col-lg-4 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nama" placeholder="Nama">
                                    <label for="nama">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subjek" placeholder="Subjek">
                                    <label for="subjek">Subjek</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Masukkan pesan" id="pesan" style="height: 150px"></textarea>
                                    <label for="pesan">Pesan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

{{-- Catatan: Layout yang digunakan adalah 'layouts.frontend', sesuai dengan file asli. --}}
