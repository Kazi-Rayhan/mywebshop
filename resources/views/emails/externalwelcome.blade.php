@component('mail::message')
    <h1 style="text-align:center">{{ __('words.external_welcome_email_title') }}</h1>
    {!! __('words.external_welcome_email_body') !!}
    <ul style="list-style: none;margin:30px 0px;padding:0px;">
        <li>
            {{ __('words.login_url') }} : <a href="{{ $data['url'] }}">{{ $data['url'] }}</a>
        </li>
        <li>
            {{ __('words.external_email') }} : <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
        </li>
        <li>
            {{ __('words.external_password') }} : {{ $data['password'] }}
        </li>
    </ul>
    {!! __('words.external_welcome_email_footer') !!}

@endcomponent
