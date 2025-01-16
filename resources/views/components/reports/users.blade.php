<div class="card">
    <div class="card-header">
<h4>{{$title}}</h4>
    </div>
    <div class="card-body">

    <table class="table">
        <thead>

            <tr>
                <th>{{ __('words.profile_image') }}</th>
                <th>{{ __('words.checkout_form_first_name_label') }}</th>
                <th>{{ __('words.checkout_form_lastname') }}</th>
                <th>{{ __('words.checkout_form_email') }}</th>
                <th>{{ __('words.invoice_tel') }}</th>
            </tr>
        </thead>
        <tbody id="container">
            @foreach ($users as $user)
           
                <tr>
                    <td>
                        <img src="{{ Iziibuy::image($user->avatar) }}" style="width: 60px">
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->last_name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->phone }}

                    </td>
                
                   
                </tr>
            @endforeach
                <tr>
                    <td colspan="5">
                        {{$users->links()}}
                    </td>
                </tr>
        </tbody>

    </table>
</div>
</div>