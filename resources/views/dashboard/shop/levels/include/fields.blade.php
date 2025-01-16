<div class="row">
    <div class="col-12 col-md-8">
        <x-form.input type="text" name="name"
            label="{{ __('words.dashboard_category_index_name') }}"
            value="{{ old('name', $level->title) }}" />
    </div>
    <div class="col-12 col-md-4">
        <x-form.input type="number" name="expire_session_commission"
            label="{{ __('words.expire_session_commission') }} %"
            value="{{ old('expire_session_commission', $level->expire_session_commission) }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="number" min="0" name="commission"
            label="{{ __('words.dashboard_commission') }}"
            value="{{ old('commission', $level->commission) }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="number" min="0" name="manager_session_commission"
            label="{{ __('words.dashboard_manager_session_commission') }}"
            value="{{ old('manager_session_commission', $level->manager_session_commission) }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="number" min="0" name="admin_session_commission"
            label="{{ __('words.dashboard_admin_session_commission') }}"
            value="{{ old('admin_session_commission', $level->admin_session_commission) }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="number" min="0" name="demo_session_commission"
            label="{{ __('words.dashboard_demo_session_commission') }}"
            value="{{ old('demo_session_commission', $level->demo_session_commission) }}" />
    </div>
</div>
<div class="row">
    <div class="col-12 table-responsive ">
        <table class="table text-center">
            <tr>
                <th>
                    Completed 
                </th>
                <th>
                    Bonus 
                </th>
                <th>
                    Completed 
                </th>
                <th>
                    Bonus
                </th>
                <th>
                    Completed
                </th>
                <th>
                    Bonus
                </th>
                <th>
                    Completed 
                </th>
                <th>
                    Bonus 
                </th>
            </tr>
            <tr>
                <td>
                    50 < 
                </td>
                <td>
                    <input type="number" min="0" name="bonus[50]" value="{{old('bonus.50',$level->bonus[50])}}">
                </td>
                <td>
                    < 70 <
                </td>
                <td>
                    
                    <input type="number" min="0" name="bonus[70]" value="{{old('bonus.70',$level->bonus[70])}}">
                </td>
                <td>
                    < 90 <
                </td>
                <td>
                    <input type="number" min="0" name="bonus[90]" value="{{old('bonus.90',$level->bonus[90])}}">
                    
                </td>
                <td>
                    < 110 <
                </td>
                <td>
                    <input type="number" min="0" name="bonus[110]" value="{{old('bonus.110', $level->bonus[110])}}">

                </td>
            </tr>
        </table>

    </div>
</div>