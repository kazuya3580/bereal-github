<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Create a Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <h1>Create a New Post</h1>

    <form method="POST" action="/posts">
        @csrf

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="body">Body:</label>
        <textarea id="body" name="body" required></textarea>

        <button type="submit">Create</button>
    </form>
</body>
</html>
