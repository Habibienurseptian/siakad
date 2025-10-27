<!-- Modal Edit Kelas -->
<div id="modalEditKelas-{{ $loop->iteration }}" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-gray-800">
                Edit Kelas - {{ $sekolah->nama }}
            </h2>
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <form action="{{ route('admin.sekolah.kelas.update', [$sekolah->id, $kelasItem->id]) }}" method="POST" id="formEditKelas-{{ $loop->iteration }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                    <input type="text" name="nama_kelas" value="{{ $kelasItem->nama_kelas ?? $kelasItem }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Wali Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                    <input type="text" name="wali_kelas" value="{{ $kelasItem->wali_kelas ?? '' }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Nama guru wali kelas (opsional)">
                </div>

                <!-- Jumlah Siswa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Siswa</label>
                    <input type="number" name="jumlah_siswa" value="{{ $kelasItem->jumlah_siswa ?? '' }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" min="0" placeholder="Masukkan jumlah siswa (opsional)">
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button"
                            onclick="document.getElementById('modalEditKelas-{{ $loop->iteration }}').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg shadow">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
