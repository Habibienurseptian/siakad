<!-- Modal Edit Staf -->
<div id="modalEditStaf-{{ $staf->id }}" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-gray-800">Edit Data Staf - {{ $staf->user->name }}</h2>
        </div>

        <!-- Body -->
        <div class="px-6">
            <form action="{{ route('admin.staf.update', $staf->id) }}" method="POST" id="formEditStaf-{{ $staf->id }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ $staf->user->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $staf->user->email }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- NIP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" value="{{ $staf->nip }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Sekolah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sekolah</label>
                    <select name="sekolah_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}" @if($staf->sekolah_id == $sekolah->id) selected @endif>
                                {{ $sekolah->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bidang -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bidang (opsional)</label>
                    <input type="text" name="bidang" value="{{ $staf->bidang ?? '' }}" placeholder="Contoh: keuangan / akademik" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Password Baru (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 px-6 py-4 border-t">
                    <button type="button" 
                            onclick="document.getElementById('modalEditStaf-{{ $staf->id }}').classList.add('hidden')" 
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
