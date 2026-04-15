@extends('layouts.via')

@section('content')
<div class="flex flex-col sm:justify-center items-center pt-10 pb-16 sm:pt-16 bg-cream">
    <div>
        <a href="/" style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; font-weight: 600; color: var(--slate); text-decoration: none; letter-spacing: 0.1em;">
            VIA
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg" style="border: 1px solid var(--border); border-radius: var(--radius-lg);">
        {{ $slot }}
    </div>
</div>
@endsection
