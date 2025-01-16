@foreach ($order->products as $product)
<tr>
    <td>
        <img src="{{Storage::url($product->image)}}" alt="" width="80">
    </td>

    <td align="top">
        <h5 style="margin-top: 15px;">
        </h5>

        <h5 style="font-size: 14px;color:#444;margin-top: 8px;margin-bottom: 0px;">
           {{ $product->name }}
        </h5>
    </td>

    <td align="top">
        <h5 style="font-size: 14px; color:#444;margin-top: 15px;">
            <span> {{ $product->pivot->quantity }}</span>
        </h5>
    </td>

    <td align="top">
        <h5 style="font-size: 14px; color:#444;margin-top:15px">
            <b>  {{ Iziibuy::price($product->pivot->price, $order->shop, $order->currency) }}</b>
        </h5>
    </td>
</tr>
@endforeach
