@extends('voyager::master')

@section('page_title', 'Orders')


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

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet" type="text/css" />
    <style type="text/css">
        table.dataTable tbody td,
        table.dataTable tbody th {
            padding: 12px 19px;
        }

        .row {
            margin: 0;
            padding: 0;
        }

        .border {
            border: 1px solid #eee;
        }

        .p-2 {
            padding: 15px;
        }

        p {
            font-size: 17px
        }

        .mb-0 {
            margin-bottom: 0 !important;
            color: #000;
        }
    </style>
    <style>
        * {
            box-sizing: border-box;
        }

        body,
        th,
        td,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #787771 !important;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;

        }

        b,
        strong {
            font-weight: 700
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: inherit !important;
        }

        #MessageViewBody a {
            color: inherit;
            text-decoration: none;
        }

        p {
            line-height: inherit
        }

        .desktop_hide,
        .desktop_hide table {
            mso-hide: all;
            display: none;
            max-height: 0px;
            overflow: hidden;
        }

        .menu_block.desktop_hide .menu-links span {
            mso-hide: all;
        }

        @media (max-width:700px) {

            .desktop_hide table.icons-inner,
            .social_block.desktop_hide .social-table {
                display: inline-block !important;
            }

            .icons-inner {
                text-align: center;
            }

            .icons-inner td {
                margin: 0 auto;
            }

            .fullMobileWidth,
            .row-content {
                width: 100% !important;
            }

            .menu-checkbox[type=checkbox]~.menu-links {
                display: none !important;
                padding: 5px 0;
            }

            .menu-checkbox[type=checkbox]:checked~.menu-trigger .menu-open,
            .menu-checkbox[type=checkbox]~.menu-links span.sep {
                display: none !important;
            }

            .menu-checkbox[type=checkbox]:checked~.menu-links,
            .menu-checkbox[type=checkbox]~.menu-trigger {
                display: block !important;
                max-width: none !important;
                max-height: none !important;
                font-size: inherit !important;
            }

            .menu-checkbox[type=checkbox]~.menu-links>a,
            .menu-checkbox[type=checkbox]~.menu-links>span.label {
                display: block !important;
                text-align: center;
            }

            .menu-checkbox[type=checkbox]:checked~.menu-trigger .menu-close {
                display: block !important;
            }

            .mobile_hide {
                display: none;
            }

            .stack .column {
                width: 100%;
                display: block;
            }

            .mobile_hide {
                min-height: 0;
                max-height: 0;
                max-width: 0;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide,
            .desktop_hide table {
                display: table !important;
                max-height: none !important;
            }
        }

        #menu211:checked~.menu-links {
            background-color: #68a0a9 !important;
        }

        #menu211:checked~.menu-links a,
        #menu211:checked~.menu-links span {
            color: #ffffff !important;
        }
    </style>
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }
    </style>

    <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #fff;" width="100%">
        <tbody>
            <tr>
                <td>
                    {{-- <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #787771;"
                        width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                        class="row-content stack" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;"
                                        width="680">
                                        <tbody>
                                            <tr>
                                                <td class="column column-1"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                    width="100%">
                                                    <div class="spacer_block"
                                                        style="height:1px;line-height:1px;font-size:1px;"> </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table> --}}
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                        class="row-content stack" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;"
                                        width="680">
                                        <tbody>
                                            <tr>
                                                <td class="column column-1"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                    width="100%">
                                                    <div class="spacer_block"
                                                        style="height:5px;line-height:5px;font-size:1px;"> </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                        <tbody>
                            <tr>

                                <td class="column column-2"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="50%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="menu_block block-2"
                                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="color:#68a0a9;font-family:inherit;font-size:14px;padding-bottom:25px;padding-top:25px;text-align:center;">

                                            </td>
                                            <td class="column column-3"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                width="25%">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    class="text_block block-2" role="presentation"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                    width="100%">
                                                    <tr>
                                                        <td class="pad"
                                                            style="padding-bottom:25px;padding-right:5px;padding-top:27px;">
                                                            <div style="font-family: sans-serif">

                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;background-color: #f8f9fc;padding: 20px 10px 0;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="image_block block-1"
                                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                        width="100%">
                                        <tr>
                                            <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
                                                @if ($dataTypeContent->shop)
                                                    <div align="center" class="alignment" style="line-height:10px">
                                                        <img alt="{{ $dataTypeContent->shop?->user_name }}"
                                                            src="{{ Voyager::image($dataTypeContent->shop->logo) }}"
                                                            style="display: block; height: auto; border: 0; width: 272px; max-width: 100%;"
                                                            title="Light blue sphere with flowers" width="272" />
                                                    </div>
                                              
                                                @endif

                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="10" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word; "
                                        width="100%">
                                        <tr>
                                            <td class="pad">
                                                <div style="font-family: Georgia, serif">
                                                    <div class=""
                                                        style="font-size: 12px; font-family: 'Playfair Display', Georgia, serif; mso-line-height-alt: 14.399999999999999px; color: #44464a; line-height: 1.2;">
                                                        <p
                                                            style="margin: 0; margin-top:10px; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;">
                                                            <span
                                                                style="font-size:20px; font-weight:777; background-color:#fff74e;padding:5px 20px; border:1px solid #555;border-radius:10px">....Din
                                                                handlekurv....</span>
                                                        </p>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="10" cellspacing="0" class="text_block block-3"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad" style="padding:10px">
                                                <div style="font-family: sans-serif">
                                                    @if($dataTypeContent->shop)
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #787771; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b>Firma:</b> {{ $dataTypeContent->shop->company_name }}
                                                        </p>
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b>Org. Nr:</b>
                                                            {{ $dataTypeContent->shop->company_registration }}
                                                        </p>
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b>Adresse:</b> {{ $dataTypeContent->shop->street }}
                                                        </p>
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b>Sted:</b> {{ $dataTypeContent->shop->post_code }}
                                                            {{ $dataTypeContent->shop->city }}
                                                        </p>
                                                    </div>
                                                   
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pad" style="padding:10px">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #787771; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            Hei {{ $dataTypeContent->first_name }}
                                                            {{ $dataTypeContent->last_name }}</p>
                                                        <p
                                                            style="margin: 0; margin-top:10px; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            Her er varene du har lagt i handlekurven.</p>
                                                        <p
                                                            style="margin: 0; margin-top:10px; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            Dersom du ikke allerede har betalt kan du skanne QR koden
                                                            eller trykke på betalingslinken:</p>
                                                        <p
                                                            style="margin: 0; margin-top:10px; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            Om ønskelig kan betalingslink videresendes til annen
                                                            betaler:</p>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <table border="0" cellpadding="10" cellspacing="0" class="text_block block-3"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <thead>
                                            <tr>
                                            <tr>
                                                <td class="pad"
                                                    style="width:100%;padding-right:0px;padding-left:0px; padding:10px">
                                                    @if ($dataTypeContent->shop)
                                                        <div align="left" class="alignment" style="line-height:10px">
                                                            @if ($dataTypeContent->qrcode)
                                                                <a
                                                                    href="{{ route('payment', ['user_name' => $dataTypeContent->shop->user_name, 'order' => $dataTypeContent]) }}">
                                                                    <p>
                                                                        <img height="150px" width="150px"
                                                                            src="{{ Voyager::image($dataTypeContent->qrcode) }}"
                                                                            alt="payment qrcode"
                                                                            title="Skann QR koden for å betale">
                                                                </a>
                                                            @endif
                                                            <a
                                                                href="{{ route('payment', ['user_name' => $dataTypeContent->shop->user_name, 'order' => $dataTypeContent]) }}">
                                                                {{ route('payment', ['user_name' => $dataTypeContent->shop->user_name, 'order' => $dataTypeContent]) }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                            </tr>
                            </thead>
                    </table>

                    <table border="0" cellpadding="25" cellspacing="0" class="image_block block-4"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                        <tr>
                            <td class="pad">
                                {{--  <div align="center" class="alignment" style="line-height:10px"><img alt="Separator" src="{{secure_asset('images/separator.png')}}" style="display: block; height: auto; border: 0; width: 136px; max-width: 100%;" title="Separator" width="136"/></div>  --}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;background-color: #f8f9fc;padding: 0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 10px; padding-right: 10px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="66.66666666666667%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:25px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #44464a; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                            Ordrenummer: <span
                                                                style="color:#c4a07a;"><strong>{{ $dataTypeContent->id }}</strong></span>
                                                        </p>
                                                    </div>
                                                </div>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-3"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:10px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #44464a; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                            Ordredato:
                                                            {{ $dataTypeContent->created_at->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>


                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <div class="spacer_block" style="height:15px;line-height:15px;font-size:1px;">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-7" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #c4a07a; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                            Produkt</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="column column-2"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #c4a07a; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;">
                                                            Antall</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="column column-3"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #c4a07a; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: right; mso-line-height-alt: 16.8px;">
                                                            Totalt</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    @foreach ($dataTypeContent->products as $product)
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-12" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content"
                            role="presentation"
                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000;  background-color: #f8f9fc;padding:0 10px; width: 680px;"
                            width="680">
                            <tbody>
                                <tr>
                                    <td class="column column-1"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                            role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                            width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-bottom:15px;padding-left:10px;padding-top:15px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class=""
                                                            style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                            <p
                                                                style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                                {{ $product->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-2"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                            role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                            width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-bottom:15px;padding-left:5px;padding-right:5px;padding-top:15px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class=""
                                                            style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                            <p
                                                                style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;">
                                                                {{ $product->pivot->quantity }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-3"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                            role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                            width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-bottom:15px;padding-right:10px;padding-top:15px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class=""
                                                            style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                            <p
                                                                style="margin: 0; font-size: 14px; text-align: right; mso-line-height-alt: 16.8px;">
                                                                {{ Iziibuy::price($product->pivot->price, $dataTypeContent->shop) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-13" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-1"
                                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                        width="100%">
                                        <tr>
                                            <td class="pad">
                                                <div align="center" class="alignment">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td class="divider_inner"
                                                                style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                <span> </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-14" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                            <span style="font-size:16px;"><strong>Eks
                                                                    MVA</strong></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td class="column column-3"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: right; mso-line-height-alt: 16.8px;">
                                                            <span
                                                                style="font-size:16px;">{{ Iziibuy::price($dataTypeContent->subtotal, $dataTypeContent->shop) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-15" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-1"
                                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                        width="100%">
                                        <tr>
                                            <td class="pad">
                                                <div align="center" class="alignment">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td class="divider_inner"
                                                                style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                <span> </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    @if ($dataTypeContent->discount > 0)
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-16" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content"
                            role="presentation"
                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                            width="680">
                            <tbody>
                                <tr>
                                    <td class="column column-1"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                            role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                            width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class=""
                                                            style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                            <p
                                                                style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                                <span
                                                                    style="font-size:16px;"><strong>Rabatt</strong></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-2"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0"
                                            class="empty_block block-2" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-right:0px;padding-bottom:5px;padding-left:0px;padding-top:5px;">
                                                    <div></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-3"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                            role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                            width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class=""
                                                            style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                            <p
                                                                style="margin: 0; font-size: 14px; text-align: right; mso-line-height-alt: 16.8px;">
                                                                <span
                                                                    style="font-size:16px;">{{ Iziibuy::price($dataTypeContent->discount, $dataTypeContent->shop) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-17" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                            role="presentation"
                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                            width="680">
                            <tbody>
                                <tr>
                                    <td class="column column-1"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="100%">
                                        <table border="0" cellpadding="0" cellspacing="0"
                                            class="divider_block block-1" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div align="center" class="alignment">
                                                        <table border="0" cellpadding="0" cellspacing="0"
                                                            role="presentation"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                            width="100%">
                                                            <tr>
                                                                <td class="divider_inner"
                                                                    style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                    <span> </span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-16" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                            <span style="font-size:16px;"><strong>MVA</strong></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td class="column column-3"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: right; mso-line-height-alt: 16.8px;">
                                                            <span
                                                                style="font-size:16px;">{{ Iziibuy::price($dataTypeContent->tax, $dataTypeContent->shop) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="33.333333333333336%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                            <span style="font-size:16px;"><strong>Total</strong></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td class="column column-3"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="50%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: right; mso-line-height-alt: 16.8px;">
                                                            <span
                                                                style="font-size:20px;font-weight:bold;">{{ Iziibuy::price($dataTypeContent->total, $dataTypeContent->shop) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    @if ($dataTypeContent->shipping_cost > 0)
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-16" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content"
                            role="presentation"
                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; background-color: #f8f9fc;padding:0 10px;"
                            width="680">
                            <tbody>
                                <tr>
                                    <td class="column column-1"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                            role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                            width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class=""
                                                            style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                            <p
                                                                style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                                                <span style="font-size:16px;"><strong>Frakt</strong></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-2"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0"
                                            class="empty_block block-2" role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-right:0px;padding-bottom:5px;padding-left:0px;padding-top:5px;">
                                                    <div></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-3"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                        width="33.333333333333336%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="text_block block-2"
                                            role="presentation"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                            width="100%">
                                            <tr>
                                                <td class="pad"
                                                    style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;">
                                                    <div style="font-family: sans-serif">
                                                        <div class=""
                                                            style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                            <p
                                                                style="margin: 0; font-size: 14px; text-align: right; mso-line-height-alt: 16.8px;">
                                                                <span
                                                                    style="font-size:16px;">{{ Iziibuy::price($dataTypeContent->shipping_cost, $dataTypeContent->shop) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-17" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-1"
                                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                        width="100%">
                                        <tr>
                                            <td class="pad">
                                                <div align="center" class="alignment">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td class="divider_inner"
                                                                style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                <span> </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-18" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-left: 5px; padding-right: 5px; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <table border="0" cellpadding="10" cellspacing="0" class="text_block block-1"
                                        role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #68a0a9; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-19" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-20"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                        class="row-content stack" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                                        width="680">
                                        <tbody>
                                            <tr>
                                                <td class="column column-1"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 15px; padding-bottom: 15px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                    width="100%">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        class="text_block block-1" role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                                        width="100%">
                                                        <tr>
                                                            <td class="pad"
                                                                style="padding-bottom:15px;padding-left:35px;padding-right:35px;padding-top:15px;">
                                                                <div style="font-family: sans-serif">
                                                                    {{-- <p
                                                                    style="margin: 0; padding-bottom:5px; font-size: 14px; font-weight:700;  mso-line-height-alt: 21px;">
                                                                    Adresse</p>
                                                                <div class=""
                                                                    style="font-size: 12px; border:1px solid #777; padding:10px 7px; mso-line-height-alt: 18px; color: #44464a; line-height: 1.5; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                    <p
                                                                        style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px;">
                                                                        {{ $dataTypeContent->address }}</p>
                                                                    <p
                                                                        style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px;">
                                                                        Tel :{{ $dataTypeContent->phone }}</p>
                                                                    <p
                                                                        style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px;">
                                                                        {{ $dataTypeContent->state }}</p>
                                                                    <p
                                                                        style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px;">
                                                                        {{ $dataTypeContent->post_code }},{{ $dataTypeContent->city }}
                                                                    </p>
                                                                </div> --}}
                                                                    <div class=""
                                                                        style="margin-top:15px; font-size: 12px; mso-line-height-alt: 18px; color: #44464a; line-height: 1.5; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                        <p
                                                                            style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px;">
                                                                            Takk for handelen hos oss</p>
                                                                        <p
                                                                            style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px;">
                                                                            Hilsen
                                                                            {{ $dataTypeContent->shop?->company_name }},
                                                                        </p>
                                                                    </div>
                                                                    <div class=""
                                                                        style="margin-top:15px; font-size: 12px; mso-line-height-alt: 18px; color: #44464a; line-height: 1.5; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-21"
                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                        class="row-content stack" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;  background-color: #f8f9fc;padding:0 10px;"
                                        width="680">
                                        <tbody>
                                            <tr>
                                                <td class="column column-1"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                                    width="100%">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        class="image_block block-2" role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                            <td class="pad"
                                                                style="padding-bottom:25px;padding-left:25px;padding-right:25px;padding-top:50px;width:100%;">
                                                                <div align="center" class="alignment"
                                                                    style="line-height:10px">
                                                                    <p
                                                                        style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px; text-align:center">
                                                                        Digital butikk fra <a href="{{ env('APP_URL') }}"
                                                                            style="text-decoration: none; color:#555; font-weight:700">iziibuy.com</a>
                                                                    </p>
                                                                    {{--  <img alt="Separator" src="{{secure_asset('images/separator.png')}}" style="display: block; height: auto; border: 0; width: 136px; max-width: 100%;" title="Separator" width="136"/>  --}}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </td>
            </tr>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-24" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="100%">
                                    <table border="0" cellpadding="0" cellspacing="0" class="icons_block block-1"
                                        role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                        width="100%">
                                        <tr>
                                            <td class="pad"
                                                style="vertical-align: middle; color: #9d9d9d; font-family: inherit; font-size: 15px; padding-bottom: 5px; padding-top: 5px; text-align: center;">
                                                <table cellpadding="0" cellspacing="0" role="presentation"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                    <tr>
                                                        <td class="alignment"
                                                            style="vertical-align: middle; text-align: center;">
                                                            <!--[if vml]><table align="left" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block;padding-left:0px;padding-right:0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;"><![endif]-->
                                                            <!--[if !vml]><!-->
                                                            <table cellpadding="0" cellspacing="0" class="icons-inner"
                                                                role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;">
                                                                <!--<![endif]-->
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table><!-- End -->

@stop

@section('javascript')
    @if (request('action'))
        <script>
            $("#print").click();
        </script>
    @endif

    @if ($isModelTranslatable)
        <script>
            $(document).ready(function() {
                $('.side-body').multilingual();
            });
        </script>
        <script src="{{ voyager_asset('js/multilingual.js') }}"></script>
    @endif
@stop
