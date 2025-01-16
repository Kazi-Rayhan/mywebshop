 <h5>{{ __('words.select_shipping_method') }}</h5>
 <div class="row 3">
     <div class="col-12">
         <form
             action="{{ route('checkout.store', [
                 'user_name' => request('user_name'),
             ]) }}"
             method="post">
             @csrf
             <input type="hidden" name="reference" value="self">
             <div class="form-check">
                 <input class="form-check-input" type="checkbox" name="terms" value="terms" id="terms" checked
                     required>
                 <label class="form-check-label" for="terms">
                     {!! __('words.external_contract_terms') !!}

                     <a href="#" data-bs-toggle="modal" data-toggle="modal" data-target="#terms-cart-self">
                         {{ __('words.betingelser') }}
                     </a>
                     <div class="modal fade" id="terms-cart-self" tabindex="10000000" data-bs-backdrop="static"
                         data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                         <div class="modal-dialog" role="document" style="max-width: 750px">
                             <div class="modal-content">
                                 <div class="modal-body">
                                     <div class="et_pb_text_inner">
                                         <h3>{{ __('words.shop_overview') }}</h3>
                                         <p>{{ __('words.terms_pera2') }}
                                             {{ route('shop.home', request('user_name')) }}.
                                         </p>
                                         <p> <strong>{!! __('words.terms_pera') !!}</strong><br>{{ __('words.terms_pera_3') }}
                                             ({{ route('shop.home', request('user_name')) }})</p>
                                         <p><strong>{{ __('words.terms_pertner_text') }}</strong> </p>
                                         <ul class="ml-5" style="list-style: circle">
                                             <li><b>{{ __('words.shop_company_name') }}:</b> {{ $shop->company_name }}
                                             </li>
                                             <li><b>{{ __('words.invoice_address') }}:</b>
                                                 {{ $shop->street }}</li>
                                             <li><b>{{ __('words.invoice_postcode') }}:</b>
                                                 {{ $shop->post_code . ' ' . $shop->city }}
                                             </li>
                                             <li><b>{{ __('words.dashboard_complete_reg_form_org_no') }}:</b>
                                                 {{ $shop->company_registration }}</li>
                                             <li><b>{{ __('words.invoice_tel') }}:</b> {{ $shop->contact_phone }}</li>
                                             <li><b>{{ __('words.invoice_email') }}:</b> {{ $shop->contact_email }}
                                             </li>
                                         </ul>
                                         {!! $shop->getTranslatedAttribute('terms', app()->getLocale()) !!}

                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </label>
             </div>
             <div class="my-3">

                 <div class="form-check">
                     <input class="form-check-input" type="radio" name="shipping" value="" checked
                         id="shipping0" required data-cost="0" />
                     <label class="form-check-label" for="shipping0">{!! strip_tags(__('words.pickup_from_store')) !!}
                     </label>
                 </div>
             </div>
             <div class="d-flex flex-column  ">
                 <button type="submit" class=" btn text-light mx-2 mb-2 buy_btn"
                     style="background-color:#4258a7;border:none"><i
                         class="fas fa-check"></i><span>{!! strip_tags(__('words.cart_checkout_btn')) !!}</span></button>

             </div>
         </form>
     </div>
 </div>
