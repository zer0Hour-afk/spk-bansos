<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Peran Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                </div>

                <form method="POST" action="{{ route('users.updateRole', $user) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Peran
                        </label>
                        <select 
                            id="role" 
                            name="role" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            @foreach ($availableRoles as $availableRole)
                                <option 
                                    value="{{ $availableRole }}"
                                    @selected($user->role === $availableRole)
                                >
                                    {{ ucfirst(str_replace('_', ' ', $availableRole)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button 
                            type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        >
                            Simpan Perubahan
                        </button>
                        <a 
                            href="{{ route('users.index') }}"
                            class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition"
                        >
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
