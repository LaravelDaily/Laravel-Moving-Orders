@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.moving.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.movings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.id') }}
                        </th>
                        <td>
                            {{ $moving->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.user') }}
                        </th>
                        <td>
                            {{ $moving->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.moving_from') }}
                        </th>
                        <td>
                            {{ $moving->moving_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.moving_to') }}
                        </th>
                        <td>
                            {{ $moving->moving_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.moving_date') }}
                        </th>
                        <td>
                            {{ $moving->moving_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.comments') }}
                        </th>
                        <td>
                            {{ $moving->comments }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.price') }}
                        </th>
                        <td>
                            {{ $moving->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moving.fields.paid_at') }}
                        </th>
                        <td>
                            {{ $moving->paid_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.movings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@if(!$moving->paid_at && $moving->price && auth()->user()->id == $moving->user_id)
    <div class="card">
        <div class="card-header">Pay Now</div>
        <div class="card-body">
            <p>The price of a moving is ${{ $moving->price }}.</p>
            <form method="POST" action="{{ route('admin.movings.pay', $moving) }}" class="card-form mt-3 mb-3">
                @csrf
                <input type="hidden" name="payment_method" class="payment-method">
                <input class="StripeElement mb-3" name="card_holder_name" placeholder="Card holder name" required>
                <div class="col-md-4">
                    <div id="card-element"></div>
                </div>
                <div id="card-errors" role="alert"></div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary pay">
                        Pay
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
@endsection
@section('styles')
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
@endsection
@section('scripts')
@if(!$moving->paid_at && $moving->price && auth()->user()->id == $moving->user_id)
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let stripe = Stripe("{{ env('STRIPE_KEY') }}")
        let elements = stripe.elements()
        let style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
        let card = elements.create('card', {style: style})
        card.mount('#card-element')
        let paymentMethod = null
        $('.card-form').on('submit', function (e) {
            $('button.pay').attr('disabled', true)
            if (paymentMethod) {
                return true
            }
            stripe.confirmCardSetup(
                "{{ $intent->client_secret }}",
                {
                    payment_method: {
                        card: card,
                        billing_details: {name: $('.card_holder_name').val()}
                    }
                }
            ).then(function (result) {
                if (result.error) {
                    $('#card-errors').text(result.error.message)
                    $('button.pay').removeAttr('disabled')
                } else {
                    paymentMethod = result.setupIntent.payment_method
                    $('.payment-method').val(paymentMethod)
                    $('.card-form').submit()
                }
            })
            return false
        })
    </script>
@endif
@endsection