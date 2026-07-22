<x-app-layout>
  <x-slot name="header">
    <div class="text-white">
      <div class="font-extrabold text-2xl">Blog Mriki_Project</div>
      <div class="text-white/70 text-sm">Update berita terbaru (otomatis dari RSS)</div>
    </div>
  </x-slot>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
      @forelse($posts as $p)
        <a href="{{ $p->url }}" target="_blank"
           class="block rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition p-5">
          <div class="text-xs text-white/60 flex items-center gap-2">
            <span class="font-semibold text-white/80">{{ $p->source }}</span>
            <span>•</span>
            <span>{{ optional($p->published_at)->format('d M Y H:i') }}</span>
          </div>

          <div class="mt-2 font-extrabold text-white leading-snug">
            {{ $p->title }}
          </div>

          @if($p->excerpt)
            <p class="mt-2 text-sm text-white/75">
              {{ $p->excerpt }}
            </p>
          @endif

          <div class="mt-4 text-sm font-semibold text-[#00c7ff]">
            Baca sumber →
          </div>
        </a>
      @empty
        <div class="text-white/70">Belum ada berita. Jalankan: <b>php artisan news:fetch</b></div>
      @endforelse
    </div>

    <div class="mt-8">
      {{ $posts->links() }}
    </div>
  </div>
</x-app-layout>
