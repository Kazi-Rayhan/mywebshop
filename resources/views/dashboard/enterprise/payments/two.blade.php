<x-dashboard.enterprise>
   
    <h3><span class="text-primary opacity-25"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
        {!! __('words.two_payment') !!}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <h3>Your bank account</h3>
                    <form action="{{ route('shop.store_setup_payment_two') }}" method="post">
                        @csrf
                        <div class="row">
                        
                            <div class="col-md-6 col-12">
                                <x-form.input name="name" type="name" label="Name" value="{{old('name')}}" />
                            </div>
                            <div class="col-md-6 col-12">
                                <x-form.input name="bban" type="text" label="BBAN" value="{{old('bban')}}" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-form.input name="iban" type="text" label="IBAN" value="{{old('iban')}}" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-form.input name="bic" type="text" label="BIC" value="{{old('bic')}}" />
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select name="country" id="country" class="form-control" required>
                                        @php
                                            $countries = [
                                                'NO' => 'Norway',
                                                'SE' => 'Sweden',
                                                'GB' => 'United Kingdom of Great Britain and Northern Ireland',
                                                'US' => 'United States of America',
                                                'NL' => 'Netherlands',
                                                'ES' => 'Spain',
                                            ];
                                        @endphp
                                        @foreach ($countries as $prefix => $country)
                                            <option value="{{ $prefix }}"
                                                @if (old('country') == $prefix) selected @endif>
                                                {{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.enterprise>
