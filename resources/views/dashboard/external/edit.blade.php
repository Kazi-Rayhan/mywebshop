<x-dashboard.external>

    <div class="card">
        <div class="card-body">
            <form action="{{route('external.update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input type='text' name='company_name' label="{{ __('words.company_name') }}"
                            value='{{ $paymentMethodAccess->company_name }}' />
                    </div>
                    <div class="col-md-6">
                        <x-form.input type='text' name='company_domain' label="{{ __('words.company_website_url') }}"
                            value='{{ $paymentMethodAccess->company_domain }}' />
                    </div>
                    <div class="col-md-12">
                        <x-form.input type='text' name='company_registration'
                            label="{{ __('words.company_registration') }}"
                            value='{{ $paymentMethodAccess->company_registration }}' />
                    </div>
                    <div class="col-md-6">
                        <x-form.input type='text' name='company_email' label="{{ __('words.company_email') }}"
                            value='{{ $paymentMethodAccess->company_email }}' />
                    </div>
                    <div class="col-md-6">
                        <x-form.input type="text" name="company_address[city]"
                            label="{{ __('words.company_address_city') }}" :value="@$paymentMethodAccess->company_address->city" />
                    </div>

                    <div class="col-md-6">
                        <x-form.input type="text" name="company_address[street]"
                            label="{{ __('words.company_address_street') }}" :value="@$paymentMethodAccess->company_address->street" />
                    </div>

                    <div class="col-md-6">
                        <x-form.input type="text" name="company_address[zip]"
                            label="{{ __('words.company_address_zip') }}" :value="@$paymentMethodAccess->company_address->zip" />
                    </div>
                </div>
                <button class="btn btn-primary"> <i class="fa fa-save"></i> Update</button>
            </form>
        </div>
    </div>
</x-dashboard.external>
