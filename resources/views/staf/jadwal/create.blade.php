<!-- Modal Tambah Jadwal Pelajaran -->
<div id="modalTambahJadwal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-xl overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-green-800">Tambah Jadwal Pelajaran</h2>
            <button type="button" onclick="document.getElementById('modalTambahJadwal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 text-xl">&times;</button>
        </div>
        <!-- Body -->
        <div class="px-6 py-4">
            <form action="{{ route('staf.jadwal.store') }}" method="POST" id="formTambahJadwal" class="space-y-4">
                @csrf
                <input type="hidden" name="sekolah_id" value="">
                <div>
                    <label class="block text-sm font-semibold mb-1">Hari</label>
                    <select name="hari" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Mata Pelajaran</label>
                    <input type="text" name="mapel" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Guru</label>
                    <select name="guru" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Guru</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->user ? $guru->user->name : $guru->name ?? '-' }}">{{ $guru->user ? $guru->user->name : $guru->name ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Kelas</label>
                    <input type="text" name="kelas" class="w-full border rounded px-3 py-2" required>
                </div>
            </form>
        </div>
        <!-- Footer -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t">
            <button type="button" onclick="document.getElementById('modalTambahJadwal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg shadow">Batal</button>
            <button type="submit" form="formTambahJadwal" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow">Simpan</button>
        </div>
    </div>
</div>
