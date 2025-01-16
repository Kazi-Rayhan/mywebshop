<x-dashboard.shop>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    @endpush
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {{ __('words.service_edit_sec_title') }}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.booking.services.update', $service) }}" method="POST">
                        @csrf
                        @method('put')
                        @include('dashboard.shop.booking.services.include.fields')
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
        <script>
            $(document).ready(function() {

                var multipleCancelButton = new Choices('#manager', {
                    removeItemButton: true,
                    maxItemCount: 5,
                    searchResultLimit: 5,
                    renderChoiceLimit: 5
                });


            });
        </script>
        <script>
            $('#name').keyup(function() {
                $('#slug').val(slug($(this).val()));
            });

            function slug(str) {
                str = str.replace(/^\s+|\s+$/g, ''); // trim
                str = str.toLowerCase();

                // remove accents, swap ñ for n, etc
                var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
                var to = "aaaaaeeeeeiiiiooooouuuunc------";
                for (var i = 0, l = from.length; i < l; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }

                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes

                return "{{ auth()->user()->shop->user_name . '-' . 'SERVICE' . '-' }}".toLowerCase() + str;
            };
        </script>
    @endpush
</x-dashboard.shop>
