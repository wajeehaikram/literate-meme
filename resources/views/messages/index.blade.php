@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="input-group">
                        <input type="text" id="search-user" class="form-control" placeholder="Search users...">
                    </div>
                    <a href="{{ route('messages.compose') }}" class="btn btn-primary btn-sm ml-2">New Message</a>
                </div>
                <div class="list-group list-group-flush" id="search-results"></div>
                <div class="list-group list-group-flush" id="conversations-list">
                    @foreach($conversations as $userId => $messages)
                        @php
                            $otherUser = $messages->first()->sender_id === Auth::id() 
                                ? $messages->first()->receiver 
                                : $messages->first()->sender;
                        @endphp
                        <a href="{{ route('messages.show', $otherUser->id) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-1">{{ $otherUser->name }}</h6>
                                <small>{{ $messages->first()->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 text-muted">{{ Str::limit($messages->first()->content, 50) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8" id="message-content">
            <div class="card">
                <div class="card-body text-center">
                    <p>Select a conversation or start a new one</p>
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
</script>
@endpush
@endsection