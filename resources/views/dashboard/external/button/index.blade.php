<x-dashboard.external>
    <div class="card">
        <div class="card-body">
            <h3>{{ __('words.button_payment_title') }}</h3>

            <a class="btn btn-primary" href="{{ route('external.buttonPayment.create') }}">Create Button</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Domain
                        </th>
                        <th>
                            Success url
                        </th>
                        <th>
                            Failed url
                        </th>
                        <th>
                            key
                        </th>
                        <th>
                            Created at
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apis as $api)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $api->domain }}
                            </td>
                            <td>
                                {{ $api->success_redirect_url }}
                            </td>
                            <td>
                                {{ $api->failed_redirect_url }}
                            </td>
                            <td>
                                {{ $api->key }}
                            </td>
                            <td>
                                {{ $api->created_at }}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('external.buttonPayment.edit', $api) }}"><i class="fa fa-edit"></i>
                                    Edit</a>
                                <a href="{{ route('external.buttonPayment.view', $api) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard.external>
