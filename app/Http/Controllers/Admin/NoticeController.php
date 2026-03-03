<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $notices = Notice::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'category' => 'required|in:General,Maintenance,Event,Emergency,Meeting,Payment',
            'active' => 'boolean',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $validated['active'] = $request->has('active');
        Notice::create($validated);
        return redirect()->route('admin.notices.index')->with('success', 'Notice published successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $notice = Notice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $notice = Notice::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'category' => 'required|in:General,Maintenance,Event,Emergency,Meeting,Payment',
            'expires_at' => 'nullable|date',
        ]);

        $validated['active'] = $request->has('active');
        $notice->update($validated);
        return redirect()->route('admin.notices.index')->with('success', 'Notice updated!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Notice::findOrFail($id)->delete();
        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted!');
    }
}