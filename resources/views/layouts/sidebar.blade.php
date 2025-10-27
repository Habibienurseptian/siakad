<aside class="fixed inset-y-0 left-0 w-64 h-screen bg-white border-r border-gray-200 overflow-y-auto flex flex-col">
    
    <!-- Logo Header -->
    <header class="p-5 border-b border-gray-100">
        <a href="#" class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <span class="text-lg font-bold text-gray-900">Sekolah App</span>
        </a>
    </header>

    <!-- User Profile Section -->
    <div class="p-4">
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-4">
            @php
                $role = Auth::user()->role ?? 'guest';
                $profileImage = null;
                if ($role === 'murid') {
                    $murid = \App\Models\Murid::where('user_id', Auth::id())->first();
                    if ($murid && $murid->profile_image) {
                        $profileImage = asset('storage/' . $murid->profile_image);
                    }
                } elseif ($role === 'guru') {
                    $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                    if ($guru && $guru->profile_image) {
                        $profileImage = asset('storage/' . $guru->profile_image);
                    }
                }
            @endphp
            
            <div class="flex items-center space-x-3">
                <img src="{{ $profileImage ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'User') . '&background=10B981&color=fff' }}"
                    alt="Profile"
                    class="w-12 h-12 rounded-xl border-2 border-white shadow-sm object-cover">
                
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Pengguna' }}</h4>
                    @php
                        $role = Auth::user()->role ?? 'guest';
                        $murid = null;
                        $guru = null;
                        $staf = null;

                        if ($role === 'murid') {
                            $murid = \App\Models\Murid::where('user_id', Auth::id())->first();
                        } elseif ($role === 'guru') {
                            $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                        } elseif ($role === 'staf') {
                            $staf = \App\Models\Staf::where('user_id', Auth::id())->first();
                        }
                    @endphp

                    @if($role === 'murid' && $murid)
                        <p class="text-xs text-gray-600 truncate">{{ strtoupper($murid->kelas->nama_kelas ?? '-') }} | {{ $murid->nomor_induk ?? '-' }}</p>
                    @elseif($role === 'guru' && $guru)
                        <p class="text-xs text-gray-600">Guru | {{ $guru->nip ?? '-' }}</p>
                    @elseif($role === 'staf' && $staf)
                        <p class="text-xs text-gray-600">{{ $staf->bidang ? $staf->bidang : 'Staf' }} | {{ $staf->nip ?? '-' }}</p>
                    @else
                        <p class="text-xs text-gray-600">{{ ucfirst($role) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-2 space-y-1">
        @php $role = Auth::user()->role ?? 'guest'; @endphp

        @switch($role)
            @case('admin')
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.sekolah.index') }}" 
                   class="nav-link {{ request()->is('admin/sekolah*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Data Sekolah</span>
                </a>
                <a href="{{ route('admin.murid.index') }}" 
                   class="nav-link {{ request()->is('admin/murid*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Data Siswa</span>
                </a>
                <a href="{{ route('admin.guru.index') }}" 
                   class="nav-link {{ request()->is('admin/guru*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Data Guru</span>
                </a>
                <a href="{{ route('admin.staf.index') }}" 
                   class="nav-link {{ request()->is('admin/staf*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Data Staf</span>
                </a>
            @break

            @case('staf')
                @php
                    $staf = \App\Models\Staf::where('user_id', Auth::id())->first();
                    $bidang = strtolower(trim($staf->bidang ?? ''));
                @endphp

                <a href="{{ route('staf.dashboard') }}" 
                   class="nav-link {{ request()->is('staf/dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                @if(Str::contains($bidang, 'keu') || $bidang === 'keuangan')
                    <a href="{{ route('staf.keuangan.index') }}" 
                       class="nav-link {{ request()->is('staf/keuangan*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Keuangan</span>
                    </a>
                    <a href="{{ route('staf.pembayaran.index') }}" 
                       class="nav-link {{ request()->is('staf/pembayaran*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Pembayaran</span>
                    </a>
                @elseif(Str::contains($bidang, 'akad') || $bidang === 'akademik')
                    <a href="{{ route('staf.jadwal.index') }}" 
                       class="nav-link {{ request()->is('staf/jadwal*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('staf.pengumuman.index') }}" 
                       class="nav-link {{ request()->is('staf/pengumuman*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        <span>Pengumuman</span>
                    </a>
                @else
                    <!-- default: show both groups if bidang not set or unrecognized -->
                    <a href="{{ route('staf.keuangan.index') }}" 
                       class="nav-link {{ request()->is('staf/keuangan*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Keuangan</span>
                    </a>
                    <a href="{{ route('staf.pembayaran.index') }}" 
                       class="nav-link {{ request()->is('staf/pembayaran*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Pembayaran</span>
                    </a>
                    <a href="{{ route('staf.jadwal.index') }}" 
                       class="nav-link {{ request()->is('staf/jadwal*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('staf.pengumuman.index') }}" 
                       class="nav-link {{ request()->is('staf/pengumuman*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7 a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        <span>Pengumuman</span>
                    </a>
                @endif
            @break

            @case('guru')
                <a href="{{ route('guru.dashboard') }}" 
                   class="nav-link {{ request()->is('guru/dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('guru.jadwal.index') }}" 
                   class="nav-link {{ request()->is('guru/jadwal*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Jadwal Mengajar</span>
                </a>
                <a href="{{ route('guru.nilai.index') }}" 
                   class="nav-link {{ request()->is('guru/nilai*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Input Nilai</span>
                </a>
                <a href="{{ route('guru.profile') }}" 
                   class="nav-link {{ request()->is('guru/profile*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Profil Saya</span>
                </a>
            @break

            @case('murid')
                <a href="{{ route('murid.dashboard') }}" 
                   class="nav-link {{ request()->is('murid/dashboard*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('murid.jadwal.index') }}" 
                   class="nav-link {{ request()->is('murid/jadwal*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Akademik</span>
                </a>
                <a href="{{ route('murid.pembayaran.index') }}" 
                   class="nav-link {{ request()->is('murid/pembayaran*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Pembayaran</span>
                </a>    
                <a href="{{ route('murid.profile') }}" 
                   class="nav-link {{ request()->is('murid/profile*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Profil Saya</span>
                </a>
            @break

            @default
                <div class="px-4 py-8 text-center">
                    <p class="text-sm text-gray-400">Menu tidak tersedia</p>
                </div>
        @endswitch
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-gray-100">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="button" 
                onclick="konfirmasiLogout()"
                class="flex items-center justify-center w-full px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors duration-200 font-medium text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<!-- Styles -->
<style>
    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.625rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4B5563;
        transition: all 0.15s ease;
    }
    
    .nav-link svg {
        margin-right: 0.75rem;
        flex-shrink: 0;
    }
    
    .nav-link:hover {
        background-color: #F3F4F6;
        color: #059669;
    }
    
    .nav-link.active {
        background-color: #059669;
        color: white;
        font-weight: 600;
    }
    
    .nav-link.active:hover {
        background-color: #047857;
    }
</style>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiLogout() {
        Swal.fire({
            title: 'Keluar dari Aplikasi?',
            text: "Anda akan keluar dari sesi saat ini",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>