<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category; 
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index(Request $request): View
    {
        $search   = $request->query('search');
        $category = $request->query('category_id');
        $status   = $request->query('status');
        $sort     = $request->query('sort', 'latest'); // default sorting terbaru

        $activities = Activity::query()
            ->with('category')
            // Filter Search (Judul atau Deskripsi)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            // Filter Kategori
            ->when($category, fn ($query) => $query->where('category_id', $category))
            // Filter Status
            ->when(
                in_array($status, ['draft', 'published', 'completed'], true),
                fn ($query) => $query->where('status', $status)
            )
            // Sorting
            ->when($sort === 'oldest', fn ($query) => $query->orderBy('created_at', 'asc'))
            ->when($sort === 'latest', fn ($query) => $query->orderBy('created_at', 'desc'))
            // Pagination dengan membawa parameter query (PENTING!)
            ->paginate(5)
            ->withQueryString();

        $categories = Category::all();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('activities.create', compact('categories'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $this->activityService->create($request->validated());

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function show(Activity $activity): View
    {
        $activity->load('category');
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        $categories = Category::all();
        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        try {
            $this->activityService->update($activity, $request->validated());

            return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui');
        } catch (DomainException $e) {
            return back()->withInput()->withErrors(['status' => $e->getMessage()]);
        }
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus');
    }
}