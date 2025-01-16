<x-dashboard.enterprise>

    <div class="card">
        <div class="card-body">
            <form action="{{route('enterprise.update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input type='text' name='company_name' label="{{ __('words.company_name') }}"
                            value='{{ $enterprise->company_name }}' />
                    </div>
                    <div class="col-md-6">
                        <x-form.input type='text' name='company_domain' label="{{ __('words.company_website_url') }}"
                            value='{{ $enterprise->company_domain }}' />
                    </div>
                    <div class="col-md-12">
                        <x-form.input type='text' name='company_registration'
                            label="{{ __('words.company_registration') }}"
                            value='{{ $enterprise->company_registration }}' />
                    </div>
                    <div class="col-md-6">
                        <x-form.input type='text' name='company_email' label="{{ __('words.company_email') }}"
                            value='{{ $enterprise->company_email }}' />
                    </div>
                    <div class="col-md-6">
                        <x-form.input type="text" name="company_address[city]"
                            label="{{ __('words.company_address_city') }}" :value="@$enterprise->company_address->city" />
                    </div>

                    <div class="col-md-6">
                        <x-form.input type="text" name="company_address[street]"
                            label="{{ __('words.company_address_street') }}" :value="@$enterprise->company_address->street" />
                    </div>

                    <div class="col-md-6">
                        <x-form.input type="text" name="company_address[zip]"
                            label="{{ __('words.company_address_zip') }}" :value="@$enterprise->company_address->zip" />
                    </div>
                </div>
                <button class="btn btn-primary"> <i class="fa fa-save"></i> Update</button>
            </form>
        </div>
    </div>
</x-dashboard.enterprise>
