<x-dashboard.shop>

    <h3>{{ __('words.group_create_sec_title') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.levels.update', $level) }}" method="POST">
                        @method('put')
                        @csrf
                        @include('dashboard.shop.levels.include.fields')

                        <button class="btn btn-primary ml-3"> <i class="fa fa-plus-square" aria-hidden="true"></i>
                            {{ __('words.save_btn') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>
