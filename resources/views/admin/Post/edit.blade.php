@extends('admin.layout')

@section('content')
<h2>Edit Post</h2>

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
    </div>
    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if($category->id == $post->category_id) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Content</label>
        <textarea name="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
