<div class="row mb-2">
    <div class="col-6">
    <label for="">{{__('words.kiosk')}}</label>
        <select name="meta[self_checkout]" id="" class="form-control">
        <option value="1" @if($user->shop->self_checkout == '1') selected @endif>{{__('words.yes')}}</option>
        <option value="0"  @if($user->shop->self_checkout != '1') selected @endif>{{__('words.no')}}</option>
        </select>
    </div>
    <div class="col-6">
        <x-form.input type='text' name='meta[self_checkout_pin]' label="PIN" :value="$user->shop->self_checkout_pin" />
    </div>
</div>

