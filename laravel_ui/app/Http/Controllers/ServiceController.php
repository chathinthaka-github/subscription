<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\Shortcode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        abort_unless(auth()->user()?->can('service.view'), 403);

        $query = Service::with('shortcode');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('keyword', 'like', "%{$search}%")
                    ->orWhereHas('shortcode', function ($sq) use ($search) {
                        $sq->where('shortcode', 'like', "%{$search}%");
                    });
            });
        }

        $services = $query->latest()->paginate(15);

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        abort_unless(auth()->user()?->can('service.create'), 403);

        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();

        return view('services.create', compact('shortcodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Service::create($request->validated());

        return redirect()->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): View
    {
        abort_unless(auth()->user()?->can('service.view'), 403);

        $service->load('shortcode');

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        abort_unless(auth()->user()?->can('service.update'), 403);

        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();
        $service->load('shortcode');

        return view('services.edit', compact('service', 'shortcodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->validated();
        
        // Explicitly handle fpmt_enabled checkbox (checkboxes don't send value when unchecked)
        $data['fpmt_enabled'] = $request->has('fpmt_enabled') ? 1 : 0;
        
        $service->update($data);

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        abort_unless(auth()->user()?->can('service.delete'), 403);

        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }
}

