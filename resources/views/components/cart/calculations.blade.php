   <table class="table mx-2 ">
       <tr>
           <th>
               {!! strip_tags(__('words.cart_subtotal')) !!}
           </th>
           <td>
               {{ Iziibuy::price(Iziibuy::basePrice()) }}
           </td>
       </tr>
       <tr>
           <th>
               {!! strip_tags(__('words.cart_tax')) !!}
           </th>
           <td>
               {{ Iziibuy::price(Iziibuy::tax()) }}
           </td>
       </tr>

           <tr @if ($shop->self_checkout == 1) class="d-none" @endif>
               <th>
                   {!! __('words.checkout_shipping') !!}
               </th>
               <td>
                   <span class="" id="shipping_cost">0.00
                   </span>
                   {{ session()->get('current_currency')[request()->user_name] ?? $shop->default_currency }}
                   (With Tax)
               </td>
           </tr>
       @if (Iziibuy::discount() > 0)
           <tr>
               <th>
                   {!! strip_tags(__('words.cart_discount')) !!}
               </th>
               <td>
                   {{ (float) Iziibuy::price(Iziibuy::discount()) }}
               </td>
           </tr>
       @endif
       <tr>
           <th>
               {!! strip_tags(__('words.cart_account_table_title')) !!}
           </th>
           <td>

               <span id="total" class="">{{ Iziibuy::onlyPrice(Iziibuy::newSubtotal()) }}
               </span>
               {{ session()->get('current_currency')[request()->user_name] ?? $shop->default_currency }}
           </td>
       </tr>
   </table>
