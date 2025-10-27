<div id="modalPengumumanAkademik" 
     class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center p-4">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-xl overflow-hidden animate__animated animate__fadeIn">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-green-800">
                Tambah Pengumuman Akademik
            </h2>
            <button id="closeModalAkademikBtn" 
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form -->
        <form action="{{ route('staf.pengumuman.akademik.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1 text-slate-700">Judul Pengumuman</label>
                <input type="text" name="judul" 
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-slate-700">Isi Pengumuman</label>
                <textarea name="isi" rows="6" 
                          class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none resize-none"
                          required></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" id="cancelModalAkademikBtn" 
                        class="px-4 py-2 rounded-lg border border-slate-300 hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>