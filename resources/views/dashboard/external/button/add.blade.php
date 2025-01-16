<x-dashboard.external>
    <div class="card">
        <div class="card-body">

            <form action="{{ route('external.buttonPayment.store') }}" method="post">
                @csrf
                <x-form.input type="url" name="domain" label="Domain" />
                <x-form.input type="url" name="success" label="Success redirect url" />
                <x-form.input type="url" name="failed" label="Failed redirect url" />
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</x-dashboard.external>
