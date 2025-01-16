<x-dashboard.enterprise>
    @push('styles')
        <script async src="https://tally.so/widgets/embed.js"></script>
    @endpush
    <div class="container ">
        <div class="card mt-5 mx-auto p-5">

            <div class="card-body">
                <table class="table table-bordered  w-50 mx-auto">
                    <thead>
                        <tr>
                            <th colspan="2">
                                <h4 class="text-center" style="font-family: Verdana, Geneva, Tahoma, sans-serif">
                                    {{ __('words.company_information') }}
                                </h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                                {{ __('words.name') }} :
                            </th>
                            <td>
                                {{ $enterprise->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('words.business_address') }} :
                            </th>
                            <td>
                                {{ $enterprise->businessAddress }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ __('words.contact_phone') }} :
                            </th>
                            <td>
                                {{ $enterprise->contact_phone }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('words.contact_person') }} :
                            </th>
                            <td>
                                {{ $enterprise->contactPerson }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('words.contact_email') }} :
                            </th>
                            <td>
                                {{ $enterprise->contact_email }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('words.company_name') }} :
                            </th>
                            <td>
                                {{ $enterprise->company_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('words.comapny_address') }} :
                            </th>
                            <td>
                                {{ $enterprise->comapny_address }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('enterprise.verify_elavon_payment_information') }}"
                                        class="btn btn-success btn-block" style="background-color: #3445b4">
                                        {{ __('words.verify_company_information') }}</a>

                                    <a href="{{ route('enterprise.setup_elavon_payment') }}"
                                        class="btn btn-dark btn-block">{{ __('words.change_information') }}</a>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>


        </div>


    </div>
</x-dashboard.enterprise>
