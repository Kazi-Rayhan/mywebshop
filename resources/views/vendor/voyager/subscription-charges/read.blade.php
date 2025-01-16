@extends('voyager::master')

@section('page_title', 'Orders')
@php


    $messages = [
        '20000' => 'Approved',
        '40000' => 'Declined',
        '40110' => 'Invalid card number',
        '40111' => 'Unsupported card scheme',
        '40120' => 'Invalid CSC',
        '40130' => 'Invalid expire date',
        '40135' => 'Card expired',
        '40140' => 'Invalid currency',
        '40150' => 'Invalid text on statement',
        '40200' => 'Clearhaus rule violation',
        '40300' => '3-D Secure problem',
        '40310' => '3-D Secure authentication failure',
        '40400' => 'Backend problem',
        '40410' => 'Declined by issuer or card scheme',
        '40411' => 'Card restricted',
        '40412' => 'Card lost or stolen',
        '40413' => 'Insufficient funds',
        '40414' => 'Suspected fraud',
        '40415' => 'Amount limit exceeded',
        '40416' => 'Additional authentication required',
        '40420' => 'Merchant blocked by cardholder',
        '50000' => 'Clearhaus error',
    ];
    //  dd($transiction);
@endphp
@section('page_header')

    <h1 class="page-title hidden-print">
        <i class="{{ $dataType->icon }}"></i> Orders &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.' . $dataType->slug . '.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp;
                Edit
            </a>
        @endcan
        <a href="{{ route('voyager.' . $dataType->slug . '.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            Order List
        </a>
        <button onClick="window.print()" class="btn btn-dark" id="print">
            <span class="glyphicon glyphicon-print"></span>&nbsp;
            Print
        </button>
    </h1>
    @include('voyager::multilingual.language-selector')
