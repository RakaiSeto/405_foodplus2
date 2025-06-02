<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Comment {{ $resto->name }}</title>
    <style>
        /* Additional custom styles if needed */
        .star-rating {
            display: inline-flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-4xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <a href="/receive/dashboard" class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <button id="openModal" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        + Tambah Komen
                    </button>
                </div>
            </div>
        </div>

        <!-- Restaurant Info -->
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="text-center mb-8">
                <!-- KFC Logo -->
                <div class="w-20 h-20 mx-auto mb-4 bg-red-600 rounded-full flex items-center justify-center">
                    <div class="text-white font-bold text-lg">
                        @php
                            $words = explode(' ', $resto->name);
                            $initials = '';
                            foreach ($words as $word) {
                                if (!empty($word)) { // Ensure word is not empty to avoid errors with multiple spaces
                                    $initials .= strtoupper(substr($word, 0, 1));
                                }
                            }
                        @endphp
                        {{ $initials }}
                    </div>
                </div>

                <!-- Rating -->
                <div class="flex justify-center items-center mb-4">
                    @for($i = 1; $i <= $averageRating; $i++)
                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                    @endfor
                    @for($i = 1; $i <= 5 - $averageRating; $i++)
                        <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                    @endfor
                </div>

                <!-- Stats -->
                <div class="flex justify-center space-x-4 text-sm">
                    <span class="bg-teal-600 text-white px-3 py-1 rounded-full">{{$resto->likes_count}} Likes</span>
                    <span class="bg-teal-600 text-white px-3 py-1 rounded-full">{{$resto->comments_count}}
                        Comments</span>
                </div>
            </div>

            <!-- Reviews Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @foreach($comments as $comment)
                    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                        <!-- Rating Stars -->
                        <div class="flex items-center mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $comment->rating)
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>

                        <!-- Name -->
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $comment->user->name }}</h3>

                        <!-- Location -->
                        <p class="text-gray-600 text-sm mb-3 border-b border-gray-200 pb-3">{{ $comment->headline }}</p>

                        <!-- Comment -->
                        <p class="text-gray-700 text-sm mb-4 leading-relaxed">{{ $comment->comment }}</p>

                        <!-- Footer -->
                        <div class="flex items-center justify-between text-sm text-gray-500 border-t border-gray-200 pt-3">
                            <span>Jumlah Donasi Yang Diterima: {{ $comment->transaction->quantity }} {{ $comment->transaction->donation->food_name }}</span>
                            <span>{{ $comment->created_at ? date_format($comment->created_at, 'd M Y') : '' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Create Comment Modal -->
    <div id="commentModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Komentar</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="/resto/{{ $resto->id }}/comment/store" method="POST" class="p-6">
                @csrf

                <!-- Donation ID Select -->
                <div class="mb-4">
                    <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Donasi <span class="text-red-500">*</span>
                    </label>
                    <select id="transaction_id" name="transaction_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Pilih Donasi --</option>
                        @if(isset($donations))
                            @foreach($donations as $donation)
                                <option value="{{ $donation->id }}">{{ $donation->donation->food_name }} - {{ $donation->quantity }} - {{ date_format($donation->created_at, 'd M Y') }}
                                </option>
                            @endforeach
                        @else
                            <option value="1">Donasi Bencana Alam - Rp 10,000,000</option>
                            <option value="2">Bantuan Pendidikan - Rp 5,000,000</option>
                            <option value="3">Bantuan Kesehatan - Rp 15,000,000</option>
                        @endif
                    </select>
                    @error('donation_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="rating-star text-gray-300 hover:text-yellow-400 transition-colors"
                                data-rating="{{ $i }}">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" id="rating" name="rating" required>
                    <p id="rating-text" class="mt-2 text-sm text-gray-600"></p>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Headline -->
                <div class="mb-4">
                    <label for="headline" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Komentar <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="headline" name="headline" required maxlength="30"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        placeholder="Ringkasan singkat tentang pengalaman Anda">
                    @error('headline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        Komentar <span class="text-red-500">*</span>
                    </label>
                    <textarea id="comment" name="comment" rows="4" required maxlength="500"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none"
                        placeholder="Ceritakan pengalaman Anda secara detail..."></textarea>
                    <div class="flex justify-between mt-1">
                        <span id="char-count" class="text-xs text-gray-500">0/500 karakter</span>
                        @error('comment')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancelModal"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 rounded-md transition-colors">
                        Kirim Komentar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('commentModal');
            const openModal = document.getElementById('openModal');
            const closeModal = document.getElementById('closeModal');
            const cancelModal = document.getElementById('cancelModal');
            const ratingInput = document.getElementById('rating');
            const ratingText = document.getElementById('rating-text');
            const ratingStars = document.querySelectorAll('.rating-star');
            const commentTextarea = document.getElementById('comment');
            const charCount = document.getElementById('char-count');

            // Rating labels
            const ratingLabels = {
                1: 'Sangat Buruk',
                2: 'Buruk',
                3: 'Biasa',
                4: 'Baik',
                5: 'Sangat Baik'
            };

            // Open modal
            openModal.addEventListener('click', function () {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            // Close modal functions
            function closeModalFunc() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                // Reset form
                document.querySelector('form').reset();
                resetRating();
                updateCharCount();
            }

            closeModal.addEventListener('click', closeModalFunc);
            cancelModal.addEventListener('click', closeModalFunc);

            // Close modal when clicking outside
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModalFunc();
                }
            });

            // Rating system
            function resetRating() {
                ratingStars.forEach(star => {
                    star.classList.remove('active', 'text-yellow-400');
                    star.classList.add('text-gray-300');
                });
                ratingInput.value = '';
                ratingText.textContent = '';
            }

            function setRating(rating) {
                ratingInput.value = rating;
                ratingText.textContent = ratingLabels[rating];

                ratingStars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.add('active', 'text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('active', 'text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            }

            ratingStars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = parseInt(this.dataset.rating);
                    setRating(rating);
                });

                star.addEventListener('mouseenter', function () {
                    const rating = parseInt(this.dataset.rating);
                    ratingStars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                });

                star.addEventListener('mouseleave', function () {
                    const currentRating = parseInt(ratingInput.value) || 0;
                    ratingStars.forEach((s, index) => {
                        if (index < currentRating) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                });
            });

            // Character counter
            function updateCharCount() {
                const length = commentTextarea.value.length;
                charCount.textContent = `${length}/500 karakter`;

                if (length > 450) {
                    charCount.classList.add('text-red-500');
                    charCount.classList.remove('text-gray-500');
                } else {
                    charCount.classList.remove('text-red-500');
                    charCount.classList.add('text-gray-500');
                }
            }

            commentTextarea.addEventListener('input', updateCharCount);

            // Initialize character count
            updateCharCount();

            // Close modal with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModalFunc();
                }
            });
        });
    </script>
</body>

</html>