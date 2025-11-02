<div id="modalTambahSekolah" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <!-- Header Modal -->
        <div class="flex justify-between items-center px-6 py-4 border-b sticky top-0 bg-white rounded-t-xl">
            <h2 class="text-lg font-bold text-green-700">Tambah Data Sekolah</h2>
            <button id="closeModalTambahBtn" class="text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form Tambah -->
        <form action="{{ route('admin.sekolah.store') }}" method="POST" class="px-6 py-4 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1">Nama Sekolah <span class="text-red-500">*</span></label>
                <input type="text" name="nama" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:border-transparent" 
                       placeholder="Masukkan nama sekolah" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Alamat <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:border-transparent" 
                          placeholder="Masukkan alamat lengkap sekolah" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Kepala Sekolah <span class="text-red-500">*</span></label>
                <input type="text" name="kepala_sekolah" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:border-transparent" 
                       placeholder="Masukkan nama kepala sekolah" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">NPSN <span class="text-red-500">*</span></label>
                <input type="text" name="npsn" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:border-transparent" 
                       placeholder="Masukkan NPSN (Nomor Pokok Sekolah Nasional)" required>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" id="cancelModalTambahBtn"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-5 py-2 rounded-lg font-semibold transition">
                    Batal
                </button>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>