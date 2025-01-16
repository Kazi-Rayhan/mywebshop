<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"> {!! __('words.store_views_sec_title') !!} :</span> #{{ $storage->city }}</h3>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="btn-group mb-3">
                        <button class="btn btn-outline-primary btn-sm" onclick="checkAll()">
                            {!! __('words.check_all_btn') !!}
                        </button>
                        <button class="btn btn-outline-warning btn-sm" onclick="uncheckAll()">
                            {!! __('words.uncheck_all_btn') !!}
                        </button>
                    </div>

                    <form action="{{ route('shop.add-product', $storage) }}" method="post">
                        @csrf
                        <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-md-12">
                                    <div class="card card-body mb-2">
                                        <div class="row" onclick="checkAllCheckbox(this)">
                                            <div class="col-md-12">
                                                <p class="font-weight-bold"> {{ $category->name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach ($category->products as $product)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                            name="product[{{ $product->id }}][product_id]"
                                                            type="checkbox" value="{{ $product->id }}"
                                                            id="product-{{ $product->id }}"
                                                            data-id="{{ $product->id }}"
                                                            data-quantity="{{ $product->stores->find($storage->id) ? $product->stores->find($storage->id)->pivot->quantity : 0 }}"
                                                            data-name="{{ $product->name }}"
                                                            @if ($product->stores ? $product->stores->find($storage->id) : false) checked @endif>
                                                        <label class="form-check-label mr-2"
                                                            for="product-{{ $product->id }}">
                                                            {{ $product->name }} | Quantity :
                                                            {{ $product->stores->find($storage->id) ? $product->stores->find($storage->id)->pivot->quantity : 0 }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- @foreach ($products as $product)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" name="product[{{$product->id}}][product_id]" type="checkbox"
                                        value="{{ $product->id }}" id="product-{{ $product->id }}" data-id="{{$product->id}}" data-quantity="{{$product->stores->find($storage->id) ? $product->stores->find($storage->id)->pivot->quantity : 0}}" data-name="{{ $product->name }}" @if ($product->stores ? $product->stores->find($storage->id) : false) checked @endif>
                                    <label class="form-check-label mr-2" for="product-{{ $product->id }}">
                                        {{ $product->name }} | Quantity : {{$product->stores->find($storage->id) ? $product->stores->find($storage->id)->pivot->quantity : 0}}
                                    </label>
                                </div>
                            </div>
                            @endforeach --}}
                        </div>
                        <button type="button" class="btn btn-primary mt-2" onclick="show()">
                            {!! __('words.go_btn') !!}
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{!! __('words.set_qnty') !!}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body ">
                                        <div id="quantity" class="row">

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">{!! __('words.close_btn') !!}</button>
                                        <button type="submit" class="btn btn-primary">{!! __('words.save_btn') !!}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Modal -->


                </div>
            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            function checkAllCheckbox(el) {
                const allInputEl = el.nextElementSibling.querySelectorAll(
                    'input[type="checkbox"]'
                );
                const allInputElArry = Array.from(allInputEl);
                let isChecked = true;
                allInputElArry.every(inputEl => {
                    if (inputEl.checked == true) {
                        isChecked = false;
                        return false;
                    }
                    return true;
                });
                allInputElArry.forEach(inputEl => {
                    inputEl.checked = isChecked;
                });
            }
        </script>
        <script>
            function checkAll() {
                $('.form-check-input').prop('checked', true);

            }

            function uncheckAll() {
                $('.form-check-input').prop('checked', false);

            }

            function show() {
                const quantity = document.getElementById('quantity')
                quantity.textContent = '';
                for (el of $('.form-check-input')) {
                    if (el.checked) {
                        const formGroup = document.createElement('div');
                        formGroup.classList.add('form-group');
                        formGroup.classList.add('col-md-4');
                        const input = `
                    <label for="product-${el.value}">${el.dataset.name} </label>
                    <input type="text" id="qnt" name="product[${el.dataset.id}][quantity]" class="form-control" placeholder="quantity" value="${el.dataset.quantity}">
                `
                        formGroup.innerHTML = input;
                        quantity.appendChild(formGroup);
                    }
                }
                if (document.getElementById('quantity').innerText == '') {
                    document.getElementById('quantity').innerHTML = `<h2 class='mx-auto'> Nothing is selected </h2>`
                }
                $('#exampleModal').modal('show')
            }
        </script>
    @endpush
</x-dashboard.shop>
