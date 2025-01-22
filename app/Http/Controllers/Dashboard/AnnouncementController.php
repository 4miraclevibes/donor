<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all();
        return view('pages.backend.announcements.index', compact('announcements'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
            'status' => 'nullable',
        ]);
        $data = $request->all();
        $data['thumbnail'] = $request->file('thumbnail')->store('images/announcements', 'public');
        $data['status'] = $request->status ?? false;
        $data['user_id'] = Auth::user()->id;
        Announcement::create($data);
        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully');
    }
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
            'status' => 'nullable',
        ]);
        $data = $request->all();
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('images/announcements', 'public');
            Storage::delete($announcement->thumbnail);
        }
        $data['status'] = $request->status ?? false;
        $data['user_id'] = Auth::user()->id;
        $announcement->update($data);
        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully');
    }
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        Storage::delete($announcement->thumbnail);
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully');
    }
}
