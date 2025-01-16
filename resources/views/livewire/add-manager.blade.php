<div>
    <form action="{{ route('shop.managers.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <table class="table">
            <tr>
                <th>
                    <h5>{!! __('words.charge') !!} :</h5>
                </th>
               
                <td colspan="5">
                    <button type="button" wire:click="addRow" class="btn btn-outline-info float-right">
                        <i class="fa fa-plus-square" aria-hidden="true"></i> {!! __('words.add_row_btn') !!}
                    </button>
                </td>
            </tr>
            <tr>
                <th>
                    {!! __('words.dashboard_product_image') !!}
                </th>
                <th>
                    {!! __('words.checkout_form_first_name_label') !!}
                </th>
                <th>
                    {!! __('words.checkout_form_lastname') !!}
                </th>
                <th>
                    {!! __('words.checkout_form_email') !!}
                </th>
                <th> {!! __('words.checkout_form_phone') !!}</th>
                <th> {!! __('words.invoice_tax') !!}</th>
                <th>
                    {!! __('words.password') !!}
                </th>
                <th>
                    {!! __('words.delete_btn') !!}
                </th>
            </tr>
            @foreach ($managers as $index => $manager)
                <tr>
                    <td>
                        <input type="file" class="form-control" name="managers[{{ $index }}][photo]"
                            wire:model="managers.{{ $index }}.photo">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="managers[{{ $index }}][first_name]"
                            wire:model="managers.{{ $index }}.first_name">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="managers[{{ $index }}][last_name]"
                            wire:model="managers.{{ $index }}.last_name">
                    </td>
                    <td>
                        <input type="email" class="form-control" name="managers[{{ $index }}][email]"
                            wire:model="managers.{{ $index }}.email">
                    </td>
                    <td>
                        <input type="tel" class="form-control" name="managers[{{ $index }}][phone]"
                            wire:model="managers.{{ $index }}.phone">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="managers[{{ $index }}][tax]"
                            wire:model="managers.{{ $index }}.tax">
                    </td>
                    <td>
                        <input type="password" class="form-control" name="managers[{{ $index }}][password]"
                            wire:model="managers.{{ $index }}.password">
                    </td>
                    <td>
                        <button type="button" wire:click="removeRow({{ $index }})"
                            class="btn btn-sm btn-outline-danger"><i class="fa fa-times"
                                aria-hidden="true"></i></button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6">
                    <button class="btn btn-outline-primary" type="submit">{!! __('words.save_btn') !!}</button>
                </td>
            </tr>
        </table>
    </form>
</div>
