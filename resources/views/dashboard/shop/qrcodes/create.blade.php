<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {!! __('words.qrcodes') !!}
    </h3>

    <div class="container">
        <div class="card">

            <div class="card-body">
                <form action="{{ route('shop.qrcodes.store') }}" method="post">
                    @csrf
                    <x-form.input type="text" name="code" label="{{__('words.mailchimp_list_id')}}" value="{{ old('code') }}" />
                    <button class="btn btn-primary">
                        {{ __('words.save') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-dashboard.shop>
