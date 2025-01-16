<x-dashboard.external>
    @push('styles')
        <style>
            fieldset.scheduler-border {
                border: 1px groove #ddd !important;
                padding: 0 1.4em 1.4em 1.4em !important;
                margin: 0 0 1.5em 0 !important;
                -webkit-box-shadow: 0px 0px 0px 0px #000;
                box-shadow: 0px 0px 0px 0px #000;
            }

            legend.scheduler-border {
                font-size: 1.2em !important;
                font-weight: bold !important;
                text-align: left !important;
                width: inherit;
            }

            #signature-pad {
                border: 1px solid #000;
            }

            /* #clear-button,
                                                                                                                                                                            #save-button {
                                                                                                                                                                                margin-top: 10px;
                                                                                                                                                                            } */
        </style>
    @endpush
 
    
    <div class="container mt-5">
        <form action="{{ route('external.store_setup_elavon_payment') }}" method="post">
            @csrf
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">{{ __('words.company_information') }}</legend>
                <div class="form-group">
                    {{-- <label for="legalName">Juridisk navn</label>
                    <input type="text" class="form-control" id="legalName" name="legalName" required> --}}
                    <x-form.input type="text" label="{{ __('words.legal_name') }}" :value="$external->user->fullName" name="meta[name]"
                        id="legalName" />
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <x-form.input type="text" label="{{ __('words.business_address') }}" :value="$external->addressFull"
                            name="meta[businessAddress]" id="businessAddress" required />

                    </div>

                    <div class="form-group col-md-6">
                        <x-form.input type="tel" label="{{ __('words.telephone_number') }}" :value="$external->user->phone"
                            name="meta[contact_phone]" id="phoneNumber" required />

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <x-form.input type="text" :value="$external->user->fullName"
                            label="{{ __('words.contact_person_first_last_name') }} " name="meta[contactPerson]"
                            id="contactPerson" required />

                    </div>

                    <div class="form-group col-md-6">
                        <x-form.input type="email" label="{{ __('words.email') }}" :value="$external->company_email"
                            name="meta[contact_email]"  id="email" required />

                    </div>
                </div>

                <div class="form-group">
                    <x-form.input type="text" label="{{ __('words.outlet_name') }}" :value="$external->company_name"
                        name="meta[company_name]" id="outletName" required />

                </div>

                <div class="form-group">
                    <x-form.input type="text" :value="$external->addressFull" label="{{ __('words.outlet_address') }}"
                        name="meta[comapny_address]" id="outletAddress" required />

                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <x-form.input type="text" label="{{ __('words.domainIfAvailable') }}"
                            name="meta[trading][domain]" id="domain" required :value="$external->company_domain" />

                    </div>

                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">{{ __('words.customer_profile') }}</legend>
                <div class="form-group ">
                    <label for="ownership">{{ __('words.ownership') }}</label>
                    {{-- <input type="text" class="form-control" id="ownership" name="ownership" required>  --}}


                    <div class="row mx-2 mb-5">
                        <div class="form-check col-md-3">
                            <input class="form-check-input" name="meta[customer_profile][ownership]" type="radio"
                                id="single_person_enterprise" value="Enkeltpersonforetak">
                            <label class="form-check-label" for="single_person_enterprise">
                                {{ __('words.single_person_enterprise') }}
                            </label>
                        </div>
                        <div class="form-check col-md-3">
                            <input class="form-check-input" name="meta[customer_profile][ownership]" type="radio"
                                id="responsible_company" value="Ansvarlig selskap">
                            <label class="form-check-label" for="responsible_company">
                                {{ __('words.responsible_company') }}
                            </label>
                        </div>

                        <div class="form-check col-md-3">
                            <input class="form-check-input" name="meta[customer_profile][ownership]" type="radio"
                                id="corporation" value="Aksjeselskap">
                            <label class="form-check-label" for="corporation">
                                {{ __('words.corporation') }}
                            </label>
                        </div>
                        <div class="form-check col-md-3">
                            <input class="form-check-input" name="meta[customer_profile][ownership]" type="radio"
                                value="Allmenn aksjeselskap" id="general_public_society">
                            <label class="form-check-label" for="general_public_society">
                                {{ __('words.general_public_society') }}
                            </label>
                        </div>

                        <div class="form-check col-md-3">
                            <input class="form-check-input" name="meta[customer_profile][ownership]" type="radio"
                                value="Annet (vennligst spesifiser)" id="annet">
                            <label class="form-check-label" for="annet">
                                {{ __('words.others') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <x-form.input type="text" label="{{ __('words.organization_number') }}" :value="$external->company_registration"
                            name="meta[customer_profile][orgNumber]" id="orgNumber" required />

                    </div>


                </div>




                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cardHolderPresent">{{ __('words.cardholder_present') }}</label>


                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="cardHolderPresent"
                                name="meta[customer_profile][cardHolderPresent]" required>
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="mailPhoneOrder">{{ __('words.post_phone_order') }}</label>


                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="mailPhoneOrder"
                                name="meta[customer_profile][mailPhoneOrder]" required>
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="internet">{{ __('words.internet') }}</label>


                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="internet"
                                name="meta[customer_profile][internet]" required>
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>


            </fieldset>



            <fieldset class="scheduler-border">
                <legend class="scheduler-border">{{ __('words.signature_section_title') }}</legend>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="gender">{{ __('words.pre_surname_woman_male') }}</label>

                        <div class="row mx-3">
                            <div class="col-md-3">
                                <input class="form-check-input" name="meta[authrized][gender]" type="radio"
                                    value="Kvinne" id="female">
                                <label class="form-check-label" for="female">
                                    {{ __('words.woman') }}
                                </label>
                            </div>

                            <div class="col-md-3">
                                <input class="form-check-input" name="meta[authrized][gender]" type="radio"
                                    value="Mann" id="male">
                                <label class="form-check-label" for="male">
                                    {{ __('words.man') }}
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group col-md-2">
                        <x-form.input type="date" label="{{ __('words.date_of_birth') }}"
                            name="meta[authrized][dob]" id="dob" required />

                    </div>

                    <div class="form-group col-md-2">
                        <label for="share">{{ __('words.share') }}</label>

                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="share" name="meta[authrized][share]"
                                required>
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>

                    </div>
                    <div class="form-group col-md-2">
                        <label for="ceo">{{ __('words.ceo') }}</label>


                        <div class="row mx-3">
                            <div class="col-md-6">
                                <input class="form-check-input" name="meta[authrized][ceo]" type="radio"
                                    value="yes" id="yes">
                                <label class="form-check-label" for="yes">
                                    {{ __('words.yes') }}
                                </label>
                            </div>

                            <div class="col-md-6">
                                <input class="form-check-input" name="meta[authrized][ceo]" type="radio"
                                    value="no" id="no">
                                <label class="form-check-label" for="no">
                                    {{ __('words.no') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <x-form.input type="text" label="{{ __('words.private_address') }}"
                            name="meta[authrized][privateAddress]" id="privateAddress" required />
                    </div>
                    <div class="form-group col-md-6">
                        <x-form.input type="text" label="{{ __('words.other_nationality') }}"
                            name="meta[authrized][otherNationality]" id="otherNationality" />
                    </div>
                </div>

            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">{{ __('words.financila_information') }}</legend>


                <div class="form-row">
                    <div class="form-group col-md-4">
                        <x-form.input type="text" label="{{ __('words.bank_name') }}"
                            name="meta[financial][bankName]" id="bankName" required />
                    </div>
                    <div class="form-group col-md-4">
                        <x-form.input type="text" label="{{ __('words.accountHolderName') }}"
                            name="meta[financial][accountHolderName]" id="accountHolderName" required />
                    </div>
                    <div class="form-group col-md-4">
                        <x-form.input type="text" label="{{ __('words.accountNumber') }}"
                            name="meta[financial][accountNumber]" id="accountNumber" required />
                    </div>
                </div>

            </fieldset>

            <input type="hidden" name="meta[report][1]" value="1">
            <input type="hidden" name="meta[customerDetails][1]" value="1">

            <input class="form-check-input" name="meta[partner][partner]" type="hidden" value="1"
                id="2iZi">
            <fieldset class="scheduler-border ">
                <h4 class="d-block">{{ __('words.service_fee_heading') }}</h4>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <x-form.input type="text" label="{{ __('words.setup_fee') }}"
                            name="meta[productId][setup_fee]" value="0" id="setup_fee" readonly />
                    </div>
                    <div class="form-group col-md-4">
                        <x-form.input type="text" label="{{ __('words.monthly_fee') }}"
                            name="meta[productId][monthly_fee]" value="0" id="monthly_fee" readonly />
                    </div>
                    <div class="form-group col-md-4">
                        <x-form.input type="text" label="{{ __('words.per_transaction_fee') }}"
                            name="meta[productId][per_transaction_fee]" id="per_transaction_fee" value="1.85%"
                            readonly />
                    </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">{{ __('words.reporting_system') }}</legend>
                <div class="form-group col-md-12">
                    {{-- <x-form.input type="text" label="Signatur" name="signature" id="signature" required /> --}}
                    <label for="form-label" style="display: block">{{ __('words.signature_subtitle') }}</label>
                    <input type="hidden" name="signature" id="signature-input">
                    <canvas id="signature-pad" width="600" height="200"></canvas>
                    <button class="btn btn-dark mb-4" type="button" onclick="clearCanvas()">{{ __('words.signature_clear') }}</button>
                </div>


            </fieldset>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">{{ __('words.submit') }}</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var canvas = document.getElementById('signature-pad');
            var context = canvas.getContext('2d');
            var clearButton = document.getElementById('clear-button');
            var saveButton = document.getElementById('save-button');
            var signatureInput = document.getElementById('signature-input');
            var isDrawing = false;
            var lastX = 0;
            var lastY = 0;
            // Start drawing
            function startDrawing(e) {
                isDrawing = true;
                [lastX, lastY] = [e.offsetX, e.offsetY];
            }
            // Draw when mouse moves
            function draw(e) {
                if (!isDrawing) return;
                context.beginPath();
                context.moveTo(lastX, lastY);
                context.lineTo(e.offsetX, e.offsetY);
                context.stroke();
                [lastX, lastY] = [e.offsetX, e.offsetY];
            }
            // Stop drawing
            function stopDrawing() {
                isDrawing = false;
                signatureInput.value = canvas.toDataURL();
            }
            // Clear the canvas
            function clearCanvas() {
                context.clearRect(0, 0, canvas.width, canvas.height);
            }
            // Save the signature
            function saveSignature() {
                var dataURL = canvas.toDataURL(); // Get the signature as a data URL
                console.log(dataURL); // You can send this data to your backend for storage
            }
            // Event listeners
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);
            clearButton.addEventListener('click', clearCanvas);
            saveButton.addEventListener('click', saveSignature);
        });

        function clearCanvas() {
            var canvas = document.getElementById('signature-pad');
            var context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
        }
    </script>
</x-dashboard.external>
