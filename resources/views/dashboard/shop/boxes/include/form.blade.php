 <div class="form-group">
     <label for="title">
         {{ __('words.subscription_index_title') }}
     </label>
     <input type="text" class="form-control @error('title') is-invalid @enderror"
         placeholder="{{ __('words.subscription_index_title') }}" name="title" value="{{ old('title') ?? $box->title }}">
 </div>
 <div class="row">
     <div class="col-md-6">
         <div class="form-group">
             <label for="title">
                 {!! __('words.estab_cost_label') !!}
             </label>
             <input type="number" class="form-control @error('est_cost') is-invalid @enderror"
                 placeholder="{!! __('words.estab_cost_label') !!}" name="est_cost" value="{{ old('est_cost') ?? $box->est_cost }}">
         </div>
     </div>
     <div class="col-md-6">
         <div class="form-group">
             <label for="title">
                 {!! __('words.cart_table_price') !!}
             </label>
             <input type="number" class="form-control @error('price') is-invalid @enderror"
                 placeholder="{!! __('words.cart_table_price') !!}" name="price" value="{{ old('price') ?? $box->price }}">
         </div>
     </div>
 </div>
 <div class="row">
     <div class="col-md-10">
         <div class="form-group">
             <label for="title">
                 {!! __('words.subs_create_duration_label') !!}
             </label>
             <input type="number" class="form-control @error('price') is-invalid @enderror"
                 placeholder=" {!! __('words.subs_create_duration_label') !!}" name="duration_length"
                 value="{{ old('duration_length') ?? @$box->duration->length }}">

         </div>
     </div>
     <div class="col-md-2 d-flex jusitfy-content-center align-items-center">

         @foreach (['Day', 'Month'] as $mode)
             <div class="form-check m-2">

                 <input class="form-check-input" name="duration_mode" type="radio" id="mode-{{ $mode }}"
                     value="{{ $mode }}" @if (@$box->duration->mode == $mode || $loop->first) checked @endif>
                 <label class="form-check-label" for="mode-{{ $mode }}">
                     {{ $mode }}
                 </label>
             </div>
         @endforeach
     </div>
 </div>
 <x-form.input type="textarea" name="description" label="{!! __('words.dashboard_description') !!}" :value="old('description') ?? @$box->description" />
 <div class="container">
     <div class="row">
         <div class=" @if (@$box->image) col-md-8 @else col-md-12 @endif">
             <x-form.input type="file" name="image" label="{!! __('words.dashboard_product_image') !!}" :value="old('price')" />
             @php $options = $shop->products->pluck('name','id') @endphp
             <x-form.input type="select" :options="$options" id="products" name="products[]" label="{!! __('words.products_sec_title') !!}" multiple="true"
                 selected="" />
         </div>
         @if (@$box->image)
             <div class="col-md-4 border border-dark">
                 <img src="{{ Iziibuy::image($box->image) }}" class="img-fluid" alt="{{ $box->title }}">
             </div>
         @endif
     </div>
 </div>
 <button class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i> {!! __('words.save_btn') !!}</button>

