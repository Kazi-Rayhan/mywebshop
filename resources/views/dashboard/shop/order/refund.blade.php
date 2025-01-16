<x-dashboard.shop>
<section>
<div class="card m-5">
    <div class="card-body">
        <form action="{{route('shop.orders.refund.store',$order)}}" method="post">
        @csrf
            <fieldset class="row">
                <legend>
                    Refund
                </legend>

                <div class="form-group col-md-4">
                    <label for="">Amount</label>
                    <input name="amount" type="number" min="1" max="{{ $order->maxRefund() }}"
                        value="{{ (int) $order->maxRefund() }}" class="form-control" required
                        placeholder="Enter amount">
                </div>
                <div class="form-group col-md-8">
                    <label for="">Reason</label>
                    <input name="reason" type="text" class="form-control" placeholder="Reason of refund">
                </div>
                <button class="btn btn-primary">
                    Refund
                </button>
            </fieldset>

        </form>

    </div>
</div>
</section>
</x-dashboard.shop>