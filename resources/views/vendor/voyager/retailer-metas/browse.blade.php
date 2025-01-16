@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing') . ' ' . $dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        {{-- @can('add', app($dataType->model_name)) --}}
        <a href="{{ route('admin.retailer.create-retailer') }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </a>

        <a href="{{ route('admin.retailer.retailer-withdrawals') }}" class="btn btn-success btn-add-new">
            <i class="voyager-receipt"></i> <span>Withdrawals</span>
        </a>
        {{-- @endcan --}}
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if (!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.' . $dataType->slug . '.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if ($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes"
                    data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}"
                    data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach ($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', [
                    'action' => $action,
                    'data' => null,
                ])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-2">
                                        <select id="search_key" name="key">
                                            @foreach ($searchNames as $key => $name)
                                                <option value="{{ $key }}"
                                                    @if ($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                            <option value="contains" @if ($search->filter == 'contains') selected @endif>
                                                contains</option>
                                            <option value="equals" @if ($search->filter == 'equals') selected @endif>=
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control"
                                            placeholder="{{ __('voyager::generic.search') }}" name="s"
                                            value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                            </form>
                        @endif
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>QR Code</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Parent</th>
                                        <th>Phone</th>
                                        <th>Total Earning</th>
                                        <th>Total Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTypeContent as $data)
                                        <tr>

                                            <td
                                                onclick="copyToclipboard(`{{ route('shop.register', ['refferal' => $data->user_id]) }}`)">
                                                <x-qr.direct :size="100" :url="route('shop.register', ['refferal' => $data->user_id])" :disabled="true" />
                                            </td>
                                            <td>
                                                {{ $data->user->name }}
                                            </td>
                                            <td>
                                                {{ $data->user->email }}
                                            </td>
                                            <td>
                                                @if($data->parent)
                                                Id :{{$data->parent_id}}
                                                <br>
                                                Name : {{$data->parent?->full_name }}
                                                <br>
                                                Email : {{$data->parent?->email }}
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td>
                                                {{ $data->user->phone }}
                                            </td>
                                            <td>
                                                {{ $data->user->totalEarning() }}
                                            </td>
                                            <td>
                                                {{ $data->user->totalBalance() }}
                                            </td>




                                            <td class="no-sort no-click bread-actions">

                                                <a href="{{ route('admin.retailer.report', $data->user->id) }}"
                                                    class="btn btn-sm btn-success pull-right"
                                                    style="margin-left:5px;">Report</a>
                                                <a href="{{ route('admin.retailer.retailer-withdrawals', ['user' => $data->user]) }}"
                                                    class="btn btn-success btn-add-new">
                                                    <i class="voyager-receipt"></i> <span>Withdrawals</span>
                                                </a>

                                                <button type="button" class="btn btn-primary bg-primary btn-lg"
                                                    data-toggle="modal"
                                                    data-url="{{ route('admin.retailer.retailer-withdrawals-balance', $data->user) }}"
                                                    data-balance="{{ $data->user->totalBalance() }}"
                                                    data-target="#withdrawModal">
                                                    Withdraw Balance</button>
                                                </button>
                                                <a href="{{ route('voyager.users.edit', $data->user->id) }}"
                                                    class="btn btn-danger">
                                                    <i class="voyager-receipt"></i> <span>Edit Profile</span>
                                                </a>
                                                @foreach ($actions as $action)
                                                    @if (!method_exists($action, 'massAction'))
                                                        @include('voyager::bread.partials.actions', [
                                                            'action' => $action,
                                                        ])
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">
                                    {{ trans_choice('voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total(),
                                    ]) }}
                                </div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                        's' => $search->value,
                                        'filter' => $search->filter,
                                        'key' => $search->key,
                                        'order_by' => $orderBy,
                                        'sort_order' => $sortOrder,
                                        'showSoftDeleted' => $showSoftDeleted,
                                    ])->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyToclipboard(textToCopy) {
            const tempInput = document.createElement('input');
            tempInput.setAttribute('value', textToCopy);
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Text copied to clipboard');
        }
    </script>
    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i>
                        {{ __('voyager::generic.delete_question') }}
                        {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                            value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="withdrawModal" tabindex="-1" data-backdrop="static" data-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">

                <div class="modal-body">

                    <form action="" id="withdrawForm" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="amount">Amount (<span class="font-weight-bold">Available for
                                        withdraw
                                        <span id="balanceAmount"></span> NOK</span>)</label>
                                <input id="amount" type="number" class="form-control" name="amount" required>
                            </div>
                            <div class="form-group">
                                <label for="trnx_id">Trnx ID</label>
                                <input id="trnx_id" type="text"
                                    class="form-control" name="trnx_id"
                                    required>
                                
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input id="date" type="date" value="{{now()->format('Y-m-d')}}"
                                    class="form-control" name="date"
                                    required>
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Withdraw</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge(
                        [
                            'order' => $orderColumn,
                            'language' => __('voyager::datatable'),
                            'columnDefs' => [['targets' => 'dt-not-orderable', 'searchable' => false, 'orderable' => false]],
                        ],
                        config('voyager.dashboard.data_tables', []),
                    ),
                    true,
                ) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function() {
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function(e) {
            $('#delete_form')[0].action = '{{ route('voyager.' . $dataType->slug . '.destroy', '__id') }}'.replace(
                '__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if ($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                        $('#show_soft_deletes').change(function() {
                            if ($(this).prop('checked')) {
                                $('#dataTable').before('<a id="redir"
                                    href =
                                    "{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 1]), true) }}" >
                                    <
                                    /a>');
                                }
                                else {
                                    $('#dataTable').before('<a id="redir"
                                        href =
                                        "{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 0]), true) }}" >
                                        <
                                        /a>');
                                    }

                                    $('#redir')[0].click();
                                })
                        })
                    @endif
                    $('input[name="row_id"]').on('change', function() {
                        var ids = [];
                        $('input[name="row_id"]').each(function() {
                            if ($(this).is(':checked')) {
                                ids.push($(this).val());
                            }
                        });
                        $('.selected_ids').val(ids);
                    });

                    $('#withdrawModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget) // Button that triggered the modal
                        var url = button.data('url') // Extract info from data-* attributes
                        var balance = button.data('balance') // Extract info from data-* attributes

                        $('#withdrawForm').attr('action', url)
                        $('#balanceAmount').text(balance); //
                        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                        var modal = $(this)

                    })
    </script>
@stop
