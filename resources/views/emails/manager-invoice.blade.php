@component('mail::message')
    <h1 class="title">Invoice for shop #{{ $shop->name }}</h1>
    <div class="body-section">
        <div class="border">
            Olsen Businesstools <br />
            Nesbruveien 75 <br />
            1394 Nesbru <br />
            Org nummer: 923 701 281 <br />
         </div>
        <table class="order-details">
            <tr>
                <td class="font-weight-bold">Cost For Managers</td>
                <td>{{ Iziibuy::price($amount) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Tax</td>
                <td>{{ Iziibuy::price($tax) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Total</td>
                <td>{{ Iziibuy::price($amount+$tax) }}</td>
            </tr>
        </table>
        <h2 class="heading">Address</h2>
        <div class="border">
           {{ $shop->user->name }} {{ $shop->user->last_name }} <br />
           {{ $shop->user->phone }} <br />
           {{ $shop->street }} <br />
           {{ $shop->city }} <br />
           {{ $shop->post_code }}
        </div>
         Thanks for shopping with us!
        All of us in,<br>
        {{ config('app.name') }}
    </div>
@endcomponent