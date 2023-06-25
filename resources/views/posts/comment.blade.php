<form method="POST" action="{{ route('comments.store', $post) }}">
    @csrf
    <textarea name="body" required></textarea>
    <button type="submit">Comment</button>
</form>
