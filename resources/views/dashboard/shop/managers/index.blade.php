<x-dashboard.shop>

    @php
        $shop = App\Models\Shop::find(App\Constants\Constants::vCardShop);
    @endphp
    @push('styles')
        <livewire:styles />
    @endpush

    @push('scripts')
        <livewire:scripts />
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#edit_modal').modal('show');
            });
        </script>
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#order_modal').modal('show');
            });
        </script>
    @endpush


    <h3>{!! __('words.shop_manager_sec_title') !!}</h3>
    <livewire:add-manager />
    <div class="col-lg-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h4>{!! __('words.dashboard_managers') !!}</h4>
            </div>
            <div class="card-body">

                <table class="table">
                    @if ($shop)
                        <tr>
                            <th colspan="6">
                                <button id="order" type="button" class="btn btn-primary btn-sm rounded"
                                    data-bs-toggle="modal" data-bs-target="#order_vcard">
                                    {!! __('words.manager_modal_title') !!}
                                </button>
                            </th>
                        </tr>
                    @endif
                    <tr>

                        <th>{!! __('words.dashboard_category_index_qr') !!}</th>
                        <th>{!! __('words.checkout_form_first_name_label') !!}</th>
                        <th> {!! __('words.checkout_form_lastname') !!}</th>
                        <th> {!! __('words.cart_table_action') !!}</th>

                        <th>Action</th>
                    </tr>
                    @foreach ($managers as $manager)
                        <tr>

                            <td>
                                <x-qr.direct :size="200" :url="route('shop.home', [
                                    'user_name' => auth()->user()->shop->user_name,
                                    'manager_id' => $manager->id,
                                ])" />
                            </td>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->last_name }}</td>
                            <td>{{ $manager->email }}</td>
                            <td>
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('shop.order.index', ['search' => $manager->id]) }}">{!! __('words.shop_orders') !!}</a>


                                <x-helpers.delete :url="route('shop.managers.delete', $manager)" :id="$manager->id" />

                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('shop.managers', ['manager_id' => $manager]) }}"><i
                                        class="far fa-edit"></i></a>
                                <a class="btn btn-primary btn-sm" href="{{ route('shop.myQr', $manager) }}"><i
                                        class="fas fa-qrcode"></i></a>
                                @if (auth()->user()->shop->can_provide_service)
                                    <a title="Assign groups to service" class="btn btn-success btn-sm"
                                        href="{{ route('shop.managers.schedule', $manager) }}">
                                        <i class="fas fa-clipboard-list"></i></a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </table>
                @if ($shop)
                    <form action="{{route('shop.order.vCard')}}" method="post" id="orderForm">
                        @csrf
                        <div class="modal fade" id="order_vcard" tabindex="-1" role="dialog"
                            aria-labelledby="order_vcard" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">{!! __('words.manager_modal_title') !!}
                                        </h5>

                                    </div>

                                    <div class="modal-body">
                                        <?php
                                        
                                        $product = $shop->products()->first();
                                        
                                        ?>
                                        <h3> <a
                                                href="{{ route('shop.home', $shop->user_name) }}">{{ $shop->name }}</a>
                                        </h3>

                                        <table class="table table-sm">
                                            <tr>
                                                <th>
                                                    {!! __('words.cart_table_price') !!} :
                                                </th>
                                                <th>
                                                    <span id="product_price">{{ $product->price }}</span> NOK
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {!! __('words.dashboard_managers') !!} :
                                                </th>
                                                <th>
                                                    * <span id="product_count">0</span>
                                                </th>
                                            </tr>
                                            <tr class="bg-info text-light">
                                                <th>
                                                    {!! __('words.cart_account_table_title') !!}
                                                </th>
                                                <th>
                                                    <span id="product_total" style="font-size: 20px;">0</span> NOK
                                                </th>
                                            </tr>
                                        </table>
                                        <hr>
                                        <input type="hidden" name="product" value="{{ $product->id }}" checked>
                                        <input type="hidden" id="product_total_input" name="total">
                                        <input type="hidden" id="product_qty_count" name="qty">

                                        <table class="table table-striped">

                                            <tr>
                                                <th>
                                                    <div class="form-group">
                                                        <input type="checkbox" id="check-all">
                                                    </div>
                                                </th>

                                                <th> {!! __('words.checkout_form_first_name_label') !!}</th>
                                                <th>{!! __('words.checkout_form_lastname') !!}</th>
                                                <th> {!! __('words.checkout_form_email') !!}</th>


                                            </tr>
                                            @foreach ($managers as $manager)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="manager-check" name="managers[]"
                                                            value="{{ $manager->id }}">
                                                    </td>

                                                    <td>{{ $manager->name }}</td>
                                                    <td>{{ $manager->last_name }}</td>
                                                    <td>{{ $manager->email }}</td>

                                                </tr>
                                            @endforeach
                                        </table>

                                        <button class="btn btn-primary" type="submit">
                                            {!! __('words.order_btn') !!}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @if (request('manager_id'))

        <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{!! __('words.edit_manager_modal_title') !!}</h5>
                        <a href="{{ route('shop.managers') }}" class="close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('shop.managers.update', $manager_edit) }}" method="post"
                            enctype="multipart/form-data">
                            @method('put');
                            @csrf

                            <div class="form-row">
                                <img src="{{ Iziibuy::image($manager_edit->avatar) }}" class="rounded-circle mx-auto"
                                    height="200px" width="200px" style="object-fit: cover;"
                                    alt="{{ $manager_edit->name }}'s Photo">
                                <div class="col-12">
                                    <x-form.input type="file" name="avatar" label="{!! __('words.upload_img_label') !!}" />
                                </div>
                                <div class="col-6">
                                    <x-form.input type="text" name="name" value="{{ $manager_edit->name }}"
                                        label="{!! __('words.checkout_form_first_name_label') !!}" required />
                                </div>
                                <div class="col-6">
                                    <x-form.input type="text" name="last_name"
                                        value="{{ $manager_edit->last_name }}" label="{!! __('words.checkout_form_lastname') !!}" />
                                </div>
                                <div class="col-6">
                                    <x-form.input type="tel" name="phone" value="{{ $manager_edit->phone }}"
                                        label="{!! __('words.checkout_form_phone') !!}" required />
                                </div>
                                <div class="col-6">
                                    <x-form.input type="text" name="tax" value="{{ $manager_edit->tax_id }}"
                                        label="{!! __('words.invoice_tax') !!}" />
                                </div>
                                <div class="col-6">
                                    <x-form.input type="text" name="email" value="{{ $manager_edit->email }}"
                                        label="{!! __('words.checkout_form_email') !!}" />
                                </div>
                                <div class="col-6">
                                    <x-form.input type="password" name="password" label="{!! __('words.password') !!}" />
                                </div>
                                <div class="col-6">
                                    <label for="meta_trainee">{!! __('words.trainee') !!}</label>
                                    <select class="form-control" name="meta[trainee]" id="meta_trainee">
                                        <option value="0" @if ($manager_edit->trainee == '0') selected @endif>
                                            {!! __('words.deactive') !!}</option>
                                        <option value="1" @if ($manager_edit->trainee == '1') selected @endif>
                                            {!! __('words.active') !!}</option>

                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="meta_self_checkout">{!! __('words.self_checkout') !!}</label>
                                    <select class="form-control" name="meta[self_checkout]" id="meta_self_checkout">
                                        <option value="0" @if ($manager_edit->self_checkout == '0') selected @endif>
                                            {!! __('words.deactive') !!}</option>
                                        <option value="1" @if ($manager_edit->self_checkout == '1') selected @endif>
                                            {!! __('words.active') !!}</option>

                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="meta_orders">{!! __('words.view_orders') !!}</label>
                                    <select class="form-control" name="meta[view_orders]" id="meta_orders">
                                        <option value="0" @if ($manager_edit->view_orders == '0') selected @endif>
                                            {!! __('words.no') !!}</option>
                                        <option value="1" @if ($manager_edit->view_orders == '1') selected @endif>
                                            {!! __('words.yes') !!}</option>

                                    </select>
                                </div>
                                @if ($manager_edit->trainee == '1')
                                    <div class="col-12">
                                        <label for="level">{!! __('words.level') !!}</label>
                                        <select class="form-control" name="meta[level]" id="level">
                                            <option value="">-- Select a level --</option>
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}"
                                                    @if ($manager_edit->level == $level->id) selected @endif>
                                                    {{ $level->title }}</option>
                                            @endforeach



                                        </select>
                                    </div>
                                    <div class="col-12 ">
                                        <label for="">{{ __('words.meta_trainee_service_type') }}</label>

                                        @foreach (['default', 'Offline', 'online'] as $option)
                                            <x-form.input type="checkbox" name="service_type[]"
                                                value="{{ $option }}" label="{{ ucwords($option) }}"
                                                :checked="in_array(
                                                    $option,
                                                    (array) json_decode($manager_edit->service_type),
                                                )" />
                                        @endforeach

                                    </div>

                                    <div class="col-12">
                                        <x-form.input type='text' name='meta[target]' :label="__('words.meta_trainee_target')"
                                            :value="$manager_edit->target" />
                                    </div>
                                    <div class="col-12">
                                        <x-form.input type='text' name='meta[sub_title]' :label="__('words.meta_trainee_sub_title')"
                                            :value="$manager_edit->sub_title" />
                                    </div>

                                    <div class="col-12">
                                        <label for="meta_trainee_details">{!! __('words.meta_trainee_details') !!}</label>
                                        <textarea name="meta[details]" id="meta_trainee_details" class="form-control" cols="30" rows="5">{{ $manager_edit->details }}</textarea>
                                    </div>
                                @endif
                            </div><br>
                            <button class="btn btn-primary "> <i class="fa fa-plus-square" aria-hidden="true"></i>
                                {!! __('words.update_manager_btn') !!}</button>
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{!! __('words.close_btn') !!}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            const price = +$('#product_price').text()
            $('#orderForm').click(() => {
                let manager = +$('.manager-check:checked').length
                $('#product_count').text(manager);
                $('#product_qty_count').val(manager);
                $('#product_total_input').val(price * manager);
                $('#product_total').text(price * manager);


            })
            $('#check-all').click((e) => {

                $('.manager-check').prop('checked', e.target.checked);
            })
            $('.manager-check').click((e) => {

                for (el of $('.manager-check')) {

                    if (el.checked == false) {

                        $('#check-all').prop('checked', false);

                        return;
                    } else {

                        $('#check-all').prop('checked', true);
                    }

                }
            })
        </script>
    @endpush
</x-dashboard.shop>
