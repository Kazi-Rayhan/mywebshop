<x-dashboard.enterprise>
   
    <div class="row mt-5">
        <div class="col-md-12   mt-2">
            <div class="card">
                <div class="card-body">
                    <table class="table">

                        <tr>
                            <th>
                                Date
                            </th>
                            <th>
                                Amount
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        @foreach ($charges as $charge)
                            <tr>
                                <td>
                                    {{ $charge->created_at->format('d M, Y H:i') }}
                                </td>
                                <td>
                                    {{ Iziibuy::price($charge->amount) }}
                                </td>
                                <td>
                                    <span
                                        class="badge badge-{{ $charge->status ? 'success' : 'danger' }}">{{ $charge->status ? 'Paid' : 'Unpaid' }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-primary" title="{{ __('wrods.invoice') }}"
                                        href="{{ route('enterprise.download.invoice', $charge) }}"><i
                                            class="fa fa-receipt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>

                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function copyKey(el) {
                // Get the text field
                var copyText = el;


                // Select the text field

                // Copy the text inside the text field
                navigator.clipboard.writeText(copyText.dataset.text);

                // Alert the copied text
                alert("Copied the text: " + copyText.dataset.text);
            }
        </script>
    @endpush
</x-dashboard.enterprise>
