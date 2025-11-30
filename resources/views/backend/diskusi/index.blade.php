@extends('backend.layouts.app')

@section('title', 'Grup Diskusi')

@push('styles')
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 75vh;
            border: 1px solid #dee2e6;
            border-radius: .375rem;
            overflow: hidden;
        }

        .chat-messages {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding: 1rem;
            background-color: #f8f9fa;
        }

        .message-bubble {
            display: flex;
            flex-direction: column;
            max-width: 70%;
            margin-bottom: 1rem;
            padding: 1rem 2.5rem 0.5rem 1rem;
            border-radius: 1rem;
            position: relative;
        }

        .message-bubble.sent {
            align-self: flex-end;
            background-color: #dcf8c6;
            border-bottom-right-radius: 0.25rem;
        }

        .message-bubble.received {
            align-self: flex-start;
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-bottom-left-radius: 0.25rem;
        }

        .message-bubble .sender-name {
            font-weight: bold;
            margin-bottom: 0rem;
            color: #0d6efd;
        }

        .message-bubble.sent .sender-name {
            color: #2a5b3a; /* Warna nama pengirim untuk pesan terkirim */
        }

        .sender-role {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.3rem;
        }

        /* Menyesuaikan tombol aksi pada bubble terkirim */
        .message-bubble.sent .message-actions .btn {
            background-color: #dcf8c6; /* Warna sama dengan bubble */
            border-color: transparent;
        }

        .message-bubble.sent .message-actions .btn:hover {
            background-color: #c8e8b6; /* Warna sedikit lebih gelap saat hover */
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

        .reply-to {
            cursor: pointer;
        }

        .reply-hover-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .message-bubble:hover .reply-hover-btn {
            opacity: 1;
        }

        .message-bubble.sent .reply-hover-btn {
            left: -40px;
        }

        .message-bubble.received .reply-hover-btn {
            right: -40px;
        }

        .message-actions {
            display: block;
            position: absolute;
            top: 0;
            right: 0.5rem;
        }

        .chat-form {
            padding: 1rem;
            background-color: #fff;
            border-top: 1px solid #dee2e6;
        }

        #reply-info {
            display: none;
            padding: 0.5rem;
            position: relative;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }

        #reply-info .btn-close, #edit-info .btn-close {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }

        #edit-info {
            display: none;
            padding: 0.5rem;
            background-color: #fff3cd;
            margin-bottom: 0.5rem;
        }

        .message-highlight {
            animation: highlight-animation 1.5s ease-out;
        }

        @keyframes highlight-animation {
            0% { background-color: #fff3cd; }
            100% { background-color: inherit; }
        }

    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Grup Diskusi</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="chat-container">
                    <div class="chat-messages" id="chat-messages">
                        @include('backend.diskusi._messages', ['diskusi' => $diskusi])
                    </div>
                    <div class="chat-form">
                        <div id="edit-info">
                            <small>Mengedit pesan:</small>
                            <p id="edit-text" class="mb-0 me-4"></p>
                            <button type="button" class="btn-close btn-sm" aria-label="Close" id="cancel-edit" title="Batal Edit"></button>
                        </div>
                        <div id="reply-info">
                            <small>Membalas kepada: <strong id="reply-user"></strong></small>
                            <p id="reply-text" class="mb-0 me-4"></p><button type="button" class="btn-close btn-sm"
                                aria-label="Close" id="cancel-reply" title="Batal Balas"></button>
                        </div>
                        <form id="chat-form" action="{{ route('backend.diskusi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" id="parent_id">
                            <input type="hidden" name="_method" id="method-input" value="POST">
                            <div class="input-group">
                                <input type="text" name="isi" id="message-input" class="form-control" placeholder="Ketik pesan..." autocomplete="off" required>
                                <button class="btn btn-primary" type="submit">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pesan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const parentIdInput = document.getElementById('parent_id');
            const methodInput = document.getElementById('method-input');
            const replyInfo = document.getElementById('reply-info');
            const editInfo = document.getElementById('edit-info');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            let deleteUrl = '';
            let openDropdownMessageId = null;

            // Scroll to bottom
            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            scrollToBottom();

            // Fetch new messages every 3 seconds
            setInterval(function() {
                fetch('{{ route('backend.diskusi.fetch') }}')
                    .then(response => response.text())
                    .then(html => {
                        const currentScrollTop = chatMessages.scrollTop;
                        const maxScrollTop = chatMessages.scrollHeight - chatMessages.clientHeight;
                        const isScrolledToBottom = currentScrollTop >= maxScrollTop - 10; // 10px tolerance

                        chatMessages.innerHTML = html;

                        if (isScrolledToBottom) {
                            scrollToBottom();
                        }

                        // Re-open dropdown if it was open before the fetch
                        if (openDropdownMessageId) {
                            const dropdownToggle = document.querySelector(`#message-${openDropdownMessageId} [data-bs-toggle="dropdown"]`);
                            if (dropdownToggle) {
                                // Use a short timeout to allow the DOM to render before showing the dropdown
                                // This fixes the positioning issue on auto-reopen.
                                setTimeout(() => {
                                    new bootstrap.Dropdown(dropdownToggle).show();
                                }, 0);
                            }
                        }
                    });
            }, 3000);

            // Handle form submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        resetForm();
                        // The new message will appear on the next fetch
                    })
                    .catch(error => console.error('Error:', error));
            });

            // Cancel reply
            document.getElementById('cancel-reply').addEventListener('click', cancelReply);

            // Event delegation for actions
            chatMessages.addEventListener('click', function(e) {
                const messageBubble = e.target.closest('.message-bubble');
                const isActionClick = e.target.closest('.message-actions') || e.target.closest('a');
                const replyPreview = e.target.closest('.reply-to');

                // Handle click on reply hover button
                if (e.target.matches('.reply-hover-btn')) {
                    const messageId = messageBubble.dataset.id;
                    const senderName = messageBubble.dataset.senderName;
                    const text = messageBubble.querySelector('.message-content').textContent.trim();

                    resetForm(); // Reset if in edit mode
                    parentIdInput.value = messageId;
                    document.getElementById('reply-user').textContent = senderName;
                    document.getElementById('reply-text').textContent = text;
                    replyInfo.style.display = 'block';
                    messageInput.focus();
                }

                // Handle click on reply preview to scroll to original message
                if (replyPreview) {
                    const originalMessageId = replyPreview.dataset.replyToId;
                    const originalMessage = document.getElementById(`message-${originalMessageId}`);
                    if (originalMessage) {
                        originalMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        
                        // Add highlight effect
                        originalMessage.classList.add('message-highlight');
                        setTimeout(() => {
                            originalMessage.classList.remove('message-highlight');
                        }, 1500); // Duration of the animation
                    }
                }
                // Edit button
                if (e.target && e.target.matches('.edit-btn')) {
                    const messageId = e.target.dataset.id;
                    const messageBubble = document.getElementById(`message-${messageId}`)
                    const text = messageBubble.querySelector('.message-content').textContent.trim();

                    // Set form to edit mode
                    chatForm.action = `{{ url('backend/diskusi') }}/${messageId}`;
                    methodInput.value = 'PUT';
                    messageInput.value = text;
                    document.getElementById('edit-text').textContent = text;
                    editInfo.style.display = 'block';
                    cancelReply(); // Hide reply info if it was open
                    messageInput.focus();
                }

                // Delete button
                if (e.target && e.target.matches('.delete-btn')) {
                    deleteUrl = `{{ url('backend/diskusi') }}/${e.target.dataset.id}`;
                    deleteModal.show();
                }
            });

            // Pause fetching when action menu is open
            chatMessages.addEventListener('show.bs.dropdown', function (event) {
                const messageBubble = event.target.closest('.message-bubble');
                if (messageBubble) {
                    openDropdownMessageId = messageBubble.dataset.id;
                }
            });

            // Resume fetching when action menu is closed
            chatMessages.addEventListener('hide.bs.dropdown', function (event) {
                // Set a brief timeout to avoid race condition with click events
                setTimeout(() => {
                    openDropdownMessageId = null;
                }, 50);
            });

            function cancelReply() {
                parentIdInput.value = '';
                replyInfo.style.display = 'none';
            }

            // Cancel edit
            document.getElementById('cancel-edit').addEventListener('click', resetForm);

            function resetForm() {
                chatForm.action = '{{ route('backend.diskusi.store') }}';
                methodInput.value = 'POST';
                messageInput.value = '';
                editInfo.style.display = 'none';
                cancelReply();
            }

            // Handle delete confirmation
            document.getElementById('confirm-delete').addEventListener('click', function() {
                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(() => deleteModal.hide());
            });
        });
    </script>
@endpush