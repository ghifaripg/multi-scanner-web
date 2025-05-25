@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="text-center">
        {{-- Tentukan ikon berdasarkan status --}}
        <img src="{{ asset(
            $status === 'safe' ? 'images/SafeIcon.png' :
            ($status === 'suspicious' ? 'images/SuspiciousIcon.png' : 'images/NotSafeIcon.png')
        ) }}" class="mx-auto w-24 h-24 mb-4" alt="Status Icon">
        
        {{-- Judul Status --}}
        <h1 class="text-3xl font-bold text-gray-800">
            {{ $status === 'safe' ? 'Safe!' : ($status === 'suspicious' ? 'Suspicious!' : 'Not Safe!') }}
        </h1>

        {{-- Deskripsi Status --}}
        <p class="mt-2 text-gray-600">
            {{ $status === 'safe' 
                ? 'No threats or suspicious activities were detected. The scanned input appears to be safe.' 
                : ($status === 'suspicious'
                    ? 'Some potentially harmful indicators were found. It is advised to proceed with caution and conduct further inspection.'
                    : 'Potential threats were detected. It is recommended not to proceed with this file/link/email without further review.') 
            }}
        </p>

        {{-- Tombol Navigasi --}}
        <div class="mt-6 flex justify-center gap-4">
            <a href="{{ url()->previous() }}" class="bg-blue-900 text-white px-4 py-2 rounded-full shadow hover:bg-blue-800">← Back</a>
            <button onclick="openCommentModal()" class="bg-orange-500 text-white px-4 py-2 rounded-full shadow hover:bg-orange-600">Comment</button>
            <a href="{{ route('result.full') }}" class="bg-orange-500 text-white px-4 py-2 rounded-full shadow hover:bg-orange-600">Full Report</a>
        </div>
    </div>

    {{-- Komentar Dummy --}}
    <div class="mt-10">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Comments</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-lg shadow p-4 flex gap-3 items-start">
                    <img src="https://i.pravatar.cc/40?img={{ $i + 1 }}" alt="User" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-gray-600 text-sm">
                            I have used this and it works fine. Just be cautious. Great app.
                        </p>
                        <p class="mt-2 text-xs text-gray-400">– John Doe</p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

@include('partials.comment-modal')

<script>
    function openCommentModal() {
        document.getElementById('commentModal').classList.remove('hidden');
    }
</script>
@endsection