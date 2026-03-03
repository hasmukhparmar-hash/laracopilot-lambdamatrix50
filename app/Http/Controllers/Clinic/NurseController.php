<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    private function adminOnly()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        if (session('clinic_role') !== 'admin') return back()->with('error', 'Admin access required.');
        return null;
    }

    public function index()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        $nurses = Nurse::orderBy('name')->paginate(20);
        return view('clinic.nurses.index', compact('nurses'));
    }

    public function create()
    {
        if ($r = $this->adminOnly()) return $r;
        return view('clinic.nurses.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->adminOnly()) return $r;

        $validated = $request->validate([
            'name'       => 'required|string|max:150',
            'email'      => 'nullable|email|max:150',
            'phone'      => 'required|string|max:20',
            'shift'      => 'required|in:Morning,Evening,Night',
            'department' => 'nullable|string|max:100',
            'active'     => 'boolean',
            'permissions'=> 'nullable|array',
        ]);

        $validated['active'] = $request->has('active');
        $validated['permissions'] = $request->input('permissions', []);
        Nurse::create($validated);
        return redirect()->route('nurses.index')->with('success', 'Nurse added!');
    }

    public function edit($id)
    {
        if ($r = $this->adminOnly()) return $r;
        $nurse = Nurse::findOrFail($id);
        return view('clinic.nurses.edit', compact('nurse'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->adminOnly()) return $r;

        $nurse = Nurse::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:150',
            'email'      => 'nullable|email|max:150',
            'phone'      => 'required|string|max:20',
            'shift'      => 'required|in:Morning,Evening,Night',
            'department' => 'nullable|string|max:100',
            'permissions'=> 'nullable|array',
        ]);

        $validated['active'] = $request->has('active');
        $validated['permissions'] = $request->input('permissions', []);
        $nurse->update($validated);
        return redirect()->route('nurses.index')->with('success', 'Nurse updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->adminOnly()) return $r;
        Nurse::findOrFail($id)->delete();
        return redirect()->route('nurses.index')->with('success', 'Nurse removed.');
    }
}