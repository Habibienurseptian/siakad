@extends('layouts.app')
@section('title', 'Edit Profil')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('murid.profile') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Edit Profil</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil Anda</p>
        </div>

        <form action="{{ route('murid.profile.update.post') }}" method="POST">
            @csrf
            
            <!-- Profile Card -->
            <div class="bg-white rounded-3xl shadow-sm overflow-hidden mb-6">
                <!-- Profile Image Section (View Only) -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 px-6 py-8">
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            <img src="{{ $murid->profile_image ? asset('storage/' . $murid->profile_image) : asset('images/user.png') }}" 
                                 class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                        </div>
                        <p class="text-white text-sm opacity-90">Foto profil tidak dapat diubah</p>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="px-6 py-8 space-y-6">
                    <!-- Data Akun Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                            Data Akun
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $murid->user->email) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="email@example.com" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Data Pribadi Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-green-500 rounded-full"></div>
                            Data Pribadi
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" 
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $murid->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $murid->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Warga Negara</label>
                                <input type="text" name="warga_negara" value="{{ old('warga_negara', $murid->warga_negara) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="Contoh: Indonesia">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $murid->phone) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="08xxxxxxxxxx" maxlength="14">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $murid->tempat_lahir) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                           placeholder="Contoh: Jakarta">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $murid->tanggal_lahir) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Data Orang Tua Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-emerald-500 rounded-full"></div>
                            Data Orang Tua/Wali
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua/Wali</label>
                                <input type="text" name="nama_orangtua" value="{{ old('nama_orangtua', $murid->nama_orangtua) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="Nama lengkap orang tua">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon Orang Tua/Wali</label>
                                <input type="text" name="telepon_orangtua" value="{{ old('telepon_orangtua', $murid->telepon_orangtua) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="08xxxxxxxxxx" maxlength="14">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir Orang Tua</label>
                                    <input type="text" name="tempat_lahir_orangtua" value="{{ old('tempat_lahir_orangtua', $murid->tempat_lahir_orangtua) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                           placeholder="Contoh: Jakarta">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir Orang Tua</label>
                                    <input type="date" name="tanggal_lahir_orangtua" value="{{ old('tanggal_lahir_orangtua', $murid->tanggal_lahir_orangtua) }}" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <!-- Alamat Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-4 bg-teal-500 rounded-full"></div>
                            Alamat
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" 
                                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $murid->alamat) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos', $murid->kode_pos) }}" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="12345" maxlength="5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('murid.profile') }}" 
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
@endsection