@extends('voyager::master')

@section('page_title', 'changelog')

@section('content')

    <style>
        ul {
            color: #8492a6;
        }
    </style>
    <div class="container">
        <div class="row" style="margin-top:20px; display:flex; justify-content:center">
            <div class="col-md-6 mt-5">
                @foreach ($changelogs as $date => $changelog)
                    <h5 class="mt-4" style="font-size: 18px; margin-top: 30px;"> <span class=""
                            style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; padding:12px;border-radius:10px; color:green">{{ $changelog[0]['version'] }}</span>
                        -
                        {{ Carbon\Carbon::parse($date)->format('jS F Y') }}</h5>
                    <p class="mt-4 " style="margin-top: 30px;">
                    <ul>
                        @foreach ($changelog as $log)
                            <li>{{ $log->type }}: {{ $log->description }}</li>
                        @endforeach
                    </ul>
                    </p>
                @endforeach
                <div class="mt-4">
                    <a href="https://iziibuy.com" class="btn btn-primary" target="_new">Iziibuy</a>
                    <br><br><br><br><br><br><br><br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
