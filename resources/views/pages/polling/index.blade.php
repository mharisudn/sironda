{{-- <x-layouts.app>
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
        <h1 class="text-xl font-semibold mb-4 text-center">Polling Ronda Pegawai</h1>
        <form method="POST" action="{{ route('polling.validate') }}" class="space-y-4">
            @csrf
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Kode Polling</span>
                <input type="text" name="code" required
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Contoh: RND-0001">
            </label>
            @error('code')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Lanjutkan
            </button>
        </form>
    </div>
</x-layouts.app> --}}
