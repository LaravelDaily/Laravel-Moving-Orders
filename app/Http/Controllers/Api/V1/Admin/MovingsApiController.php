<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovingRequest;
use App\Http\Requests\UpdateMovingRequest;
use App\Http\Resources\Admin\MovingResource;
use App\Models\Moving;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovingsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('moving_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MovingResource(Moving::with(['user'])->get());
    }

    public function store(StoreMovingRequest $request)
    {
        $moving = Moving::create($request->all());

        return (new MovingResource($moving))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Moving $moving)
    {
        abort_if(Gate::denies('moving_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MovingResource($moving->load(['user']));
    }

    public function update(UpdateMovingRequest $request, Moving $moving)
    {
        $moving->update($request->all());

        return (new MovingResource($moving))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Moving $moving)
    {
        abort_if(Gate::denies('moving_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moving->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
