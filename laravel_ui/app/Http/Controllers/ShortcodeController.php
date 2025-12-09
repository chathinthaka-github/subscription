<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortcodeRequest;
use App\Http\Requests\UpdateShortcodeRequest;
use App\Models\Shortcode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShortcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        abort_unless(auth()->user()?->can('service.view'), 403);

        $query = Shortcode::withCount('services');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('shortcode', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $shortcodes = $query->latest()->paginate(15);

        return view('shortcodes.index', compact('shortcodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        abort_unless(auth()->user()?->can('service.create'), 403);

        return view('shortcodes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortcodeRequest $request): RedirectResponse
    {
        Shortcode::create($request->validated());

        return redirect()->route('shortcodes.index')
            ->with('success', 'Shortcode created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shortcode $shortcode): View
    {
        abort_unless(auth()->user()?->can('service.view'), 403);

        $shortcode->load('services');

        return view('shortcodes.show', compact('shortcode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shortcode $shortcode): View
    {
        abort_unless(auth()->user()?->can('service.update'), 403);

        return view('shortcodes.edit', compact('shortcode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShortcodeRequest $request, Shortcode $shortcode): RedirectResponse
    {
        $shortcode->update($request->validated());

        return redirect()->route('shortcodes.index')
            ->with('success', 'Shortcode updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shortcode $shortcode): RedirectResponse
    {
        abort_unless(auth()->user()?->can('service.delete'), 403);

        if ($shortcode->services()->count() > 0) {
            return redirect()->route('shortcodes.index')
                ->with('error', 'Cannot delete shortcode with associated services.');
        }

        $shortcode->delete();

        return redirect()->route('shortcodes.index')
            ->with('success', 'Shortcode deleted successfully.');
    }
}

