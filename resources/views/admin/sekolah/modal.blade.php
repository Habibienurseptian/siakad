<!-- Modal Tambah Kelas Khusus Sekolah Ini -->
<div id="modalKelas-{{ $sekolah->id }}" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-gray-800">
                Tambah Kelas - {{ $sekolah->nama }}
            </h2>
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <form action="{{ route('admin.sekolah.kelas.store', $sekolah->id) }}" method="POST" id="formTambahKelas-{{ $sekolah->id }}" class="space-y-4">
                @csrf
                <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">

                <!-- Nama Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required placeholder="Contoh: X IPA 1">
                </div>

                <!-- Wali Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                    <input type="text" name="wali_kelas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Nama guru wali kelas (opsional)">
                </div>

                <!-- Jumlah Siswa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Siswa</label>
                    <input type="number" name="jumlah_siswa" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" min="0" placeholder="Masukkan jumlah siswa (opsional)">
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button"
                            onclick="document.getElementById('modalKelas-{{ $sekolah->id }}').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg shadow">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>