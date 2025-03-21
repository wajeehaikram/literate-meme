@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">New Message</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="search-user">Search Recipient</label>
                        <input type="text" id="search-user" class="form-control" placeholder="Type name to search...">
                        <div id="search-results" class="list-group mt-2"></div>
                    </div>
                    
                    <form id="message-form" action="{{ route('messages.store') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="receiver_id" id="receiver_id">
                        <div class="form-group">
                            <label>To: <span id="recipient-name"></span></label>
                        </div>
                        <div class="form-group">
                            <label for="content">Message</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                            <a href="{{ route('messages.index') }}" class="btn btn-secondary">Cancel</a>
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
    const messageForm = document.getElementById('message-form');
    const receiverIdInput = document.getElementById('receiver_id');
    const recipientNameSpan = document.getElementById('recipient-name');
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
                        <a href="#" class="list-group-item list-group-item-action" 
                           data-user-id="${user.id}" 
                           data-user-name="${user.name}">
                            <div class="d-flex flex-column">
                                <strong>${user.name}</strong>
                                <small class="text-muted">${user.email}</small>
                            </div>
                        </a>
                    `).join('');

                    // Add click handlers to search results
                    searchResults.querySelectorAll('a').forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            const userId = this.dataset.userId;
                            const userName = this.dataset.userName;
                            
                            // Set the receiver ID and name
                            receiverIdInput.value = userId;
                            recipientNameSpan.textContent = userName;
                            
                            // Hide search results and show the message form
                            searchResults.innerHTML = '';
                            searchInput.value = '';
                            messageForm.style.display = 'block';
                        });
                    });
                });
        }, 300);
    });

    // Add keypress event listener for Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const query = this.value.trim();
            
            if (query.length >= 2) {
                fetch(`/messages/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(users => {
                        if (users.length > 0) {
                            // Automatically select the first user
                            const firstUser = users[0];
                            
                            // Set the receiver ID and name
                            receiverIdInput.value = firstUser.id;
                            recipientNameSpan.textContent = firstUser.name;
                            
                            // Hide search results and show the message form
                            searchResults.innerHTML = '';
                            searchInput.value = '';
                            messageForm.style.display = 'block';
                        } else {
                            searchResults.innerHTML = '<div class="list-group-item">No users found</div>';
                        }
                    });
            } else {
                searchResults.innerHTML = '';
            }
        }
    });
</script>
@endpush
@endsection