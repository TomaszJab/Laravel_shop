<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statute;
use Illuminate\Support\Str;
use App\Http\Requests\StatuteRequest;

//use App\Http\Requests\StatuteRequest;

class StatuteService extends Controller
{
    public function getAllStatuteTransformContentAndPaginate($paginate)
    {
        $statutes = Statute::paginate($paginate);
        $statutes->getCollection()->transform(function ($item) {
            $item->content = Str::limit($item->content, 20, '...');
            return $item;
        });
        return $statutes;
    }

    public function store(StatuteRequest $request)
    {
        $request->validated();
        $data = $request->all();

        $this->setActualStatuteAsValid($data['valid']);

        Statute::create($data);
    }

    public function update(StatuteRequest $request, Statute $statute)
    {
        $request->validated();
        $data = $request->all();
        $this->setActualStatuteAsValid($data['valid']);

        $statute->update($data);
    }

    public function destroy(Statute $statute)
    {
        $statute->delete();
    }

    public function getValidStatude()
    {
        $statute = Statute::where('valid', '1')->first();
        return $statute;
    }

    private function setActualStatuteAsValid(bool $valid)
    {
        if ($valid === true) {
            Statute::where('valid', '1')->update(['valid' => '0']);
        }
    }
}
