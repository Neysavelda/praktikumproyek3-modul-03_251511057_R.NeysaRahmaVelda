<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
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
        $status = $request->query('status');
        $validStatuses = ['Planned', 'Ongoing', 'Done'];

        $activities = Activity::query()
            ->when(
                in_array($status, $validStatuses, true),
                fn ($query) => $query->where('status', $status)
            )
            ->orderBy('activity_date')
            ->get();

        return view('activities.index', compact('activities'));
    }

    public function create(): View
    {
        return view('activities.create');
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $this->activityService->create($request->validated());

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', compact('activity'));
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
