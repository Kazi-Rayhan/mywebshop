@component('mail::message')
    <h1 class="title">Invoice for service subscription || {{ $shop->name }}</h1>
    <div class="body-section">
        <div class="border">
            Olsen Businesstools <br />
            Nesbruveien 75 <br />
            1394 Nesbru <br />
            Org nummer: 923 701 281 <br />
        </div>
        <table class="order-details">
        @if(!$shop->service_establishment)
            <tr>
                <td class="font-weight-bold">Service Establishment Cost:</td>
                <td>{{ Iziibuy::price($shop->service_establishment_cost) }}</td>
            </tr>
        @endif
            <tr>
                <td class="font-weight-bold">Monthly Charge </td>
                <td>{{ Iziibuy::price(  $shop->ServiceMonthlyCost()) }}</td>
            </tr>
             <tr>
                <td class="font-weight-bold">{{$shop->registrationTax()}} % TAX</td>
                <td>{{ Iziibuy::price(  $shop->getTax($shop->ServiceSubscriptionFee(false))) }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Total</td>
                <td>{{ Iziibuy::price($shop->ServiceSubscriptionFee()) }}</td>
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
        Thanks for being with us!
        All of us in,<br>
        {{ config('app.name') }}
    </div>
@endcomponent
