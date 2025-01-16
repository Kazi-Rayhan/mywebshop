  <div class="row my-3">
      @if (!Iziibuy::discount_code())
          <div class="col-12">
              <form action="{{ route('coupon', request('user_name')) }}" method="post">
                  @csrf

                  <div class="input-group">

                      <input class="form-control" placeholder="{!! strip_tags(__('words.cart_discount_placeholder')) !!}" name="coupon_code" type="text">
                      <div class="input-group-append">
                          <button class="btn btn-inline" type="submit"><i
                                  class="fas fa-cut"></i><span>{!! strip_tags(__('words.cart_apply_btn')) !!}</span></button>
                      </div>
                  </div>
              </form>
          </div>
      @endif
  </div>
