@php
  $safe = function ($name) {
    return \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';
  };
@endphp

<nav x-data="{ open: false }" class="relative z-50 bg-[#14192b] border-b border-white/5 text-white">
    
    {{-- BACKGROUND COSMIC & BINTANG (Tema Menyatu dengan Dashboard #050a1e) --}}
    <div class="absolute inset-0 z-0 bg-gradient-to-r from-[#121629] via-[#1a223c] to-[#121629]"></div>
    <div class="absolute inset-0 z-0 opacity-30"
         style="background-image: radial-gradient(circle at 20% 30%, rgba(0,199,255,.35) 0 2px, transparent 3px),
                                radial-gradient(circle at 70% 40%, rgba(0,199,255,.25) 0 2px, transparent 3px),
                                radial-gradient(circle at 40% 70%, rgba(255,255,255,.15) 0 1px, transparent 2px);
                background-size: 220px 220px;"></div>

    <!-- Primary Navigation Menu -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center relative">
            
            <!-- LEFT: Logo & Brand -->
            <div class="shrink-0 flex items-center z-10">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('img/logo.png') }}" class="block h-12 w-auto" alt="Logo" />
                    <div class="hidden sm:block leading-tight text-left">
                        <div class="font-extrabold text-white tracking-wide">Mriki</div>
                        <div class="text-xs text-white/70 -mt-0.5">Project</div>
                    </div>
                </a>
            </div>

            <!-- CENTER: Navigation Menu Links (Desktop Only) -->
            <div class="hidden sm:flex absolute left-1/2 -translate-x-1/2 items-center space-x-8 z-10">
                <!-- Dashboard Link -->
                <a href="{{ route('dashboard') }}" 
                   class="text-xs font-bold tracking-widest uppercase text-white/85 hover:text-white transition relative after:content-[''] after:absolute after:left-0 after:-bottom-3 after:h-[2px] {{ request()->routeIs('dashboard') ? 'after:w-full after:bg-[#00c7ff]' : 'after:w-0 after:bg-[#00c7ff] hover:after:w-full after:transition-all' }}">
                    Dashboard
                </a>

                @auth
                    <!-- Diskusi Link -->
                    <a href="{{ route('diskusi.index') }}" 
                       class="text-xs font-bold tracking-widest uppercase text-white/85 hover:text-white transition relative flex items-center gap-1.5 after:content-[''] after:absolute after:left-0 after:-bottom-3 after:h-[2px] {{ request()->routeIs('diskusi.index') ? 'after:w-full after:bg-[#00c7ff]' : 'after:w-0 after:bg-[#00c7ff] hover:after:w-full after:transition-all' }}">
                        <span>Diskusi</span>
                        @php
                            $userUnreadCount = \App\Models\DiscussionMessage::whereHas('discussion', function($q) {
                                $q->where('user_id', auth()->id());
                            })->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
                        @endphp
                        <span class="user-unread-badge bg-[#e53637] text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-full leading-none" style="{{ $userUnreadCount > 0 ? '' : 'display: none;' }}">
                            {{ $userUnreadCount }}
                        </span>
                    </a>
                @endauth

                <!-- Dropdown Daftar Layanan (Dark Cosmic Style) -->
                <div class="relative" x-data="{ layananOpen: false }" @click.outside="layananOpen = false">
                    <button @click="layananOpen = !layananOpen" 
                            class="inline-flex items-center gap-2 text-xs font-bold tracking-widest uppercase text-white/85 hover:text-white transition focus:outline-none">
                        <div>Daftar Layanan</div>
                        <svg class="fill-current h-4 w-4 text-white/70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="layananOpen" x-transition
                         class="absolute left-1/2 -translate-x-1/2 mt-4 w-60 rounded-lg border border-white/10 bg-[#1c233a]/95 backdrop-blur-md shadow-2xl overflow-hidden z-[99999]"
                         style="display:none">
                        <a href="{{ $safe('booking.drone') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-wider text-white/85 hover:bg-white/10 hover:text-white transition">
                            Booking Jasa Drone
                        </a>
                        <a href="{{ $safe('booking.crews') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-wider text-white/85 hover:bg-white/10 hover:text-white transition">
                            Photographer / Videographer
                        </a>
                        <a href="{{ $safe('servis.drone') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-wider text-white/85 hover:bg-white/10 hover:text-white transition">
                            Servis Unit Drone
                        </a>
                        <a href="{{ $safe('order.drone') }}" class="block px-4 py-3 text-xs font-bold uppercase tracking-wider text-white/85 hover:bg-white/10 hover:text-white transition">
                            Order Unit Drone
                        </a>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Profile Dropdown & Mobile Hamburger -->
            <div class="flex items-center gap-4 z-10">
                <!-- Settings Dropdown (Desktop Only) -->
                <div class="hidden sm:flex sm:items-center">
                    @auth
                        <div class="relative" x-data="{ userOpen: false }" @click.outside="userOpen = false">
                            <button @click="userOpen = !userOpen" 
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-white/10 bg-white/5 hover:bg-white/10 transition text-white focus:outline-none">
                                <div class="w-8 h-8 rounded bg-white/10 text-white flex items-center justify-center font-extrabold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 text-white/70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="userOpen" x-transition
                                 class="absolute right-0 mt-3 w-48 rounded-lg border border-white/10 bg-[#1c233a]/95 backdrop-blur-md shadow-2xl overflow-hidden z-[99999]"
                                 style="display:none">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm font-semibold text-white/85 hover:bg-white/10 hover:text-white transition">
                                    Profile
                                </a>

                                <div class="h-px bg-white/10"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-red-300 hover:bg-red-500/10 transition">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Hamburger (Mobile Only) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/5 focus:outline-none transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/10 bg-[#121629]/95 backdrop-blur-md relative z-50">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" 
               class="block py-2 text-sm font-bold tracking-widest uppercase {{ request()->routeIs('dashboard') ? 'text-[#00c7ff]' : 'text-white/85 hover:text-white' }}">
                Dashboard
            </a>

            @auth
                @php
                    $userUnreadCount = \App\Models\DiscussionMessage::whereHas('discussion', function($q) {
                        $q->where('user_id', auth()->id());
                    })->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
                @endphp
                <a href="{{ route('diskusi.index') }}" 
                   class="flex items-center justify-between py-2 text-sm font-bold tracking-widest uppercase {{ request()->routeIs('diskusi.index') ? 'text-[#00c7ff]' : 'text-white/85 hover:text-white' }}">
                    <span>Diskusi</span>
                    <span class="user-unread-badge bg-[#e53637] text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full leading-none" style="{{ $userUnreadCount > 0 ? '' : 'display: none;' }}">
                        {{ $userUnreadCount }}
                    </span>
                </a>
            @endauth

            <!-- Responsive Layanan -->
            <div class="border-t border-white/10 pt-2 pb-1" x-data="{ layananMobile: false }">
                <button @click="layananMobile = !layananMobile" class="w-full flex items-center justify-between py-2 text-sm font-bold tracking-widest uppercase text-white/85 hover:text-white focus:outline-none">
                    <span>Daftar Layanan</span>
                    <svg class="w-4 h-4 text-white/70" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div x-show="layananMobile" class="mt-1 pl-4 space-y-1" style="display:none">
                    <a href="{{ $safe('booking.drone') }}" class="block py-2 text-sm text-white/70 hover:text-white">
                        Booking Jasa Drone
                    </a>
                    <a href="{{ $safe('booking.crews') }}" class="block py-2 text-sm text-white/70 hover:text-white">
                        Booking Photographer / Videographer
                    </a>
                    <a href="{{ $safe('servis.drone') }}" class="block py-2 text-sm text-white/70 hover:text-white">
                        Servis Unit Drone
                    </a>
                    <a href="{{ $safe('order.drone') }}" class="block py-2 text-sm text-white/70 hover:text-white">
                        Order Unit Drone
                    </a>
                </div>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-white/10 px-4">
            @auth
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white/60">{{ Auth::user()->email }}</div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block py-2 text-sm text-white/70 hover:text-white">
                        Profile
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-sm text-red-400 hover:text-red-300">
                            Log Out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

@auth
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const unreadBadges = document.querySelectorAll('.user-unread-badge');
        const floatingUnreadBadge = document.querySelector('.floating-unread-badge');

        function checkUnreadMessages() {
            fetch("{{ route('diskusi.unread-by-category') }}")
                .then(response => response.json())
                .then(data => {
                    // Sum all categories unread count for global badge
                    const globalCount = Object.values(data).reduce((a, b) => a + b, 0);

                    unreadBadges.forEach(badge => {
                        if (globalCount > 0) {
                            badge.textContent = globalCount;
                            badge.style.display = 'inline-flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    });

                    if (floatingUnreadBadge) {
                        const serviceType = floatingUnreadBadge.getAttribute('data-service-type');
                        const count = serviceType ? (data[serviceType] || 0) : globalCount;

                        if (count > 0) {
                            floatingUnreadBadge.textContent = count;
                            floatingUnreadBadge.style.display = 'flex';
                            floatingUnreadBadge.classList.add('animate-bounce');
                        } else {
                            floatingUnreadBadge.style.display = 'none';
                            floatingUnreadBadge.classList.remove('animate-bounce');
                        }
                    }
                })
                .catch(err => console.error("Error fetching unread count:", err));
        }

        // Check unread count on page load, and then every 4 seconds
        checkUnreadMessages();
        setInterval(checkUnreadMessages, 4000);
    });
</script>
@endauth