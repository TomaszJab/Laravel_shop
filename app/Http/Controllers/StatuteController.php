<?php

namespace App\Http\Controllers;

use App\Models\Statute;
use Illuminate\Http\Request;
use App\Http\Services\StatuteService;
use App\Http\Requests\StatuteRequest;

class StatuteController extends Controller
{
    protected StatuteService $statudeService;

    public function __construct(StatuteService $statudeService)
    {
        $this->statudeService = $statudeService;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
        //
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('statute.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatuteRequest $request)
    {
        $this->statudeService->store($request);

        return redirect()->route('orders.index')
            ->with('succes', 'Statute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Statute $statute)
    {
        return view('statute.show', compact('statute'));
    }

    public function showValid()
    {
        $statute = $this->statudeService->getValidStatude();

        return view('statute.show', compact('statute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statute $statute)
    {
        return view('statute.edit', compact('statute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatuteRequest $request, Statute $statute)
    {
        $statute = $this->statudeService->update($request, $statute);

        return redirect()->route('orders.index')
            ->with('success', 'Statute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statute $statute)
    {
        $this->statudeService->destroy($statute);

        return redirect()->route('orders.index')
            ->with('succes', 'Statute deleted successfully.');
    }
}
