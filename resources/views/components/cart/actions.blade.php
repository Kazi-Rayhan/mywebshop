   <div class="col-12">
       <div class="d-flex flex-column  ">
           <a class="btn btn-inline btn-block mx-2 mb-2" href="{{ route('products', request('user_name')) }}"><i
                   class="fas fa-undo-alt"></i><span>{!! strip_tags(__('words.cart_back_btn')) !!}</span></a>
           <form cl action="{{ route('checkout.store', request('user_name')) }}" method="post">
               @csrf
               <button class="btn btn-inline btn-block mx-2 mb-2" type="submit">
                   <i class="fas fa-check"></i><span>{!! strip_tags(__('words.cart_checkout_btn')) !!}</span>
               </button>
           </form>

           {{-- @if (env('MODE') == 'dev') --}}
           <a class="btn btn-inline btn-block mx-2 " href="{{ route('checkout', [request('user_name'), 'method' => 'two']) }}"><i
                   class="fas fa-check"></i><span>{!! strip_tags(__('words.cart_checkout_company_btn')) !!}</span></a>
           {{-- @endif --}}
       </div>
   </div>
