@push('styles')
    {{-- Style ini disalin dari diskusi/index.blade.php untuk tampilan bubble --}}
    <style>
        .message-bubble {
            display: flex;
            flex-direction: column;
            max-width: 100%; /* Dibuat 100% agar pas dengan card */
            margin-bottom: 0; /* Dihilangkan agar tidak ada margin bawah */
            padding: 1rem 1rem 0.5rem 1rem;
            border-radius: 1rem;
            position: relative;
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-bottom-left-radius: 0.25rem;
        }

        .message-bubble .sender-name {
            font-weight: bold;
            margin-bottom: 0rem;
            color: #0d6efd;
        }

        .sender-role {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.3rem;
        }

        .message-bubble .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            text-align: right;
            margin-top: 0.25rem;
        }

        .message-bubble .reply-to {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            background-color: rgba(0, 0, 0, 0.05);
            border-left: 3px solid #0d6efd;
            margin-bottom: 0.5rem;
            border-radius: 0.25rem;
        }

        .reply-to p {
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@if ($pesan_terakhir)
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Diskusi Terakhir</h4>
            </div>
            <div class="card-body" style="padding-bottom: 0.5rem;">
                <div id="last-discussion-content">
                    {{-- Konten akan di-load oleh JavaScript, tapi kita render sekali untuk tampilan awal --}}
                    @include('backend.diskusi._message_simple', ['pesan' => $pesan_terakhir])
                </div>
                <a href="{{ route('backend.diskusi.index') }}" class="btn btn-sm btn-outline-primary mt-3 mb-3">Lihat Semua Diskusi</a>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lastDiscussionContent = document.getElementById('last-discussion-content');

        // Hanya jalankan jika elemennya ada di halaman
        if (lastDiscussionContent) {
            // Fungsi untuk mengambil pesan terakhir
            const fetchLastMessage = () => {
                fetch('{{ route('backend.diskusi.fetch-latest') }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(html => {
                        if (html.trim() !== lastDiscussionContent.innerHTML.trim()) {
                            lastDiscussionContent.innerHTML = html;
                        }
                    })
                    .catch(error => console.error('Error fetching last message:', error));
            };

            // Panggil fungsi setiap 5 detik
            setInterval(fetchLastMessage, 5000);
        }
    });
</script>
@endpush