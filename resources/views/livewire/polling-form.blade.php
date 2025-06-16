<div>
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8 animate-fade-in">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1
                class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                Pilih Jadwal Ronda
            </h1>
            <p class="text-gray-600">Tentukan waktu yang tepat untuk berpartisipasi</p>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-2xl">👋</span>
                    </div>
                    <div>
                        <h2 class="text-md font-semibold">Halo, {{ $pollingCode->name }}!</h2>
                        <p class="text-blue-100 text-sm">Selamat datang kembali</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if (session()->has('success'))
                    <div
                        class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 animate-fade-in">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <a href="{{ route('polling.code') }}"
                    class="inline-flex items-center text-sm text-blue-600 hover:underline hover:text-blue-800 mb-6">
                    ← Kembali ke halaman input kode
                </a>


                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6 mb-8">
                    <div class="flex items-start space-x-3">
                        <div
                            class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Petunjuk Pemilihan</h3>
                            <p class="text-sm text-gray-600">Pilih <strong class="text-blue-600">minimal 2
                                    termin</strong>
                                yang kamu bersedia untuk ronda.</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6 w-full">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <p class="text-sm sm:text-lg font-semibold text-gray-800 leading-5">
                            Pilih <strong class="text-blue-600">2 termin ronda</strong> yang kamu inginkan:
                        </p>
                        <div class="flex items-center justify-between sm:justify-start sm:space-x-2">
                            <span class="text-xs sm:text-sm text-gray-500">Terpilih:</span>
                            <div
                                class="bg-blue-100 text-blue-800 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium ml-2 sm:ml-0">
                                {{ count($selected) }} / 2
                            </div>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="submit" class="space-y-6">
                    @foreach ($termins as $index => $termin)
                        @php
                            $isSelected = in_array($termin->id, $selected);
                            $orderIndex = array_search($termin->id, $selected); // 0 -> pertama, 1 -> kedua
                        @endphp
                        <div class="relative">
                            <label class="block cursor-pointer">
                                <input type="checkbox" value="{{ $termin->id }}" wire:model.live="selectedTerminIds"
                                    class="hidden" />
                                <div
                                    class="p-5 rounded-2xl border-2 transition-all duration-200 {{ in_array($termin->id, $selected) ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-white' }}">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-700">{{ $termin->name }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($termin->start_date)->format('d M') }} -
                                                {{ \Carbon\Carbon::parse($termin->end_date)->format('d M') }}</p>
                                        </div>
                                        @if ($isSelected)
                                            <div
                                                class="absolute top-2 right-2 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg z-10">
                                                {{ $orderIndex === 0 ? 'Pilihan Pertama' : 'Pilihan Kedua' }}
                                            </div>
                                        @endif
                                        @if (in_array($termin->id, $selected))
                                            <div class="text-green-500 font-semibold text-sm">✓ Dipilih</div>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach

                    <div class="flex justify-center">
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition font-semibold shadow-md">
                            <span wire:loading.remove> Simpan Pilihan </span>
                            <span wire:loading> Menyimpan... </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
