<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"><i class="fas fa-dice-d6" aria-hidden="true"></i></span>
        {!! __('words.cuppon_index_sec_title') !!}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.coupon.create') }}"><i
                            class="fas fa-plus"></i> {!! __('words.coupon_create_btn') !!} </a>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{!! __('words.coupon_code') !!}</th>
                                <th>{!! __('words.invoice_dis_amount') !!}</th>
                                <th>{!! __('words.coupon_expire_at') !!}</th>
                                <th>{!! __('words.coupon_limit') !!}</th>
                                <th>{!! __('words.coupon_min_cart') !!}</th>
                                <th>{!! __('words.coupon_used') !!}</th>
                                <th>{!! __('words.cart_table_action') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>
                                        {{ $coupon->code }}
                                    </td>
                                    <td>
                                        {{ $coupon->discount }}
                                    </td>
                                    <td>
                                        {{ $coupon->expire_at }}
                                    </td>
                                    <td>
                                        {{ $coupon->limit }}
                                    </td>
                                    <td>
                                        {{ $coupon->minimum_cart }}
                                    </td>
                                    <td>
                                        {{ $coupon->used }}
                                    </td>
                                    <td>
                                        <x-helpers.delete :url="route('shop.coupon.destroy', $coupon)" :id="$coupon->id" />
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('shop.coupon.edit', $coupon) }}"><i
                                                class="fas fa-edit"></i></a>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>
