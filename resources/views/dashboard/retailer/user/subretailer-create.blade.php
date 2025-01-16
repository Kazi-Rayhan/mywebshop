<x-dashboard.retailer>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('retailer.storeAffiliates') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6  @error('first_name') has-error @enderror">
                                    <label for="f_name">{{__('words.name')}}</label>
                                    <input type="text" id="f_name" class="form-control" name="first_name">
                                    @error('first_name')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                
                                <div class="form-group col-sm-12 col-md-6 @error('last_name') has-error @enderror">
                                    <label for="l_name">{{__('words.last_name')}}</label>
                                    <input type="text" id="l_name" class="form-control" name="last_name">
                                    @error('last_name')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6 @error('phone') has-error @enderror">
                                    <label for="phone">{{__('words.phone')}}</label>
                                    <input type="tel" id="phone" class="form-control" name="phone">
                                    @error('phone')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                
                                <div class="form-group col-sm-12  col-md-6 @error('email') has-error @enderror">
                                    <label for="email">{{__('words.email')}}</label>
                                    <input type="email" id="email" class="form-control" name="email">
                                    @error('email')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 @error('password') has-error @enderror">
                                    <label for="password">{{__('words.password')}}</label>
                                    <input type="password" id="password" class="form-control" name="password">
                                    @error('password')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                               
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="tax">{{__('words.tax')}} %</label>
                                    <input type="number" step="any" name="tax" min="0" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="tax">{{__('words.tax_number')}}</label>
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
                                + {{__('words.add')}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.retailer>