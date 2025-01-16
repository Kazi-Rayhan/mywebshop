<x-dashboard.external>
    <div class="card">
        <div class="card-body">

            

            <h3>{{ __('words.button_payment') }}</h3>

            <ul class="list-group">
                <li class="list-group-item">
                    Domain : {{ $paymentApi->domain }}
                </li>
                <li class="list-group-item">
                    Success Url : {{ $paymentApi->success_redirect_url }}
                </li>
                <li class="list-group-item">
                    Failed Url : {{ $paymentApi->failed_redirect_url }}
                </li>
                <li class="list-group-item bg-secondary text-light">
                    Source Key : {{ $paymentApi->key }}
                </li>
            </ul>

         

            <h3>
                Orders
            </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            OrderID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Tax Value
                        </th>
                        <th>
                            Tax Total
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Date
                        </th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                {{ $order->id }}
                            </td>
                            <td>
                                {{ $order->orderId }}
                            </td>
                            <td>
                                {{ $order->customer_name }}
                            </td>
                            <td>
                                {{ $order->customer_email }}
                            </td>
                            <td>
                                {{ $order->customer_phone }}
                            </td>
                            <td>
                                {{ $order->description }}
                            </td>
                            <td>
                                {{ $order->taxValue }}
                            </td>
                            <td>
                                {{ $order->taxTotal }}
                            </td>
                            <td>
                                {{ $order->amount }}
                            </td>
                            <td>
                                {{ $order->status }}
                            </td>
                            <td>
                                {{ $order->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$orders->links()}}
            <h3>
                How to use
            </h3>
            <h5>Javascript :</h5>
            <pre>
                <code class="text-dark">
                    &lt;div id="iziipay"&gt; &lt;/div&gt;
                    &lt;script src="{{ asset('payment/iziipay.js') }}"&gt;&lt;/script&gt;
                    &lt;script&gt;
                        Iziipay.init('#iziipay', {
                            apiKey: "{{ $paymentMethodAccess->key }}",
                            buttonText: 'Pay now',
                            source_key: "{{ $paymentApi->key }}",
                            amount: "300",
                            taxValue: "10%",
                            taxTotal: "27.27",
                            orderId: "300",
                            description: "T-Shirt Purchase",
                            currency: "NOK",
                        });
                    &lt;/script&gt;
                </code>
            </pre>
 <hr>
            <div class=" api-doc-container">
             
                <h5>Api Endpoint :</h5>
                <pre><code>POST {{ route('iziipay.createPayment',$paymentMethodAccess->key) }}</code></pre>

                <h5>Description</h5>
                <p>This endpoint creates a new external order and generates a payment link using the specified payment
                    API.</p>

                <h5>Request Parameters</h5>

                <h6>Body Parameters</h6>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Parameter</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>source_key</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Unique API key for the payment source.</td>
                        </tr>
                        <tr>
                            <td>name</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Customer's full name.</td>
                        </tr>
                        <tr>
                            <td>email</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Customer's email address.</td>
                        </tr>
                        <tr>
                            <td>phone</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Customer's phone number.</td>
                        </tr>
                        <tr>
                            <td>country</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Customer's country of residence.</td>
                        </tr>
                        <tr>
                            <td>address</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Customer's street address.</td>
                        </tr>
                        <tr>
                            <td>post_code</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Customer's postal/ZIP code.</td>
                        </tr>
                        <tr>
                            <td>amount</td>
                            <td>float</td>
                            <td>Yes</td>
                            <td>Payment amount to be processed.</td>
                        </tr>
                        <tr>
                            <td>currency</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Currency for the payment (e.g., NOK).</td>
                        </tr>
                        <tr>
                            <td>taxValue</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Tax Value (e.g., 10%).</td>
                        </tr>
                        <tr>
                            <td>taxTotal</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Tax Value (e.g., 27.4).</td>
                        </tr>
                        <tr>
                            <td>description</td>
                            <td>string</td>
                            <td>Yes</td>
                            <td>Tax Value (e.g., T-shirt purchase).</td>
                        </tr>
                      
                        <tr>
                            <td>orderId</td>
                            <td>integer</td>
                            <td>Yes</td>
                            <td>Tax Value (e.g., 1234).</td>
                        </tr>
                    </tbody>
                </table>

                <h2>Response</h2>
                <h6>Success Response</h6>
                <pre><code class="code-box">
            {
                "url": "https://payment-gateway.com/payment-link"
            }
                </code></pre>

                <h6>Error Responses</h6>
                <pre><code class="code-box">
            400 Bad Request
            {
                "error": "Invalid source key provided."
            }
            
            404 Not Found
            {
                "error": "Payment method or API not found."
            }
            
            500 Internal Server Error
            {
                "error": "An unexpected error occurred. Please try again later."
            }
                </code></pre>

                <h5>Example Usage</h5>
                <h6>cURL Command</h6>
                <pre><code class="code-box">
            curl -X POST {{ route('iziipay.createPayment',$paymentMethodAccess->key) }} \
            -H "Content-Type: application/json" \
            -d '{
                "source_key": "{{ $paymentApi->key }}",
                "name": "John Doe",
                "email": "john.doe@example.com",
                "phone": "1234567890",
                "country": "Norway",
                "address": "123 Main Street",
                "post_code": "12345",
                "amount": 100.00,
                "currency": "NOK"
            }'
                </code></pre>

          
            </div>

          
        </div>
    </div>
</x-dashboard.external>
