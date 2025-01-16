<x-dashboard.shop>
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {{ __('words.resourse_edit_sec_title')}}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.booking.resources.update', $resource) }}" method="POST">
                        @csrf
                        @method('put')
                        @include('dashboard.shop.booking.resources.include.fileds')
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function availableDays() {
                const x = document.getElementsByClassName('check');
                const mycheck = document.getElementById("mycheck");
                let i;
                if (mycheck.checked == true) {

                    for (i = 0; i < x.length; i++) {
                        x[i].style.display = 'none';
                    }
                } else {
                    for (i = 0; i < x.length; i++) {
                        x[i].style.display = 'inline';
                    }


                }
            }
        </script>
    @endpush
</x-dashboard.shop>
