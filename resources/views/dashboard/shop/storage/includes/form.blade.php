<div class="row">
    <div class="form-group col-12 col-md-4">
        <label for="city">{!! __('words.city') !!}</label>
        <input type="text" id="city" name="city" class="form-control" value="{{ old('city') ?? $storage->city }}">
    </div>

    <div class="form-group col-12 col-md-4">
        <label for="state">{!! __('words.state') !!}</label>
        <input type="text" id="state" name="state" class="form-control"
            value="{{ old('state') ?? $storage->state }}">
    </div>

    <div class="form-group col-12 col-md-4">
        <label for="post">{!! __('words.invoice_postcode') !!}</label>
        <input type="text" id="post" name="post_code" class="form-control"
            value="{{ old('post_code') ?? $storage->post_code }}">
    </div>
</div>
<div class="row">
    <div class="form-group col-12">
        <label for="address">{!! __('words.invoice_address') !!}</label>
        <textarea name="address" class="form-control" id="address" name="address" cols="30" rows="5 ">{{ old('address') ?? $storage->address }}</textarea>
    </div>
</div>

<button class="btn btn-outline-primary">
    {!! __('words.save_btn') !!}
</button>
