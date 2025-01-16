  <div class="row">
      <div class="col-12">
          <x-form.input type="text" name="name" label="{{ __('words.dashboard_category_index_name') }}" value="{{ old('name') ?? @$priceGroup->name }}" />
      </div>
      <button class="btn btn-primary ml-3"> <i class="fa fa-plus-square" aria-hidden="true"></i> {{ __('words.save_btn') }}</button>
  </div>
