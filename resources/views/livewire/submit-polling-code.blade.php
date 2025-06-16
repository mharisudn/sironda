<div
    class="min-h-screen bg-gradient-to-br from-blue-100 via-white to-indigo-100 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8 space-y-6">
        <!-- Quick Menu -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h2 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Menu Cepat
            </h2>
            <div class="grid grid-cols-1 gap-2">
                <a href="{{ route('ronda.schedule') }}" wire:navigate
                    class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 group">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-gray-900 group-hover:text-indigo-700">Lihat Jadwal Ronda
                        </h3>
                        <p class="text-xs text-gray-500">Cek jadwal ronda terkini</p>
                    </div>
                    <div class="flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white text-gray-500">atau</span>
            </div>
        </div>

        <!-- Form Section -->
        <div class="text-center">
            <h1 class="text-2xl font-bold text-indigo-700 mb-2">Polling Ronda</h1>
            <p class="text-gray-600 text-sm">Gunakan nama singkat atau nama lengkap untuk melakukan polling ronda.</p>
        </div>

        <form wire:submit.prevent="submit" class="space-y-4">
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" wire:model.defer="code" id="code"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Masukkan nama anda">
                @error('code')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Lanjutkan
                </button>
            </div>
        </form>
    </div>
</div>