@stop
@section('content')
    <style>
        p {
            margin: 0;
        }

        .auth-btn {
            padding: 2px 5px;
            font-size: 9px !important;
            margin-left: 5px;
        }

        .auth-price {
            font-weight: 700;
            margin: 0;
            color: #fff !important;
            font-size: 12px;
        }

        .auth-title {
            margin: 0;
            color: #fff !important;
            font-size: 9px;
            font-weight: 600;
        }

        .auth-card {
            background-color: #295acc;
            padding: 8px 20px;
            border-radius: 5px;

        }

        .auth-card-2 {
            padding: 8px 20px;
            border-radius: 5px;
        }

        .d-flex {
            display: flex;
        }

        .transiction-info p {
            font-size: 9px;
            color: #444 !important;
        }

        .transiction-info {
            padding-top: 10px;
            padding-bottom: 10px;
            margin-bottom: 0 !important;



        }

        .row {
            margin-left: 5px;
            margin-right: 0;
        }

        .trans-data {
            font-weight: 600;
            font-size: 11px !important;
            border-bottom: 1px solid #dadada;
            padding-bottom: 5px;


        }

        .border {
            border-radius: 5px;
        }

        .trans-title {
            margin-left: 20px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .details-title {
            color: #888 !important;
            font-weight: 600;
            margin-left: 5px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .mt-2 {
            margin-top: 30px !important;
        }

        .mt-1 {
            margin-top: 5px !important;
        }

        .border-radius {
            border-radius: 5px;
        }

        .border-top-0 {
            border-top: none !important;
        }

        .border-bottom-1 {
            border-bottom: 1px solid #eaeaea;
        }

        .text-muted {
            color: #777 !important;
        }

        td {
            font-size: 11px !important;
            font-weight: 600;
        }

        hr {
            border: 1px solid #dadada;
        }

        .ms-3 {
            margin-left: 30px;
        }

        .gap-4 {
            margin-right: 20px;
        }

        .active-footer {
            border: 1px solid #295acc !important;
        }
    </style>
    <div class="container">
        <h6 class="trans-title">Transiction Details</h6>
        <div class="row ">
            <div class="col-md-3">
                <div class="card auth-card">
                    <p class="auth-title">{{ $transiction->type }}</p>
                    <h6 class="auth-price">{{ Iziibuy::round_num($transiction->amount/100) }} {{ $transiction->currency }} <a href=""
                            class="btn @if ($transiction->status->code == '20000') btn-success @else btn-warning @endif auth-btn">
                            @if ($transiction->status->code == '20000')
                                Approved
                            @else
                                Declined
                            @endif
                        </a></h6>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card border">
                    <div class="row">
                        <div class="col-md-3 transiction-info">
                            <p>Date</p>
                            <p class="trans-data">
                                {{ Carbon\Carbon::parse($transiction->processed_at)->format('d M Y, s:i:h') }}</p>
                        </div>
                        <div class="col-md-3 transiction-info">
                            <p>Number</p>
                            <p class="trans-data"> <span class="glyphicon glyphicon-ok"></span>
                                {{ $transiction->card->bin }} *** {{ $transiction->card->last4 }}</p>
                        </div>
                        <div class="col-md-3 transiction-info">
                            <p>References</p>
                            <p class="trans-data"> </span> {{ $transiction->reference }}</p>
                        </div>
                        <div class="col-md-2 transiction-info">
                            <p>3-D Secure</p>
                            <p class="trans-data">{{ $transiction->threed_secure }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <h6 class="details-title">Details</h6>
            <div class="card border-radius">
                <div class="row">
                    <div class="col-md-4">
                        <div class="transiction-info">
                            <p>Status</p>
                            <p class="trans-data">{{ $transiction->status->code }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transiction-info">
                            <p>Status Massage</p>
                            <p class="trans-data">{{ $messages[$transiction->status->code] }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transiction-info">
                            <p>Requting</p>
                            @if ($transiction->recurring == true)
                                <p class="trans-data">Yes</p>
                            @else
                                <p class="trans-data">No</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transiction-info">
                            <p>Payment Method</p>
                            <p class="trans-data"><span class="glyphicon glyphicon-credit-card"></span>
                                {{ $transiction->payment_method }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transiction-info">
                            <p>RRN</p>
                            <p class="trans-data">{{ $transiction->rrn }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transiction-info">
                            <p>ID</p>
                            <p class="trans-data">{{ $transiction->id }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="transiction-info">
                            <p>ARN</p>
                            <p class="trans-data">{{ @$transiction->arn ? $transiction->arn : '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="transiction-info">
                            <p>Text On Payment</p>
                            <p class="trans-data">{{ $transiction->text_on_statement }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @if (isset($transiction->settlement))
        <h6 class="details-title mt-2">Settlement</h6>
        <div class="card border-radius">
            <table class="table table-hover">
                <tr>
                    <td class="border-top-0">Amount gross</td>
                </tr>
                <tr>
                    <td>Fees</td>
                    <td>{{ Iziibuy::round_num($transiction->settlement->fees/100) }} {{ $transiction->settlement->currency }}</td>
                </tr>
                <tr>

                    @foreach ($transiction->settlement->fee_details as $auth)
                        <td class="text-muted">{{ $auth->type }}</td>
                        <td class="border-bottom-1 text-muted">{{ Iziibuy::round_num($auth->amount/100) }}
                            {{ $transiction->settlement->currency }}</td>
                    @endforeach

                </tr>
                <tr>
                    <td>Amount net</td>
                </tr>
            </table>
        </div>

        @endif


            <hr>
            <div class="d-flex ">
                <a href="" class="btn btn-default gap-4"> Trail</a>
                @foreach ($datas as $key=>$data)
                    <a href="{{ route('voyager.charges.show', [$dataTypeContent, 'mode' => $key]) }}" class=" gap-4">
                        <div class='card auth-card-2 @if ($transiction->type == $data->type) active-footer @endif'>
                            <p class="auth-title text-muted">{{ ucfirst($data->type) }} <span class="ms-3"> <span
                                        class="glyphicon glyphicon-dashboard"></span>
                                    {{ Carbon\Carbon::parse($data->processed_at)->format('d M Y') }}</span></p>
                            <h6 class="auth-price text-muted mt-1">{{ Iziibuy::round_num($data->amount/100) }} {{ $data->currency }}
                                @if ($data->status->code == '20000')
                                    <span class="glyphicon glyphicon-ok-sign text-success"></span>
                                @endif
                            </h6>
                        </div>
                    </a>
                @endforeach



            </div>
        </div>
    </div>







@stop
