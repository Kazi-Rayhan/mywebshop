@component('mail::message')
    <h1 style="text-align:center">{{ __('words.shop_welcome_email_title') }}</h1>
    {!! __('words.shop_welcome_email_body') !!}
    <ul style="list-style: none;margin:30px 0px;padding:0px;">
        <li>
            {{ __('words.shop_url') }} : <a href="{{ $data['url'] }}">{{ $data['url'] }}</a>
        </li>
        <li>
            {{ __('words.shop_e_mail') }} : <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
        </li>
        <li>
            {{ __('words.shop_password') }} : {{ $data['password'] }}
        </li>
    </ul>
    {!! __('words.shop_welcome_email_footer') !!}

@endcomponent
