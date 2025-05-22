<?php

use App\Models\User;
use App\Models\Donation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class); // ID penerima donasi
            $table->foreignIdFor(Donation::class); // ID donasi yang diminta
            $table->foreignId('location')->constrained('users'); // ID restoran (dari tabel users)
            $table->integer('quantity'); // Jumlah yang diminta
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_requests');
    }
};