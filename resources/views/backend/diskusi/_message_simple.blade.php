{{--
    File ini adalah versi sederhana dari _messages.blade.php,
    dirancang untuk preview seperti di dashboard.
--}}
@props(['pesan'])

<div class="message-bubble {{ $pesan->users_id == Auth::id() ? 'sent' : 'received' }}">
    <div class="w-100">
        <div class="sender-name">{{ optional($pesan->user)->nama ?? 'Pengguna Dihapus' }}</div>
        <div class="sender-role">{{ optional(optional($pesan->user)->role)->nama_role ?? 'Mantan Anggota' }}</div>
        <div class="message-content mt-2">
            {!! nl2br(e(Str::limit($pesan->isi, 150))) !!}
        </div>
        <div class="message-time">
            {{ $pesan->created_at->diffForHumans() }}
        </div>
    </div>
</div>