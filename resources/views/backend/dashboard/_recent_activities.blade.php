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