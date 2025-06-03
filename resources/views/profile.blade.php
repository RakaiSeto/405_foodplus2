<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - FOOD+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <input type="text" style="display:none">
    <input type="password" style="display:none">
    <!-- Main Container -->
    <div class="w-full mx-auto bg-white min-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-6">
                <div class="text-xl font-bold text-gray-900">FOOD+</div>
                <div class="text-lg font-semibold text-gray-700">Profile</div>
            </div>
            <button class="text-orange-500 hover:text-orange-600 p-1">
                <a href="{{ $batalUrl }}">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                </a>
            </button>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            <!-- Greeting -->
            <h2 class="text-2xl font-semibold text-gray-900 mb-8">Hi, {{ $user->name }}</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form class="space-y-6" action="/profile/update" method="POST">
                @csrf
                <!-- Name Field -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" value="{{ $user->name }}"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                            placeholder="contoh@email.com">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" autocomplete="new-password"
                            class="w-full px-4 py-3 bg-gray-100 border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 pr-12"
                            placeholder="Kosongkan jika tidak ingin mengubah password" value="">
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-8">
                    <a href="{{ $batalUrl }}"
                        class="px-8 py-3 bg-gray-400 hover:bg-gray-500 text-white font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        localStorage.setItem('user', JSON.stringify({!! $userJson !!}));

        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414L5.636 5.636m14.142 14.142L4.222 4.222"></path>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        });

        // Form validation and interaction
        document.querySelector('form').addEventListener('submit', function (e) {
            let form = this;
            e.preventDefault();

            // Simple validation
            const requiredFields = ['nama', 'email'];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('ring-2', 'ring-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('ring-2', 'ring-red-500');
                }
            });

            form.submit();
        });

        // Remove error styling on input
        document.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', function () {
                this.classList.remove('ring-2', 'ring-red-500');
            });
        });
    </script>
</body>

</html>