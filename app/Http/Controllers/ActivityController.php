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

    public function index(Request $request)
{
    // 1. Mulai catat query SQL
    \Illuminate\Support\Facades\DB::enableQueryLog();

    // 2. Eksekusi query dengan eager loading (with category)
    $activities = Activity::with('category')->paginate(5);

    // 3. Tampilkan log query ke layar
    dd(\Illuminate\Support\Facades\DB::getQueryLog());
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

    public function destroyCategory(Category $category): RedirectResponse
    {
        if ($category->activities()->exists()) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh kegiatan.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function publish(Activity $activity, ActivityService $service)
    {
        $service->publish($activity);
        return redirect()->back()->with('success', 'Kegiatan berhasil dipublikasikan!');
    }

    public function complete(Activity $activity, ActivityService $service)
    {
        $service->complete($activity);
        return redirect()->back()->with('success', 'Kegiatan telah diselesaikan!');
    }

    public function trashed(): View
    {
        $activities = Activity::onlyTrashed()->with('category')->paginate(5);
        return view('activities.trashed', compact('activities'));
    }

    public function restore($id): RedirectResponse
    {
        $this->activityService->restore($id);
        return redirect()->route('activities.trashed')->with('success', 'Kegiatan berhasil dipulihkan!');
    }

    public function forceDelete($id): RedirectResponse
    {
        $this->activityService->forceDelete($id);
        return redirect()->route('activities.trashed')->with('success', 'Kegiatan berhasil dihapus permanen!');
    }
}