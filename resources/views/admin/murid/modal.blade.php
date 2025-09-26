<!-- Modal Tambah Murid khusus sekolah ini -->
<div id="modalMurid-{{ $sekolah->id }}" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-gray-800">Tambah Akun Murid - {{ $sekolah->nama }}</h2>
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <form action="{{ route('admin.murid.store') }}" method="POST" id="formTambahMurid-{{ $sekolah->id }}" class="space-y-4">
                @csrf
                <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <input type="text" name="kelas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk</label>
                    <input type="text" name="nomor_induk" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>

                <div class="flex justify-end gap-3 px-6 py-4 border-t">
                    <button type="button" onclick="document.getElementById('modalMurid-{{ $sekolah->id }}').classList.add('hidden')" 
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
