<x-dashboard.shop>
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
    @php
        $shop = Auth()->user()->shop;
    @endphp
    <div class="container mt-5">
        <form action="{{ route('form.test') }}" method="post">
            @csrf
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Selskapsinformasjon</legend>
                <div class="form-group">
                    {{-- <label for="legalName">Juridisk navn</label>
                    <input type="text" class="form-control" id="legalName" name="legalName" required> --}}
                    <x-form.input type="text" label="Juridisk navn" :value="$shop->name" name="meta[name]" id="legalName" />
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <x-form.input type="text" label="Forretningsadresse" name="meta[businessAddress]"
                            id="businessAddress" required />

                    </div>

                    <div class="form-group col-md-6">
                        <x-form.input type="tel" label="Telefonnummer" :value="$shop->contact_phone" name="meta[contact_phone]"
                            id="phoneNumber" required />

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <x-form.input type="text" label="Kontaktperson (Fornavn/Etternavn)"
                            name="meta[contactPerson]" id="contactPerson" required />

                    </div>

                    <div class="form-group col-md-6">
                        <x-form.input type="email" label="E-post" :value="$shop->contact_email" name="meta[contact_email]"
                            id="email" required />

                    </div>
                </div>

                <div class="form-group">
                    <x-form.input type="text" label="Utsalgsstedsnavn" :value="$shop->company_name" name="meta[company_name]"
                        id="outletName" required />

                </div>

                <div class="form-group">
                    <x-form.input type="text" label="Utsalgsstedets besøksadresse" name="meta[comapny_address]"
                        id="outletAddress" required />

                </div>
            </fieldset>


            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Rapporteringssystem</legend>

                <div class="form-group col-md-12">
                    {{-- <x-form.input type="text" label="Signatur" name="signature" id="signature" required /> --}}
                    <label for="form-label" style="display: block">Signature</label>
                    <input type="hidden" name="signature" id="signature-input">
                    <canvas id="signature-pad" width="600" height="200"></canvas>
                    <button class="btn btn-dark mb-4" type="button" onclick="clearCanvas()">Clear</button>
                </div>

            </fieldset>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Submit</button>
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

</x-dashboard.shop>
