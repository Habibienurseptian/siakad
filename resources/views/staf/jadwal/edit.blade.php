@extends('layouts.app')

@section('title', 'Edit Jadwal Pelajaran')

@section('content')
<div class="container mx-auto max-w-md px-4 py-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h1 class="text-xl font-bold text-green-800 mb-4">Edit Jadwal Pelajaran</h1>
        <form action="{{ route('staf.jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="sekolah_id" value="{{ $jadwal->sekolah_id }}">

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Hari</label>
                <select name="hari" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                    <option value="Minggu" {{ $jadwal->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai" value="{{ $jadwal->jam_mulai }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="{{ $jadwal->jam_selesai }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Mata Pelajaran</label>
                <input type="text" name="mapel" value="{{ $jadwal->mapel }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Guru</label>
                <select name="guru" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="">Pilih Guru</option>
                    @foreach(\App\Models\Guru::all() as $guru)
                        <option value="{{ $guru->user ? $guru->user->name : $guru->name ?? '-' }}" {{ $jadwal->guru == $guru->user ? 'selected' : '' }}>{{ $guru->user ? $guru->user->name : $guru->name ?? '-' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Kelas</label>
                <input type="text" name="kelas" value="{{ $jadwal->kelas }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('staf.jadwal.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded font-semibold text-sm hover:bg-gray-600">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-green-600 text-white px-4 py-2 rounded font-semibold text-sm hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
