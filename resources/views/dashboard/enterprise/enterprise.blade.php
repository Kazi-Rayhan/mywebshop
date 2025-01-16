<x-dashboard.enterprise>
    <h1>
        Payment Method
    </h1>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        {{ __('words.domain') }}
                    </th>
                    <th>
                        {{ __('words.paid_at') }}
                    </th>
                    <th>
                        {{ __('words.actions') }}
                    </th>
                </tr>
            
                    <tr>
                        <td>
                            {{ $enterprise->id }}
                        </td>
                        <td>
                            {{ $enterprise->company_domain }} <span
                                class="badge badge-{{ $enterprise->status ? 'success' : 'danger' }}">{{ $enterprise->status ? 'On' : 'Off' }}</span>

                        </td>
                        <td>

                            <span>{{ $enterprise->last_paid_at->format('d M, Y H:i') }}</span>
                        </td>
                        <td>
                           
                        </td>
                    </tr>

            </table>
        </div>
    </div>
</x-dashboard.enterprise>
