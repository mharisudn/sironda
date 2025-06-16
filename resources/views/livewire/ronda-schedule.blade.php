<div class="min-h-screen bg-gradient-to-br from-blue-100 via-white to-indigo-100 px-4 py-10">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white shadow-lg rounded-xl p-8 mb-6">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 bg-indigo-100 rounded-lg mb-4">
                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="text-sm font-semibold text-indigo-700">Jadwal Ronda</span>
                </div>
                <h1 class="text-2xl font-bold text-indigo-700 mb-2">
                    {{ $periode->name ?? 'Periode Tidak Aktif' }}
                </h1>
                @if ($periode)
                    <p class="text-gray-600 text-sm">
                        {{ \Carbon\Carbon::parse($periode->start_date)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($periode->end_date)->format('d M Y') }}
                    </p>
                @endif
            </div>

            <!-- Back Button -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('polling.code') }}"
                    class="inline-flex items-center px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Polling
                </a>
            </div>
        </div>

        <!-- Termins Section -->
        @forelse($termins as $index => $termin)
            <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-6">
                <!-- Termin Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ $termin->name }}</h3>
                            <p class="text-indigo-100 text-sm">
                                {{ \Carbon\Carbon::parse($termin->start_date)->format('d M') }} -
                                {{ \Carbon\Carbon::parse($termin->end_date)->format('d M Y') }}
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-lg px-3 py-2">
                            <span class="text-white font-bold">{{ $index + 1 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Schedule Content -->
                <div class="p-6">
                    @if ($termin->rondaSchedules->isNotEmpty())
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-800">Jadwal Tersedia</h4>
                            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">
                                {{ $termin->rondaSchedules->count() }} Jadwal
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach ($termin->rondaSchedules as $schedule)
                                <div
                                    class="bg-gray-50 rounded-lg p-4 border-l-4 border-indigo-400 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <h5 class="font-semibold text-gray-900 mb-2 truncate">
                                                {{ $schedule->pollingCode->name ?? 'Area Tidak Diketahui' }}
                                            </h5>

                                            @if ($schedule->shift_type->value === 'Day')
                                                <div
                                                    class="flex items-center text-orange-600 bg-orange-50 px-3 py-1 rounded-full">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-sm font-medium">Shift Siang</span>
                                                </div>
                                            @elseif($schedule->shift_type->value == 'Night')
                                                <div
                                                    class="flex items-center text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                                        </path>
                                                    </svg>
                                                    <span class="text-sm font-medium">Shift Malam</span>
                                                </div>
                                            @elseif($schedule->shift_type->value == 'Mix')
                                                <div
                                                    class="flex items-center text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium">Siang & Malam</span>
                                                </div>
                                            @else
                                                <div
                                                    class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium">Shift Umum</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="w-3 h-3 bg-green-400 rounded-full ml-3 mt-1 flex-shrink-0"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State for No Schedules -->
                        <div class="text-center py-8">
                            <div
                                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Jadwal</h4>
                            <p class="text-gray-600">Jadwal untuk termin ini belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <!-- Empty State for No Termins -->
            <div class="bg-white shadow-lg rounded-xl p-12 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gray-100 mb-6">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-indigo-700 mb-3">Belum Ada Termin</h3>
                <p class="text-gray-600 text-lg mb-6">Belum ada termin ronda tersedia untuk periode ini</p>
                <div class="inline-flex items-center px-6 py-3 bg-indigo-100 text-indigo-700 rounded-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">Hubungi Administrator</span>
                </div>
            </div>
        @endforelse
    </div>
</div>
