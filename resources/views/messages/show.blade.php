@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="input-group">
                        <input type="text" id="search-user" class="form-control" placeholder="Search users...">
                    </div>
                </div>
                <div class="list-group list-group-flush" id="search-results"></div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $otherUser->name }}</h5>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    <div class="messages">
                        @foreach($messages as $message)
                            <div class="message mb-3 {{ $message->sender_id === Auth::id() ? 'text-right' : '' }}">
                                <div class="message-content d-inline-block p-2 rounded {{ $message->sender_id === Auth::id() ? 'bg-primary text-white' : 'bg-light' }}">
                                    {{ $message->content }}
                                </div>
                                <div class="message-time small text-muted">
                                    {{ $message->created_at->format('M j, Y g:i A') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                        <div class="input-group">
                            <input type="text" name="content" class="form-control" placeholder="Type your message..." required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('search-user');
    const searchResults = document.getElementById('search-results');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.innerHTML = '';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/messages/search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(users => {
                    searchResults.innerHTML = users.map(user => `
                        <a href="/messages/${user.id}" class="list-group-item list-group-item-action">
                            ${user.name}
                        </a>
                    `).join('');
                });
        }, 300);
    });

    // Scroll to bottom of messages
    const messagesDiv = document.querySelector('.messages');
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
</script>
@endpush
@endsection