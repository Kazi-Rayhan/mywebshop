<x-shop-front-end>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/custom/checkout.css') }}">
        <style>
            .single-banner {
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                padding: 100px 0px;
                position: relative;
                z-index: 1;
            }
        </style>
    @endpush

    <section class="checkout-part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-charge">
                        <ul>
                            <li>
                                <span>{{ __('words.service') }} {{ __('words.dashboard_category_index_name') }}</span>
                                <span>{{ $service->name }}</span>
                            </li>
                            <li>
                                <span>{{ __('words.dashboard_managers') }}</span>
                                <span>{{ $manager->full_name }}</span>
                            </li>
                            <li>
                                <span>{{ __('words.cart_table_price') }}</span>
                                <span>{{ Iziibuy::price($service->price($manager)) }} NOK</span>
                            </li>
                            <li>
                                <span>{{ __('words.appointment') }} {{ __('words.charge_at') }}</span>
                                <span>
                                    {{ $booking->format('M d, Y') }} at
                                    {{ $booking->format('h:ia') }} -
                                    {{ $booking->copy()->addMinutes($service->needed_time)->format('h:ia') }}

                                </span>
                            </li>

                            <li>
                                <form
                                    action="{{ route('service.checkout', [request('user_name'), $service->slug, $manager]) }}"
                                    method="POST" id="confirm-form">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ request('date') }}">
                                    <input type="hidden" name="time" value="{{ request('time') }}">
                                    <span>
                                        <button class="btn btn-success btn-sm">{{ __('words.confirm_btn') }}</button>
                                    </span>
                                </form>
                                <span></span>
                                {{-- <form action="{{ route('service.checkout', [request('user_name'), $service->slug, $manager,'continue'=>true]) }}" method="POST" id="confirm-form">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ request('date') }}">
                                    <input type="hidden" name="time" value="{{ request('time') }}">
                                    <span>
                                        <button class="btn btn-success btn-sm">{{ __('words.continue_shiping') }}</button>
                                    </span>
                                </form> --}}

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('confirm-form').addEventListener('submit', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then(({
                    isConfirmed
                }) => {
                    if (isConfirmed) {
                        e.target.submit();
                    }
                })
            })
        </script>
    @endpush
</x-shop-front-end>
