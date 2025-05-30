@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-10 rounded shadow">
        <h2 class="text-2xl font-bold mb-8">Hi, {{ Auth::user()->name }}</h2>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-1 font-semibold">Nama *</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Number Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 font-semibold">Email *</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 font-semibold">Alamat *</label>
                    <input type="text" name="address" value="{{ old('address', Auth::user()->address) }}" required class="w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 font-semibold">Password *</label>
                    <input type="password" name="password" placeholder="Isi jika ingin mengubah" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded hover:bg-teal-700">Simpan</button>
                <a href="/" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
