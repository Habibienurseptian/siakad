<div id="modalPengumumanTerbaru" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg mx-4">
        <!-- Header Modal -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-green-700">Tambah Pengumuman Terbaru</h2>
            <button id="closeModalTerbaruBtn" class="text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form Tambah -->
        <form action="{{ route('staf.pengumuman.terbaru.store') }}" method="POST" class="px-6 py-4 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1">Judul Pengumuman</label>
                <input type="text" name="judul" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Isi Pengumuman</label>
                <textarea name="isi" rows="5" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400" required></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" id="cancelModalTerbaruBtn"
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