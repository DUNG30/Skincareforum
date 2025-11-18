<div class="border p-2 rounded">
    <p class="text-sm text-gray-500">{{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}</p>
    <p>{{ $comment->content }}</p>

    <div class="flex items-center mt-2 space-x-3">
        <div class="relative">
            <button class="react-trigger-comment px-2 py-1 border rounded text-sm" data-comment-id="{{ $comment->id }}">React</button>
            <div class="react-palette-comment hidden absolute z-50 left-0 -top-12 bg-white dark:bg-gray-800 px-3 py-2 rounded shadow flex space-x-2">
                <button class="react-option-comment" data-type="like" data-comment-id="{{ $comment->id }}">👍</button>
                <button class="react-option-comment" data-type="love" data-comment-id="{{ $comment->id }}">❤️</button>
                <button class="react-option-comment" data-type="haha" data-comment-id="{{ $comment->id }}">😂</button>
                <button class="react-option-comment" data-type="wow" data-comment-id="{{ $comment->id }}">😮</button>
                <button class="react-option-comment" data-type="sad" data-comment-id="{{ $comment->id }}">😢</button>
                <button class="react-option-comment" data-type="angry" data-comment-id="{{ $comment->id }}">😡</button>
            </div>
        </div>

        <div class="text-sm text-gray-600" id="reaction-counts-comment-{{ $comment->id }}">
            @foreach ($comment->reactions->groupBy('type') as $type => $group)
                <span class="mr-2">{{ $type }}: {{ count($group) }}</span>
            @endforeach
        </div>
    </div>
</div>
