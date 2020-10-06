<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMovingRequest;
use App\Http\Requests\StoreMovingRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdateMovingRequest;
use App\Models\Moving;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Stripe\SetupIntent;
use Symfony\Component\HttpFoundation\Response;

class MovingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('moving_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $movings = Moving::all();

        return view('admin.movings.index', compact('movings'));
    }

    public function create()
    {
        abort_if(Gate::denies('moving_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.movings.create', compact('users'));
    }

    public function store(StoreMovingRequest $request)
    {
        $moving = auth()->user()->create($request->validated());

        return redirect()->route('admin.movings.index');
    }

    public function edit(Moving $moving)
    {
        abort_if(Gate::denies('moving_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $moving->load('user');

        return view('admin.movings.edit', compact('users', 'moving'));
    }

    public function update(UpdateMovingRequest $request, Moving $moving)
    {
        $validatedData = $request->validated();

        if (auth()->user()->is_admin) {
            $price = $request->validate([
                'price' => 'required', 'numeric'
            ]);

            $validatedData = array_merge($validatedData, $price);
        }

        $moving->update($validatedData);

        return redirect()->route('admin.movings.index');
    }

    public function show(Moving $moving)
    {
        abort_if(Gate::denies('moving_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moving->load('user');

        $intent = auth()->user()->createSetupIntent();

        return view('admin.movings.show', compact('moving', 'intent'));
    }

    public function destroy(Moving $moving)
    {
        abort_if(Gate::denies('moving_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moving->delete();

        return back();
    }

    public function massDestroy(MassDestroyMovingRequest $request)
    {
        Moving::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function pay(StorePaymentRequest $request, Moving $moving)
    {
        $moving->load('user');
        $paymentMethod = $request->input('payment_method');

        try {
            $moving->user->createOrGetStripeCustomer();
            $moving->user->updateDefaultPaymentMethod($paymentMethod);
            $moving->user->charge($moving->price * 100, $paymentMethod);

            $moving->update([
                'paid_at' => now()
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }

        return redirect()->back()->with('message', 'The moving has been paid successfully');
    }
}
