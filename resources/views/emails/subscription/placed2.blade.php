@component('mail::message')
    <h1 class="title">
        Faktura for ordre #{{ $order->id }}</h1>
    <div class="body-section">
        Hei {{ $order->first_name }} {{ $order->last_name }} <br>
        {!! $message !!} <br />
        <div class="border" style="margin-top:20px">
            {{ $order->shop->name }} <br />
            Tlf: {{ $order->shop->user->phone }} <br />
            {{ $order->shop->street }} <br />
            {{ $order->shop->post_code }} {{ $order->shop->city }}<br/></div>
            <br>
            <h3>Subscription Information</h3>
            <br>
        <table class="order-details">
            <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Duraton</th>
                    <th>Paid At</th>
                    <th>Subscription Fee</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table-order">
                        <p>{{ $order->order_id }}</p>
                    </td>
                    <td>
                        <p>{{ $order->box->title }}</p>
                    </td>
                    <td>{{ @$order->box->duration->length }} {{ @$order->box->duration->mode }}</td>
                    <td class="table-date">
                        <p>{{ $order->paid_at?$order->paid_at->format('d M Y'):'Not Paid' }}</p>
                    </td>
                    <td class="table-total">
                        <p>{{ Iziibuy::withSymbol($order->subscriptionFee()) }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3>Charges</h3>
        <table class="order-details">
            <tr>
                <th>Date & Time</th>
                <th>Charge</th>
                <th>Status</th>
            </tr>
            @foreach ($order->charges as $charge)
                <tr>
                    <td>
                        <div>{{ $charge->created_at }}</div>
                    </td>
                    <td>
                        <div>{{ Iziibuy::price($charge->amount) }}</div>
                    </td>
                    <td>{{ $charge::STATUS[$charge->status] }}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <h2 class="heading">Adresse</h2>
        <div class="border">
            {{ $order->first_name }} {{ $order->last_name }} <br />
            Tlf: {{ $order->phone }}<br />
            {{ $order->address }}<br />
            {{ $order->post_code }} {{ $order->city }}<br /></div>
        Takk for at du handler hos oss.
        Hilsen oss i,<br>
        {{ $order->shop->name }}
    </div>
@endcomponent
