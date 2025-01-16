<x-shop-front-end>
    @push('style')
        @livewireStyles
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;700&display=swap');

            a {
                text-decoration: none;
            }

            .toggle {
                transition: .1s;
            }

            .toggle:hover {
                transform: rotate(180deg);
            }

            .toggle[data-active='true'] {
                transform: rotate(180deg);
            }

            .toggle[data-active='true']:hover {
                transform: rotate(0deg);
            }

            .baner {
                background: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)),
                    url("{{ asset('images/banner/banner.jpg') }}");
                background-repeat: no-repeat;
                height: 160px;
                background-position: center;
                background-size: cover;

            }

            .banner-title {
                font-family: 'Inter', sans-serif;
                font-style: italic;
                text-transform: uppercase;
                font-size: clamp(24px, 4vw, 28px);
                padding-top: 30px;
                font-weight: 900;
                color: #DEE1E2;
            }

            .banner-pera {
                font-weight: 100;
                margin-top: 10px;
                word-spacing: 4px;
                letter-spacing: 2px;
                color: #DEE1E2;
            }

            .notify-card {
                border-radius: 10px;
            }

            .notify-title {
                font-family: 'Inter', sans-serif;
                font-weight: 500;
                font-size: 18px;
            }

            .login_btn {
                text-decoration: underline !important;
                color: #555;
                margin-top: 8px;

            }

            .font {
                font-family: 'Inter', sans-serif;
            }


            .switch[type=checkbox] {
                height: 0;
                width: 0;
                visibility: hidden;
            }

            .switch-label {
                cursor: pointer;
                text-indent: -9999px;
                width: 60px;
                height: 30px;
                background: grey;
                display: block;
                border-radius: 100px;
                position: relative;
            }

            .switch-label:after {
                content: '';
                position: absolute;
                top: 5px;
                left: 5px;
                width: 20px;
                height: 20px;
                background: #fff;
                border-radius: 90px;
                transition: 0.3s;
            }

            .switch:checked+label {
                background: #bada55;
            }

            .switch:checked+label:after {
                left: calc(100% - 5px);
                transform: translateX(-100%);
            }

            .switch:active:after {
                width: 130px;
            }

            /* Hide the default checkbox */
            .hidden-checkbox {
                display: none;
            }

            /* Style the checkbox button */
            .checkbox-button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                color: #fff;
                /* Change to your desired text color */
                background-color: #fff;
                /* Change to your desired background color */
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            /* Style the checkbox button when checked */
            .hidden-checkbox:checked+.checkbox-button {
                border: 2px solid #4CAF50;
                /* Change to your desired border color when checked */
            }

            .sticky-container {
                position: relative;
            }

            #sticky {
                position: -webkit-sticky;
                position: sticky;
                top: 150px;
                /* Adjust this value as needed */
            }
        </style>
    @endpush
    <livewire:personal-trainers :session="$session" :shop="$shop" :trainer="$trainer" />
    <div class="modal fade" id="schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {{ __('words.schedule') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div id="calander">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 p-1 col-sm-12 col-lg-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <p class="ml-3 mb-4 today_date">{{ now()->format('D, d F') }}</p>
                                <div id="events"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('simple-calender/jquery.simple-calendar.js') }}"></script>
        <script>
            const months = [
                "January", "February",
                "March", "April", "May",
                "June", "July", "August",
                "September", "October",
                "November", "December"
            ];
            $("#calander").simpleCalendar({
                onDateSelect: function(date, events) {
                    let mont_name = months[date.getMonth()]
                    let day = date.getDate()
                    let daye_name = date.toLocaleDateString('en-US', {
                        weekday: 'long'
                    })
                    let new_date = date.toLocaleDateString("en-US");
                    $('.today_date').text(daye_name + ', ' + day + ' ' + mont_name);
                    fetchEvent(new_date)
                }
            });
        </script>
        @livewireScripts

        <script>
            document.user = {}
        </script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script>
            $('.old_day').prop('disabled', true);
        </script>
        <script>
            let shop = "{{ request('user_name') }}";
            let reschedule = "{{ request('reschedule') }}";
            let baseUrl = `${window.location.origin}`;

            let option = "{{ @$shop->defaultOption->id }}";

            const fetchEvent = (date) => {
                var currentUrl = baseUrl + `/shop/${shop}/services/${document.user.id}/${option}/schedule`;
                var url = new URL(currentUrl);
                url.searchParams.set("date", date);
                $.ajax({
                    headers: {
                        Accept: "application/json",
                    },
                    url: url,
                }).done(({
                    events
                }) => {

                    let events_html = '';
                    if (events.length > 0) {
                        events.map((event) => {
                            events_html += `
                <div class='col-12 mb-3'>
                    <a type="button"  class='border border-primary d-block text-center p-2 font-weight-bold text-primary rounded'>
                        ${event.name}
                    </a>
                </div>`;
                            //console.log()
                        })
                    } else {
                        events_html =
                            `<div class="border text-center p-2 rounded m-2">No Events Found.Please select a new date</div>`;
                    }

                    $('#events').html(events_html);
                });

            }
        </script>



        <script>
            $('#schedule').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget) // Button that triggered the modal
                document.user.id = button.data('user') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

                fetchEvent("{{ now()->format('m/d/Y') }}");
            })
        </script>

        <script>
            const disableRegister = () => {
                [...document.querySelectorAll("input[name ^='user[register]']")].map(el => {
                    el.disabled = true
                });

                [...document.querySelectorAll("input[name ^='user[login]']")].map(el => {
                    el.disabled = false
                });
            }

            const disableLogin = () => {
                [...document.querySelectorAll("input[name ^='user[register]']")].map(el => {
                    el.disabled = false
                });

                [...document.querySelectorAll("input[name ^='user[login]']")].map(el => {
                    el.disabled = true
                });
            }
        </script>
        <script>
            const toggle = (e) => {
                if (e.dataset.active == 'true') {
                    e.dataset.active = 'false'
                    document.getElementById(e.dataset.toggle).classList.remove('show');
                } else {
                    document.getElementById(e.dataset.toggle).classList.add('show');
                    e.dataset.active = 'true'
                }
            }

            $(document).ready(function() {
                $("input[name='label']").click(function() {
                    var labelValue = $("input[name='label']:checked").val();
                    let labelShowvalue = document.getElementById('labelShowVal');
                    labelShowvalue.innerText = labelValue;

                });
            });
            $(document).ready(function() {
                $("input[name='session']").click(function() {

                    var sessionValue = $("input[name='session']:checked").val();

                    let sessionShowVal = document.getElementById('sessionShowVal');
                    sessionShowVal.innerText = sessionValue;


                });
            });
            document.getElementById("paginateBtn").addEventListener("click", function() {
                const paginate = document.getElementById('paginateSessions');
                paginate.style.display = 'block';
            });
        </script>
        <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const trainer_cofirm = () => {
                Swal.fire({
                    title: "{{ __('words.personal_trainer_book') }}",
                    text: "{{ __('words.personal_trainer_title') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('words.personal_trainer_alert_confirm') }}",
                    cancelButtonText: "{{ __('words.personal_trainer_alert_cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('trainer-form').submit();
                    }
                })
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function scrollToElement(elementId) {

                $('html, body').animate({
                    scrollTop: $(elementId).offset().top - 250
                }, 1000); // Adjust the animation speed as needed
            }


            // Hook into Livewire's afterDOMUpdate event
            document.addEventListener("livewire:load", function() {

                $('[wire\\:click]').click(function() {
                    var scrollToId = $(this).data('scroll-to');
                    if (scrollToId) {
                        scrollToElement(scrollToId);
                    }
                });
                $('[wire\\:model]').click(function() {
                    var scrollToId = $(this).data('scroll-to');
                    if (scrollToId) {
                        scrollToElement(scrollToId);
                    }
                });

            });
        </script>
    @endpush
</x-shop-front-end>
