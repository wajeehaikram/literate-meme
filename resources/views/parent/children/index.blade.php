<div class="child-card">
    <h3>{{ $child->name }}</h3>
    <p>Year {{ $child->year_group }}</p>
    <div class="subjects">
        @foreach($child->subjects as $subject => $examBoard)
            <span>{{ $subject }} ({{ $examBoard }})</span>
        @endforeach
    </div>
    <a href="{{ route('parent.children.edit', $child->id) }}" class="edit-button">Edit</a>
    <form action="{{ route('parent.children.destroy', $child->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this child?');">Delete</button>
    </form>
</div>