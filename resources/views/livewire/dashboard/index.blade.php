<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-bold text-2xl text-gray-800">Undangan Saya</h2>
        <a href="{{ route('dashboard.create') }}"
            class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm flex items-center shadow-lg">
            <i class="fa-solid fa-plus mr-2"></i> Buat Baru
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($invitations as $invitation)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                <!-- Header Card -->
                <div class="h-24 bg-gradient-to-r from-pink-500 to-purple-600 flex items-center justify-center p-4">
                    <h3 class="text-white font-bold text-lg text-center truncate w-full">{{ $invitation->title }}</h3>
                </div>

                <div class="p-5">
                    <div class="flex justify-between items-center text-xs text-gray-500 mb-4">
                        <span><i class="fa-regular fa-clock"></i> {{ $invitation->created_at->diffForHumans() }}</span>
                        <span
                            class="px-2 py-1 rounded bg-green-100 text-green-800 font-semibold">{{ $invitation->is_active ? 'Active' : 'Draft' }}</span>
                    </div>

                    <!-- Link Preview -->
                    <div class="mb-4 bg-gray-50 p-2 rounded text-xs flex justify-between items-center">
                        <span
                            class="truncate text-gray-600 w-3/4">{{ request()->getHost() }}/{{ $invitation->slug }}</span>
                        <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                            class="text-blue-600 hover:underline font-semibold">Lihat</a>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 border-t pt-4 mt-2">
                        <a href="{{ route('dashboard.invitation.edit', $invitation->id) }}"
                            class="flex-1 text-center py-2 bg-gray-800 text-white text-sm rounded hover:bg-gray-900 transition">
                            Edit
                        </a>
                        <a href="{{ route('dashboard.guests.index', $invitation->id) }}"
                            class="flex-1 text-center py-2 bg-white border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-50 transition">
                            Tamu
                        </a>
                        <button wire:click="delete({{ $invitation->id }})"
                            wire:confirm="Yakin ingin menghapus undangan ini?"
                            class="px-3 py-2 text-red-500 hover:bg-red-50 rounded">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-500 mb-2">Belum ada undangan yang dibuat.</p>
                <a href="{{ route('dashboard.create') }}" class="text-pink-600 font-semibold hover:underline">Buat
                    undangan pertama sekarang</a>
            </div>
        @endforelse
    </div>
</div>
