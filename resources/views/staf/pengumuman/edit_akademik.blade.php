<div id="modalEditAkademik" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-green-700">Edit Pengumuman Akademik</h2>
            <button id="closeEditAkademikBtn" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form id="editAkademikForm" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Judul Pengumuman</label>
                <input id="editAkademikJudul" type="text" name="judul" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Isi Pengumuman</label>
                <textarea id="editAkademikIsi" name="isi" rows="6" class="w-full border rounded px-3 py-2" required></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" id="cancelEditAkademikBtn" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-bold hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
