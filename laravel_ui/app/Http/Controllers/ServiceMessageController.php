<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceMessageRequest;
use App\Http\Requests\UpdateServiceMessageRequest;
use App\Models\Service;
use App\Models\ServiceMessage;
use App\Models\Shortcode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        abort_unless(auth()->user()?->can('service_message.view'), 403);

        $query = ServiceMessage::with('service.shortcode');

        if ($request->filled('shortcode_id')) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('shortcode_id', $request->shortcode_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('service', function ($q) use ($search) {
                $q->whereHas('shortcode', function ($sq) use ($search) {
                    $sq->where('shortcode', 'like', "%{$search}%");
                })->orWhere('keyword', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(15);
        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();

        return view('service-messages.index', compact('messages', 'shortcodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        abort_unless(auth()->user()?->can('service_message.create'), 403);

        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();

        return view('service-messages.create', compact('shortcodes'));
    }

    /**
     * Get keywords for a shortcode (AJAX endpoint).
     */
    public function getKeywords(Shortcode $shortcode): JsonResponse
    {
        $keywords = Service::where('shortcode_id', $shortcode->id)
            ->where('status', 'active')
            ->orderBy('keyword')
            ->get(['id', 'keyword'])
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'keyword' => $service->keyword,
                ];
            });

        return response()->json($keywords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceMessageRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Resolve service_id from shortcode_id + keyword
        $service = Service::where('shortcode_id', $data['shortcode_id'])
            ->where('keyword', $data['keyword'])
            ->where('status', 'active')
            ->firstOrFail();
        
        $data['service_id'] = $service->id;
        unset($data['shortcode_id'], $data['keyword']);

        ServiceMessage::create($data);

        return redirect()->route('service-messages.index')
            ->with('success', 'Service message created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceMessage $serviceMessage): View
    {
        abort_unless(auth()->user()?->can('service_message.update'), 403);

        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();
        $serviceMessage->load('service.shortcode');

        return view('service-messages.edit', compact('serviceMessage', 'shortcodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceMessageRequest $request, ServiceMessage $serviceMessage): RedirectResponse
    {
        $data = $request->validated();
        
        // Resolve service_id from shortcode_id + keyword
        $service = Service::where('shortcode_id', $data['shortcode_id'])
            ->where('keyword', $data['keyword'])
            ->where('status', 'active')
            ->firstOrFail();
        
        $data['service_id'] = $service->id;
        unset($data['shortcode_id'], $data['keyword']);

        $serviceMessage->update($data);

        return redirect()->route('service-messages.index')
            ->with('success', 'Service message updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceMessage $serviceMessage): RedirectResponse
    {
        abort_unless(auth()->user()?->can('service_message.delete'), 403);

        $serviceMessage->delete();

        return redirect()->route('service-messages.index')
            ->with('success', 'Service message deleted successfully.');
    }
}

