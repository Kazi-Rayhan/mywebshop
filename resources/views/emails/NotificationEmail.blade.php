@component('mail::message')
<h1>Hei,{{$data->name??''}}</h1>
<p>{!! $data->body !!}</p>

@component('mail::button', ['url' => $data->button_link])
{{$data->button_text}}
@endcomponent

Thank You<br>
{{ config('app.name') }}
@endcomponent
