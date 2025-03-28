<label>Country</label>
<div class="row">
    @if($value->payment && json_decode($value->payment->country, true))

        @foreach(json_decode($value->payment->country, true) as $key => $pay_cur)

            <div class="col-lg-3">
                <div class="form-check">
                    @if($value->country_hide_id &&  json_decode($value->country_hide_id, true) && in_array($pay_cur, json_decode($value->country_hide_id, true)))

                    <input class="form-check-input redio-border" type="checkbox" name="country_hide_id[]" value="{{$pay_cur}}" id="country{{$key}}" checked>
                    <label class="form-check-label" for="country{{$key}}">
                        {{App\Models\Countrie::whereId($pay_cur)->value('name')}}
                    </label>

                    @else

                    <input class="form-check-input redio-border" type="checkbox" name="country_hide_id[]" value="{{$pay_cur}}" id="country{{$key}}">
                    <label class="form-check-label" for="country{{$key}}">
                        {{App\Models\Countrie::whereId($pay_cur)->value('name')}}
                    </label>

                    @endif
                    
                </div>
            </div>

        @endforeach

    @endif
   
</div>

<div class="mt-4">
    <label>Currency</label>
    <div class="row">
        @if($value->payment && json_decode($value->payment->currency, true))

            @foreach(json_decode($value->payment->currency, true) as $cc => $pay_curr)

                <div class="col-lg-3">
                    <div class="form-check">

                        @if($value->currency_hide_id && json_decode($value->currency_hide_id, true) && in_array($pay_curr, json_decode($value->currency_hide_id, true)))
                        <input class="form-check-input redio-border" type="checkbox" name="currency_hide_id[]" value="{{$pay_curr}}" id="currency{{$cc}}" checked>
                        <label class="form-check-label" for="currency{{$cc}}">
                            {{App\Models\Currencies::whereId($pay_curr)->value('symbol')}}
                        </label>
                        @else
                        <input class="form-check-input redio-border" type="checkbox" name="currency_hide_id[]" value="{{$pay_curr}}" id="currency{{$cc}}">
                        <label class="form-check-label" for="currency{{$cc}}">
                            {{App\Models\Currencies::whereId($pay_curr)->value('symbol')}}
                        </label>
                        @endif
                    </div>
                </div>

            @endforeach

        @endif

    </div>
</div>
<input type="hidden" name="client_payment_id" value="{{ $value->id }}">