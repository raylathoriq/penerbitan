@extends('layouts.admin')

@section('page_title', 'Profil Admin')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-slate-900">Informasi Pribadi</h3>
            <p class="text-sm text-slate-500 mt-1">Perbarui detail akun dan pengaturan profil admin Anda.</p>
        </x-slot>

        <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Profil berhasil diperbarui!');">
            <div class="space-y-6">
                <!-- Avatar Section -->
                <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                    <div class="h-20 w-20 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-xl overflow-hidden ring-4 ring-white shadow-sm">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <div>
                        <x-button type="secondary" typeHtml="button" class="!px-3 !py-1.5 text-xs">Ubah Foto</x-button>
                        <p class="text-xs text-slate-500 mt-2">JPG, GIF atau PNG. Maksimal 1MB.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all bg-slate-50" readonly>
                    <p class="text-xs text-slate-500 mt-1.5">Email terikat dengan domain institusi dan tidak dapat diubah sembarangan.</p>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <h4 class="text-sm font-semibold text-slate-900 mb-4">Ubah Password</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password Saat Ini</label>
                            <input type="password" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" placeholder="••••••••">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                                <input type="password" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" placeholder="Minimal 8 karakter">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                                <input type="password" class="block w-full border border-slate-200 rounded-lg text-sm py-2.5 px-3 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <x-button type="primary" typeHtml="submit">Simpan Perubahan</x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection