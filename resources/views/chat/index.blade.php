<x-app-layout>
    <div class="max-w-3xl mx-auto">

        {{-- Tiêu đề --}}
        <h2 class="text-2xl font-bold mb-4 text-center">💬 Thảo luận chung</h2>

        {{-- Khung chat --}}
        <div id="chat-box"
             class="bg-white/60 backdrop-blur-xl shadow-md p-4 rounded-xl h-[520px] overflow-y-auto space-y-4 border">

            @foreach($messages as $message)
                <div class="message-wrapper flex items-start gap-2 
                    {{ $message->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">

                    {{-- Avatar --}}
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($message->user->name) }}&background=random"
                         class="w-10 h-10 rounded-full shadow" />

                    {{-- Bong bóng chat --}}
                    <div class="max-w-[70%]">
                        <div class="
                            message-bubble p-3 rounded-2xl shadow transition-all duration-300
                            hover:scale-[1.02] 
                            {{ $message->user_id === auth()->id() 
                                ? 'bg-pink-500 text-white rounded-br-none' 
                                : 'bg-gray-200 text-gray-900 rounded-bl-none' }}
                        ">
                            <p class="text-sm font-semibold">{{ $message->user->name }}</p>
                            <p class="mt-1">{{ $message->content }}</p>
                        </div>

                        <p class="text-xs text-gray-500 mt-1 
                            {{ $message->user_id === auth()->id() ? 'text-right' : '' }}">
                            {{ $message->created_at->format('H:i, d/m/Y') }}
                        </p>
                    </div>

                </div>
            @endforeach

            {{-- Hiệu ứng đang nhập --}}
            <div id="typing" class="hidden">
                <div class="flex gap-2 items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-300 animate-pulse"></div>
                    <div class="bg-gray-200 p-3 rounded-2xl text-gray-600">
                        <div class="flex gap-1">
                            <span class="dot dot1"></span>
                            <span class="dot dot2"></span>
                            <span class="dot dot3"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Form gửi tin nhắn --}}
        <form id="chat-form" action="{{ route('chat.store') }}" method="POST" class="mt-4 flex items-center gap-2">
            @csrf

            <input id="chat-input" type="text" name="content" placeholder="Nhập tin nhắn..."
                   class="flex-1 rounded-full p-3 border bg-white/70 backdrop-blur focus:ring-2 focus:ring-pink-400 shadow">

            <button type="submit" 
                    class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-full shadow-lg transition">
                Gửi
            </button>
        </form>
    </div>
</x-app-layout>

{{-- Hiệu ứng CSS --}}
<style>
    /* Hiệu ứng bong bóng trượt lên */
    .message-wrapper {
        opacity: 0;
        transform: translateY(10px);
        animation: slideUp 0.4s ease forwards;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hiệu ứng typing */
    .dot {
        width: 8px;
        height: 8px;
        background: gray;
        border-radius: 50%;
        display: inline-block;
        animation: bounce 1.4s infinite ease-in-out both;
    }

    .dot1 { animation-delay: -0.32s; }
    .dot2 { animation-delay: -0.16s; }

    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
</style>

{{-- Script hiện hiệu ứng đang nhập --}}
<script>
    const input = document.getElementById('chat-input');
    const typing = document.getElementById('typing');
    let typingTimer;

    input.addEventListener('input', () => {
        clearTimeout(typingTimer);
        typing.classList.remove('hidden');

        // Giả lập người đang nhập
        typingTimer = setTimeout(() => {
            typing.classList.add('hidden');
        }, 1200);
    });

    // Auto scroll xuống cuối
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
