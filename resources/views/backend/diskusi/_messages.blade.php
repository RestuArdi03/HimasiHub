@forelse ($diskusi as $pesan)
    <div id="message-{{ $pesan->id }}"
        class="message-bubble {{ $pesan->users_id == Auth::id() ? 'sent' : 'received' }}"
        data-id="{{ $pesan->id }}" data-sender-name="{{ optional($pesan->user)->nama ?? 'Pengguna Dihapus' }}">
        <button class="btn btn-sm btn-outline-primary reply-hover-btn" title="Balas">&#x21A9;</button>
        <div class="w-100">
            <div class="sender-name">{{ optional($pesan->user)->nama ?? 'Pengguna Dihapus' }}</div>
            <div class="sender-role">{{ optional(optional($pesan->user)->role)->nama_role ?? 'Mantan Anggota' }}</div>

            @if ($pesan->parentMessage)
                <div class="reply-to" data-reply-to-id="{{ $pesan->parent_id }}">
                    <strong class="reply-to-user">{{ optional($pesan->parentMessage->user)->nama ?? 'Pengguna Dihapus' }}</strong>
                    <p class="reply-to-text">{{ Str::limit($pesan->parentMessage->isi, 50) }}</p>
                </div>
            @endif

            <div class="message-content">
                {!! nl2br(e($pesan->isi)) !!}
            </div>
            <div class="message-time">
                {{ $pesan->created_at->format('H:i') }}
                @if ($pesan->isEdited())
                    <small class="text-muted fst-italic">(edited)</small>
                @endif
            </div>
        </div>

        @canany(['update', 'delete'], $pesan)
            <div class="message-actions">
                <div class="dropdown position-relative">
                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @php
                            $isEditable = now()->diffInMinutes($pesan->created_at) < 5;
                        @endphp
                        @if ($isEditable)
                            @can('update', $pesan)
                                <li><a class="dropdown-item edit-btn" href="#" data-id="{{ $pesan->id }}">Edit</a></li>
                            @endcan
                            @can('delete', $pesan)
                                <li><a class="dropdown-item delete-btn" href="#" data-id="{{ $pesan->id }}">Hapus</a></li>
                            @endcan
                        @else
                            @can('update', $pesan)
                                <li><a class="dropdown-item disabled" href="#" aria-disabled="true">Edit (lewat waktu)</a></li>
                            @endcan
                            @can('delete', $pesan)
                                <li><a class="dropdown-item disabled" href="#" aria-disabled="true">Hapus (lewat waktu)</a></li>
                            @endcan
                        @endif
                    </ul>
                </div>
            </div>
        @endcanany
    </div>
@empty
    <div class="text-center text-muted">
        Belum ada pesan. Mulai percakapan!
    </div>
@endforelse