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
    public function index()
    {
        $statudes = $this->statudeService->getAllStatutes();
        return view('statute.index', compact('statudes'));
    }

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
        $request->validated();
        $data = $request->all();
        Statute::create($data);
        return redirect()->route('orders.index')
            ->with('succes', 'Statute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show() //(Statute $statute)
    {
        $statute = Statute::where('valid', '1')->first();

        return view('statute.show', compact('statute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statute $statute)
    {
       // $statute = Statute::findOrFail(1);
        return view('statute.edit', compact('statute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatuteRequest $request, Statute $statute)
    {
        $request->validated();
        $data = $request->all();
        $statute->update($data);
        return redirect()->route('orders.index')
            ->with('success', 'Statute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statute $statute)
    {
        $statute->delete();
        return redirect()->route('orders.index')
            ->with('succes', 'Statute deleted successfully.');
    }
}
