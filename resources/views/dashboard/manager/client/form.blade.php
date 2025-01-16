<div class="row">
    <div class="col-md-6">
        <x-form.input type="text" name="name" :value="old('name', $user->name)" label="{{ __('words.checkout_form_first_name_label') }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="text" name="last_name" :value="old('last_name', $user->last_name)" label="{{ __('words.checkout_form_lastname') }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="email" name="email" :value="old('email', $user->email)" label="{{ __('words.checkout_form_email') }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="tel" name="phone" :value="old('phone', $user->phone)" label="{{ __('words.invoice_tel') }}" />
    </div>
    <div class="col-md-12">
        <x-form.input type="file" name="avatar" label="{{ __('words.profile_image') }}" />
    </div>
    <div class="col-md-12">
        <x-form.input type="password" name="password" label="{{ __('words.password') }}" />
    </div>
    <div class="col-md-12">
        <button class="mt-5 btn btn-primary">
            + Add
        </button>
    </div>
</div>