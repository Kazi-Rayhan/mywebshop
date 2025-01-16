@extends('voyager::master')
@section('content')
    @push('styles')
        <style>
            .container {
                min-height: 80vh;
                display: flex;
                flex-direction: column;
                gap: 10px;
                align-items: center;
                justify-content: center;
            }

            .card {
                min-width: 80vw;
                padding: 20px;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }

            .card h2 {
                font-family: monospace;
            }

            select {
                font-weight: normal !important;
                font-size: 15px !important;
            }
        </style>
    @endpush
    <div class="container">

        <div class="card">
            <h2>
                Add new retailer
            </h2>
            <div class="card-body">
                <form action="{{ route('admin.retailer.store-retailer') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6  @error('first_name') has-error @enderror">
                            <label for="f_name">First Name</label>
                            <input type="text" id="f_name" class="form-control" name="first_name">
                            @error('first_name')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12 col-md-6 @error('last_name') has-error @enderror">
                            <label for="l_name">Last Name</label>
                            <input type="text" id="l_name" class="form-control" name="last_name">
                            @error('last_name')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 @error('phone') has-error @enderror">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" class="form-control" name="phone">
                            @error('phone')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12  col-md-6 @error('email') has-error @enderror">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email">
                            @error('email')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 @error('password') has-error @enderror">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                            @error('password')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 @error('type') has-error @enderror" >
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">--- Select retailer type ---</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->label }}</option>
                                @endforeach

                            </select>
                            @error('type')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                        @php
                            $retailers = App\Models\RetailerMeta::where('parent_id', null)
                                ->where('type', 4)
                                ->get();

                        @endphp
                        <div class="form-group col-sm-12 col-md-12 @error('type') has-error @enderror" id="retailerFrom">
                            <label for="retaile">Parent Retailer </label>
                            <select name="retailer" id="retaile" class="form-control">
                                <option value="">--- Select retailer ---</option>
                                @foreach ($retailers as $retailer)
                                    <option value="{{ $retailer->user->id }}">{{ $retailer->user->email }} ({{ $retailer->user->fullName }})</option>
                                @endforeach

                            </select>
                            @error('type')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="tax">Tax %</label>
                            <input type="number" step="any" name="tax" min="0" class="form-control">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="tax">Tax Number</label>
                            <input type="text" name="tax_number" min="0" class="form-control">
                        </div>
                    </div>

                    {{-- <div class="row">

                        <div class="col-lg-4">
                            <label for="otp">One time payout</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" id="otp" name="one_time_pay_out[status]">
                                </span>
                                <input type="number" step="any" min="0" class="form-control"
                                    name="one_time_pay_out[value]">
                                <span class="input-group-addon">
                                    NOK
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="cfrp">Commission from recurring payments</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" id="cfrp" name="commission_for_recuuring_payments[status]">
                                </span>
                                <input type="number" step="any" min="0" class="form-control"
                                    name="commission_for_recuuring_payments[value]">
                                <span class="input-group-addon">
                                    %
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="cfs">Commission from sales</label>
                            <div class="input-group">
                                <span class="input-group-addon ">
                                    <input type="checkbox" id="cfs" name="commission_for_sales[status]">
                                </span>
                                <input type="number" step="any" min="0" class="form-control"
                                    name="commission_for_sales[value]">
                                <span class="input-group-addon">
                                    %
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <button class="mt-5 btn btn-primary">
                        + Add
                    </button>
                </form>
            </div>
        </div>
    </div>
    @push('javascript')
        <script>
            $(document).ready(function() {
                // Initially hide and disable the retailer select box
                $('#retailerFrom').hide();
                $('#retaile').prop('disabled', true);

                // Add change event listener to the type select box
                $('#type').change(function() {
                    var selectedType = $(this).val();

                    // If the selected type is 4, show and enable the retailer select box
                    if (selectedType === '4') {
                        $('#retailerFrom').show()
                        $('#retaile').prop('disabled', false);

                    } else {
                        // Otherwise, hide and disable the retailer select box
                        $('#retailerFrom').hide();
                        $('#retaile').prop('disabled', true);

                    }
                });
            });
        </script>
    @endpush
@endsection
