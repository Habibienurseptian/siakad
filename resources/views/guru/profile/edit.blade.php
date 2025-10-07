@extends('layouts.app')
@section('title', 'Edit Profil Guru')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('guru.profile') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Edit Profil</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil Anda</p>
        </div>

        <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Profile Card -->
            <div class="bg-white rounded-3xl shadow-sm overflow-hidden mb-6">
                <!-- Profile Image Section -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 px-6 py-8">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            <img id="preview-image" src="{{ $guru->profile_image ? asset('storage/' . $guru->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($guru->user->name) . '&background=10B981&color=fff' }}" 
                                 class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                            <label for="profile_image" class="absolute bottom-0 right-0 w-9 h-9 bg-white rounded-full border-2 border-white shadow-lg flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </label>
                            <input type="file" id="profile_image" name="profile_image" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </div>
                        <p class="text-white text-sm">Klik icon kamera untuk mengubah foto</p>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="px-6 py-8 space-y-6">
                    <!-- Akun Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-green-500 rounded-full"></div>
                            Informasi Akun
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $guru->user->name) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $guru->user->email) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Data Pribadi Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-emerald-500 rounded-full"></div>
                            Data Pribadi
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                                <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                <input type="number" name="phone" value="{{ old('phone', $guru->phone) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" oninput="if(this.value.length > 13) this.value = this.value.slice(0, 14);">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Warga Negara</label>
                                <input type="text" name="warga_negara" value="{{ old('warga_negara', $guru->warga_negara) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status Marital</label>
                                <select name="status_marital" 
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                    <option value="">Pilih Status</option>
                                    <option value="Menikah" {{ old('status_marital', $guru->status_marital) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="Belum Menikah" {{ old('status_marital', $guru->status_marital) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="Cerai" {{ old('status_marital', $guru->status_marital) == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Data Keluarga Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-teal-500 rounded-full"></div>
                            Data Keluarga
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua</label>
                                <input type="text" name="nama_orangtua" value="{{ old('nama_orangtua', $guru->nama_orangtua) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir Orang Tua</label>
                                    <input type="text" name="tempat_lahir_orangtua" value="{{ old('tempat_lahir_orangtua', $guru->tempat_lahir_orangtua) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir Orang Tua</label>
                                    <input type="date" name="tanggal_lahir_orangtua" value="{{ old('tanggal_lahir_orangtua', $guru->tanggal_lahir_orangtua) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Alamat Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                            Alamat
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" 
                                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">{{ old('alamat', $guru->alamat) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos', $guru->kode_pos) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('guru.profile') }}" 
                   class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview-image');
        preview.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection