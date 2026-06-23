<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pengguna</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peran</label>
                        <p class="mt-1">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if ($user->role === 'admin')
                                    bg-red-100 text-red-800
                                @elseif ($user->role === 'kepala_desa')
                                    bg-blue-100 text-blue-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bergabung Sejak</label>
                        <p class="mt-1 text-gray-900">{{ $user->created_at->format('d F Y H:i') }}</p>
                    </div>

                    @if ($user->email_verified_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Terverifikasi</label>
                            <p class="mt-1 text-gray-900">{{ $user->email_verified_at->format('d F Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <a 
                        href="{{ route('users.index') }}"
                        class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition"
                    >
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
