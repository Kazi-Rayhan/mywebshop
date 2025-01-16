<x-dashboard.shop>

    <h3>{!! __('words.profile_sec_title') !!}</h3>
    <?php
    //dd($user->shop->logo)
    ?>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active"  data-bs-toggle="tab" id="company-tab" data-bs-target="#compnay" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true" onclick="storeLastActiveTab('company')">{{ __('words.company') }}</button>
            <button class="nav-link"  data-bs-toggle="tab" id="store-tab" data-bs-target="#store" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false" onclick="storeLastActiveTab('store')">{{ __('words.store') }}</button>
            <button class="nav-link"  data-bs-toggle="tab" id="payment-tab" data-bs-target="#payment" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false" onclick="storeLastActiveTab('payment')">{{ __('words.payment') }}</button>
            <button class="nav-link"  data-bs-toggle="tab" id="general-tab" data-bs-target="#general" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false" onclick="storeLastActiveTab('general')">{{ __('words.general') }}</button>
            <button class="nav-link"  data-bs-toggle="tab" id="menus-tab" data-bs-target="#menus" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false"  onclick="storeLastActiveTab('menus')">{{ __('words.menus') }}</button>
            <button class="nav-link"  data-bs-toggle="tab" id="settings-tab" data-bs-target="#settings" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false" onclick="storeLastActiveTab('settings')">{{ __('words.settings') }}</button>
            <button class="nav-link"  data-bs-toggle="tab" id="links-tab"  data-bs-target="#links" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false" onclick="storeLastActiveTab('links')">{{ __('words.links') }}</button>
            <button class="nav-link"  data-bs-toggle="tab" id="colors-tab"  data-bs-target="#colors" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false" onclick="storeLastActiveTab('colors')">{{ __('words.colors') }}</button>
        </div>
    </nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <form id="form" action="{{ route('shop.store.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body shadow-lg">

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="compnay" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                @include('dashboard.shop.profile.tabs.company_info_forms')
                            </div>
                            <div class="tab-pane fade" id="store" role="tabpanel" aria-labelledby="nav-profile-tab">
                                @include('dashboard.shop.profile.tabs.store_info_forms')
                            </div>
                            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="nav-contact-tab">
                                @include('dashboard.shop.profile.tabs.payment_info_forms')

                            </div>
                            <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="nav-contact-tab">
                                @include('dashboard.shop.profile.tabs.general_info_forms')

                            </div>
                            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="nav-contact-tab">
                                @include('dashboard.shop.profile.tabs.settings')

                            </div>
                            <div class="tab-pane fade" id="menus" role="tabpanel" aria-labelledby="nav-contact-tab">
                                @include('dashboard.shop.profile.tabs.menus',[
                                    'shop' => auth()->user()->shop,
                                ])

                            </div>
                            <div class="tab-pane fade" id="colors" role="tabpanel" aria-labelledby="nav-contact-tab">
                                @include('dashboard.shop.profile.tabs.colors',[
                                    'shop' => auth()->user()->shop,
                                ])

                            </div>
                            <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <livewire:links />

                            </div>
                            <button class="btn btn-primary" onclick="return $('#form').submit()"> <i class="fa fa-plus-square" aria-hidden="true"></i>
                                {!! __('words.change_btn') !!}</button>
                        </div>

                    </div>




            </div>
            </form>
        </div>
    </div>

    @push('styles')
        @livewireStyles
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @endpush
    @push('scripts')
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script>
            // Function to store the last active tab ID in local storage
            function storeLastActiveTab(tabId) {
                localStorage.setItem('lastActiveTab', tabId);
            }

            // Function to retrieve the last active tab ID from local storage
            function getLastActiveTab() {
                return localStorage.getItem('lastActiveTab');
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#terms').summernote({
                    height: 300
                });
                $('#description').summernote({
                    height: 300
                });

                const lastActiveTab = getLastActiveTab();

                console.log(document.getElementById(lastActiveTab + '-tab'));
                if (lastActiveTab) {
                    // Activate the last active tab
                    const lastActiveButton = document.getElementById(lastActiveTab + '-tab');
                    if (lastActiveButton) {
                        lastActiveButton.click();
                    }
                }

            });
        </script>
        <script>
            if ($("select[name='selling_location_mode']").val() < 1) {
                $('#locationsdiv').hide()
            }

            $("select[name='selling_location_mode']").change(e => {
                $('#locationsdiv').hide()
                if (e.target.value > 0) {
                    $('#locationsdiv').show()
                }
            })
        </script>
    @endpush
</x-dashboard.shop>
