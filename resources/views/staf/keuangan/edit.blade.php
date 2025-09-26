<!-- Modal Edit Data Keuangan -->
<div id="editKeuanganModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-green-700">Edit Data Keuangan</h3>
            <button type="button" onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
        </div>

        <!-- Form Edit -->
        <form id="editKeuanganForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="editJenis" class="block text-sm font-medium text-gray-700">Jenis</label>
                    <select name="jenis" id="editJenis" class="w-full border rounded px-3 py-2" required>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <div>
                    <label for="editTanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="editTanggal" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mt-3">
                <label for="editKeterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <input type="text" name="keterangan" id="editKeterangan" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mt-3">
                <label for="editJumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" id="editJumlah" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 mt-5">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update</button>
            </div>
        </form>
    </div>
</div>