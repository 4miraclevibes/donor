<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use Laravolt\Indonesia\Models\Province;
use App\Models\DonorDetail;
use Illuminate\Support\Facades\Auth;
class DonorController extends Controller
{
    public function getCities($provinceId)
    {
        $cities = \Indonesia::findProvince($provinceId)->cities;
        return response()->json($cities);
    }

    public function getDistricts($cityId)
    {
        $districts = \Indonesia::findCity($cityId)->districts;
        return response()->json($districts);
    }

    public function getVillages($districtId)
    {
        $villages = \Indonesia::findDistrict($districtId)->villages;
        return response()->json($villages);
    }

    public function index()
    {
        $donors = Donor::where('user_id', Auth::user()->id)->get();
        $provinces = Province::all();
        return view('pages.frontend.donor', compact('provinces', 'donors'));
    }

    public function category1(Request $request)
    {
        $query = Donor::where('category', true)
            ->with(['user', 'province', 'city', 'district', 'village']);

        // Filter berdasarkan golongan darah
        if ($request->filled('golongan_darah')) {
            $query->where('golongan_darah', $request->golongan_darah);
        }

        // Filter berdasarkan provinsi
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        // Filter berdasarkan kota
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Filter berdasarkan kecamatan
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        $provinces = Province::all(); // Untuk dropdown provinsi
        $donors = $query->latest()->paginate(10)->withQueryString();
        
        return view('pages.frontend.category1', compact('donors', 'provinces'));
    }

    public function category2(Request $request)
    {
        $query = Donor::where('category', false)
        ->with(['user', 'province', 'city', 'district', 'village']);

    // Filter berdasarkan golongan darah
    if ($request->filled('golongan_darah')) {
        $query->where('golongan_darah', $request->golongan_darah);
    }

    // Filter berdasarkan provinsi
    if ($request->filled('province_id')) {
        $query->where('province_id', $request->province_id);
    }

    // Filter berdasarkan kota
    if ($request->filled('city_id')) {
        $query->where('city_id', $request->city_id);
    }

    // Filter berdasarkan kecamatan
    if ($request->filled('district_id')) {
        $query->where('district_id', $request->district_id);
    }

    $provinces = Province::all(); // Untuk dropdown provinsi
    $donors = $query->latest()->paginate(10)->withQueryString();
    
        return view('pages.frontend.category2', compact('donors', 'provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'category' => 'required',
            'golongan_darah' => 'required',
            'amount' => 'required|integer',
            'message' => 'nullable'
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['status'] = 'pending';
        $donor = Donor::create($validated);
        
        return redirect()->route('donor')->with('success', 'Data donor berhasil ditambahkan');
    }

    public function updateStatus(Request $request, Donor $donor)
    {
        if ($donor->status == 'pending') {
            $donor->update([
                'status' => $request->status
            ]);
            
            return redirect()->back()->with('success', 'Status donor berhasil diperbarui');
        }
        
        return redirect()->back()->with('error', 'Status donor tidak dapat diubah');
    }

    public function detail(Donor $donor)
    {
        return view('pages.frontend.donorDetail', compact('donor'));
    }

    public function detailStore(Request $request, Donor $donor)
    {
        // Validasi input
        $request->validate([
            'message' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        // Buat donor detail baru
        $donorDetails = DonorDetail::create([
            'user_id' => Auth::user()->id,
            'donor_id' => $donor->id,
            'message' => $request->message,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => 'pending' // Set default status ke pending
        ]);

        return redirect()->back()->with('success', 'Detail donor berhasil ditambahkan');
    }

    public function updateDetailStatus(Request $request, DonorDetail $donorDetail)
    {
        // Cek apakah user yang login adalah pemilik donor
        if (Auth::id() != $donorDetail->donor->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah status ini');
        }

        // Validasi status
        $request->validate([
            'status' => 'required|in:pending,done,failed'
        ]);

        // Update status
        $donorDetail->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}
