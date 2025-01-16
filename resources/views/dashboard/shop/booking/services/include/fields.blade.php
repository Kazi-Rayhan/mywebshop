<div class="row">
    <div class="col-12">
       <div class="form-group">
           <label for="name">{{ __('words.dashboard_category_index_name') }}</label>
           <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('words.dashboard_category_index_name') }}" value="{{old('name',$service->name)}}" required>
       </div>
    </div>
    <div class="col-12">
        <label for="slug">{{ __('words.dashboard_slug') }}</label>
        <input id="slug" name="slug" type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="{{ __('words.dashboard_slug') }}" value="{{old('slug',$service->slug)}}">
    </div>


    <div class="col-12">
        <label for="details">{{ __('words.dashboard_details') }}</label>
        <textarea required class="form-control" id="details" name="details" rows="3">{!! old('details') ?? @$service->details !!}</textarea>
    </div>
    <div class="col-4 pt-2">
        
        <label for="resource">{{ __('words.resource_label') }}</label>
        <select id="resource" class="form-control" name="resource_id" required>
            <option value="">Choose resource...</option>
            @foreach ($resources as $resource)
            
                <option value="{{ $resource->id }}" {{ $service->resource->id === $resource->id ? 'selected' : null }}>
                    {{ $resource->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-4 pt-2">
        <x-form.input required  type="number" name="needed_time" label="{{ __('words.needed_times_label') }}" value="{{ old('needed_time') ?? @$service->needed_time }}" />
    </div>
    <div class="col-4">
        <x-form.input required  type="number" name="booking_per_slot" label="{{ __('words.boking_per_label') }}" value="{{ old('booking_per_slot') ?? @$service->booking_per_slot }}" />

    </div>
    {{-- <div class="col-6 pt-2">
        <x-form.input type="number" name="free_from" label="Free from" value="{{ old('free_from') ?? @$service->free_from }}" />
    </div>
    <div class="col-6 pt-2">
        <x-form.input type="number" name="free_to" label="Free to" value="{{ old('free_to') ?? @$service->free_to }}" />
    </div> --}}
    <div class="col-12 pt-4">
        <label for="">{{ __('words.dashboard_status') }}</label>
    </div>

    <div class="form-check form-check-inline ml-5">
        <input class="form-check-input" type="radio" name="status" {{old('status',$service->status) == 1 ? 'checked':''}} id="service-active" value="1">
        <label class="form-check-label" for="service-active">Active</label>
    </div>
    <div class="form-check form-check-inline ml-5 col-12">
        <input class="form-check-input" type="radio" name="status" id="service-deactive"  {{old('status',$service->status) == 0 ? 'checked':''}} value="0">
        <label class="form-check-label" for="service-deactive">Deactive</label>
    </div>

    <div class="col-6 pt-2">
        <h6>{{ __('words.service_stores_label') }}</h6>
        @foreach ($stores as $store)
            <div class="form-check">
                <label for="store-{{ $store->id }}" class="form-check-label">
                    <input type="checkbox" name="stores[]" class="form-check-input" value="{{ $store->id }}" id="store-{{ $store->id }}" {{ $service->stores->contains('id', $store->id) ? 'checked' : null }}>
                    {{ $store->city }} [ {{ $store->address }} ]
                </label>
            </div>
        @endforeach
    </div>

    <div class="col-6 pt-2">
        <h6>{{ __('words.dashboard_managers') }}</h6>
        @foreach ($managers as $manager)
            <div class="form-check">
                <label for="store-{{ $manager->id }}" class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="managers[]" value="{{ $manager->id }}" id="store-{{ $manager->id }}" {{ $service->managers->contains('id', $manager->id) ? 'checked' : null }} />
                    {{ $manager->full_name }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="col-12 pt-2">
        <label for="">{{ __('words.cart_table_price') }}</label>
    </div>
    <table class="table mx-3">
        <tbody>
            @foreach ($priceGroups as $parentPriceGroup)
                @php
                    $priceGroup = $service->getParentPriceGroup($parentPriceGroup->id);
                @endphp
                <tr>
                    <td>{{ $parentPriceGroup->name }}</td>
                    <td>
                        <div class="col-12">
                            <input type="number" name="prices[{{ $loop->index }}][price]" value="{{ $priceGroup->price }}" step="0.01" class="form-control" placeholder="Enter {{ $parentPriceGroup->name }} price" required/>
                        </div>
                    </td>
                </tr>
                <input type="hidden" name="prices[{{ $loop->index }}][parent_id]" value="{{ $parentPriceGroup->id }}" />
                <input type="hidden" name="prices[{{ $loop->index }}][service_id]" value="{{ $service->id }}" />
            @endforeach
        </tbody>
    </table>

    <div class="col-12 pt-2">
        <button class="btn btn-primary">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            {{ __('words.save_btn') }}
        </button>
    </div>
</div>
