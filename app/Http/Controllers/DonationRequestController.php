<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationRequest;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationRequestController extends Controller
{
    /**
     * Menampilkan dashboard penerima donasi
     */
    public function dashboard()
    {
        // Statistik untuk dashboard
        $totalDonatur = \App\Models\User::where('role', 'donatur')->count();
        $totalRestoran = \App\Models\User::where('role', 'resto')->count();
        $totalPenerima = \App\Models\User::where('role', 'receiver')->count();
        $totalMakanan = Donation::where('status', 'available')->sum('quantity');
        $totalPermintaan = DonationRequest::where('user_id', Auth::id())->count();
        $totalDiterima = DonationRequest::where('user_id', Auth::id())
                                        ->where('status', 'approved')
                                        ->count();
        
        return view('receive.dashboard', compact(
            'totalDonatur', 
            'totalRestoran', 
            'totalPenerima', 
            'totalMakanan',
            'totalPermintaan',
            'totalDiterima'
        ));
    }

    /**
     * API untuk mendapatkan daftar donasi yang tersedia
     */
    public function getAvailableDonations()
    {
        // Ambil data restoran dengan donasi yang tersedia
        $restorans = \App\Models\User::where('role', 'resto')
            ->with(['donations' => function($query) {
                $query->where('status', 'available');
            }])
            ->get()
            ->map(function($resto) {
                return [
                    'id' => $resto->id,
                    'name' => $resto->name,
                    'logo_url' => $resto->profile_image ?? null,
                    'category' => $resto->category ?? 'Makanan',
                    'views' => rand(10000, 500000), // Dummy data
                    'likes' => rand(5000, 50000),   // Dummy data
                    'foods' => $resto->donations->map(function($donation) {
                        return [
                            'id' => $donation->id,
                            'name' => $donation->food_name,
                            'quantity' => $donation->quantity
                        ];
                    })
                ];
            })
            ->filter(function($resto) {
                return count($resto['foods']) > 0;
            })
            ->values();
        
        return response()->json($restorans);
    }

    /**
     * Menyimpan permintaan donasi baru
     */
    public function store(Request $request)
{
    $data = $request->json()->all();
    
    // Validasi data
    if (!isset($data['food_id']) || !isset($data['location']) || !isset($data['quantity'])) {
        return response()->json(['success' => false, 'message' => 'Data tidak lengkap']);
    }
    
    // Cek ketersediaan donasi
    $donation = Donation::find($data['food_id']);
    
    if (!$donation || $donation->status !== 'available' || $donation->quantity < $data['quantity']) {
        return response()->json(['success' => false, 'message' => 'Jumlah donasi yang diminta tidak tersedia']);
    }
    
    // Buat permintaan donasi baru
    $donationRequest = new DonationRequest();
    $donationRequest->user_id = auth();
    $donationRequest->donation_id = $data['food_id'];
    $donationRequest->location = $data['location'];
    $donationRequest->quantity = $data['quantity'];
    $donationRequest->status = 'pending';
    $donationRequest->save();
    
    // Kurangi jumlah donasi yang tersedia
    $donation->quantity -= $data['quantity'];
    if ($donation->quantity <= 0) {
        $donation->status = 'claimed';
    }
    $donation->save();
    
    return response()->json(['success' => true]);
}

    /**
     * Menampilkan daftar permintaan donasi pengguna
     */
    public function myRequests()
    {
        $requests = DonationRequest::where('user_id', Auth::id())
            ->with(['donation', 'restaurant'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('receive.requests', compact('requests'));
    }

    /**
     * Menampilkan riwayat permintaan donasi
     */
    public function history()
    {
        $history = DonationRequest::where('user_id', Auth::id())
            ->where('status', '!=', 'pending')
            ->with(['donation', 'restaurant'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('receive.history', compact('history'));
    }

    /**
     * Menampilkan halaman request donasi untuk restoran tertentu
     */
    public function showRequestForm($restoId)
{
    // Ambil data restoran/lokasi
    $location = \App\Models\User::where('id', $restoId)
        ->where('role', 'penyedia')
        ->firstOrFail();
    
    // Ambil data makanan yang tersedia dari restoran tersebut
    $foods = Donation::where('user_id', $restoId)
        ->where('status', 'available')
        ->where('quantity', '>', 0)
        ->get()
        ->map(function($donation) {
            return (object)[
                'id' => $donation->id,
                'name' => $donation->food_name,
                'quantity' => $donation->quantity,
                'category' => $donation->category,
                'image_url' => asset('images/food-placeholder.png')
            ];
        });
    
    return view('receive.request', compact('location', 'foods'));
}
}