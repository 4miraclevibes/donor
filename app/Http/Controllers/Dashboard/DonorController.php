<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor;
class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::all();
        return view('pages.backend.donors.index', compact('donors'));
    }

    public function update(Request $request, Donor $donor)
    {
        $donor->update($request->all());
        return redirect()->route('donors.index')->with('success', 'Donor berhasil diupdate');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('donors.index')->with('success', 'Donor berhasil dihapus');
    }

    public function category1()
    {
        $donors = Donor::where('category', true)->get();
        return view('pages.backend.donors.category1', compact('donors'));
    }

    public function category2()
    {
        $donors = Donor::where('category', false)->get();
        return view('pages.backend.donors.category2', compact('donors'));
    }
}
