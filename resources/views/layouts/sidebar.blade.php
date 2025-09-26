<aside class="fixed inset-y-0 left-0 w-64 h-screen bg-white border-r border-gray-200 overflow-y-auto flex-shrink-0 flex flex-col">
    <header class="p-6 flex justify-center bg-white shadow-md">
        <a href="#" class="flex items-center space-x-2">
            <span class="text-xl font-bold text-green-800">Aplikasi Sekolah</span>
        </a>
    </header>

    <div class="mx-4 mb-6 p-4 rounded-xl flex flex-col items-center space-y-2 text-center">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=10B981&color=fff" 
            alt="Profile" 
            class="w-16 h-16 rounded-full border-2 border-green-600">

        <div class="text-green-900">
            <h4 class="text-md font-bold">{{ Auth::user()->name ?? 'Pengguna' }}</h4>
            @php
                $role = Auth::user()->role ?? 'guest';
                $murid = null;
                $guru = null;
                $staf = null;
                $sekolahStaf = null;

                if ($role === 'murid') {
                    $murid = \App\Models\Murid::where('user_id', Auth::id())->first();
                } elseif ($role === 'guru') {
                    $guru = \App\Models\Guru::where('user_id', Auth::id())->first();
                } elseif ($role === 'staf') {
                    $staf = \App\Models\Staf::where('user_id', Auth::id())->first();
                    if ($staf && $staf->sekolah_id) {
                        $sekolahStaf = \App\Models\Sekolah::find($staf->sekolah_id);
                    }
                }
            @endphp

            {{-- Jika murid --}}
            @if($role === 'murid' && $murid)
                <p class="text-sm text-gray-400">{{ $murid->nomor_induk ?? '-' }}</p>
                <p class="text-sm text-gray-400">{{ $murid->kelas ?? '-' }}</p>
                <p class="text-sm text-gray-400">{{ $murid->sekolah->nama ?? '-' }}</p>

            {{-- Jika guru --}}
            @elseif($role === 'guru' && $guru)
                <p class="text-sm text-gray-400">{{ $guru->nip ?? '-' }}</p>
                <p class="text-sm text-gray-400">Guru</p>
                <p class="text-sm text-gray-400">{{ $guru->sekolah->nama ?? '-' }}</p>

            {{-- Jika staf --}}
            @elseif($role === 'staf' && $staf)
                <p class="text-sm text-gray-400">{{ $staf->nip ?? '-' }}</p>
                <p class="text-sm text-gray-400">Staf {{ $sekolahStaf->nama ?? '-' }}</p>

            {{-- Default (admin, guest) --}}
            @else
                <p class="text-sm text-gray-400">{{ Auth::user()->id ?? '-' }}</p>
                <p class="text-sm text-gray-400">{{ ucfirst($role) }}</p>
            @endif
        </div>
    </div>

    <nav class="space-y-2 px-4 flex-grow">
        @php $role = Auth::user()->role ?? 'guest'; @endphp

        @switch($role)
            @case('admin')
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('admin/dashboard*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-house mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.sekolah.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('admin/sekolah*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-school mr-3"></i> Data Sekolah
                </a>
                <a href="{{ route('admin.murid.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('admin/murid*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-graduation-cap mr-3"></i> Data Siswa
                </a>
                <a href="{{ route('admin.guru.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('admin/guru*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-chalkboard-user mr-3"></i> Data Guru
                </a>
                <a href="{{ route('admin.staf.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('admin/staf*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-briefcase mr-3"></i> Data Staf
                </a>
            @break

            @case('staf')
                <a href="{{ route('staf.dashboard') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('staf/dashboard*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-house mr-3"></i> Dashboard
                </a>
                <a href="{{ route('staf.keuangan.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('staf/keuangan*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-rupiah-sign mr-3"></i> Keuangan
                </a>
                <a href="{{ route('staf.pembayaran.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('staf/pembayaran*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-money-bill-wave mr-3"></i> Pembayaran
                </a>
                <a href="{{ route('staf.jadwal.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('staf/jadwal*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-graduation-cap mr-3"></i> Jadwal Pelajaran
                </a>
                <!-- <a href="#" class="flex items-center py-2.5 px-4 rounded-lg text-green-800 hover:bg-green-50 hover:text-green-800">
                    <i class="fa-solid fa-boxes-stacked mr-3"></i> Inventaris
                </a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg text-green-800 hover:bg-green-50 hover:text-green-800">
                    <i class="fa-solid fa-envelope mr-3"></i> Surat
                </a> -->
                <a href="{{ route('staf.pengumuman.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('staf/pengumuman*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-bullhorn mr-3"></i> Edit Pengumuman
                </a>
            @break

            @case('guru')
                <a href="{{ route('guru.dashboard') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('guru/dashboard*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-house mr-3"></i> Dashboard
                </a>
                <a href="{{ route('guru.jadwal.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('guru/jadwal*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-calendar-days mr-3"></i> Jadwal Mengajar
                </a>
                <a href="{{ route('guru.nilai.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('guru/nilai*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-square-pen mr-3"></i> Input Nilai
                </a>
            @break

            @case('murid')
                <a href="{{ route('murid.dashboard') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('murid/dashboard*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-house mr-3"></i> Dashboard
                </a>
                <a href="{{ route('murid.jadwal.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('murid/jadwal*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-graduation-cap mr-3"></i> Akademik
                </a>
                <a href="{{ route('murid.pembayaran.index') }}" 
                   class="flex items-center py-2.5 px-4 rounded-lg {{ request()->is('murid/pembayaran*') ? 'bg-green-800 text-white font-semibold' : 'text-green-800 hover:bg-green-50 hover:text-green-800' }}">
                    <i class="fa-solid fa-money-bills mr-3"></i> Pembayaran
                </a>    
            @break

            @default
                <span class="text-gray-400 text-sm">Menu tidak tersedia</span>
        @endswitch
    </nav>

    <div class="mt-auto px-4 py-4">
        <a href="{{ route('logout') }}" 
           class="flex items-center py-2.5 px-4 rounded-lg bg-red-400 text-red-100 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
            <i class="fa-solid fa-right-from-bracket mr-3"></i> Log Out
        </a>
    </div>
</aside>
