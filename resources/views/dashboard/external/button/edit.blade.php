<x-dashboard.external>
    <div class="card">
        <div class="card-body">

            <form action="{{ route('external.buttonPayment.update', $paymentApi) }}" method="post">
    
                @csrf
                <x-form.input type="url" name="domain" label="Domain" value="{{ $paymentApi->domain }}" />
                <x-form.input type="url" name="success" label="Success redirect url"
                    value="{{ $paymentApi->success_redirect_url }}" />
                <x-form.input type="url" name="failed" label="Failed redirect url"
                    value="{{ $paymentApi->failed_redirect_url }}" />
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</x-dashboard.external>
