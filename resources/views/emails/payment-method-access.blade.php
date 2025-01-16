<!DOCTYPE html>

<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <title></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
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
</head>
@php
    $fee = $paymentMethodAccess->subscription->fee;
    $tax_amount = ($fee * 25) / (125);
    $fee_with_out_tax = $fee - $tax_amount;
    

@endphp

<body style="background-color: #fff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #fff;" width="100%">
        <tbody>
            <tr>
                <td>
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
                                                                style="font-size:20px; font-weight:777; background-color:#579c73;padding:5px 20px; border:1px solid #555;border-radius:10px">{{ __('words.plugin_email_confirm_title') }}</span>
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


                                    <table border="0" cellpadding="10" cellspacing="0"
                                        class="text_block block-3" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                        width="100%">
                                        <tr>
                                            <td class="pad">
                                                <div style="font-family: sans-serif">
                                                    <div class=""
                                                        style="font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #787771; line-height: 1.2; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b> {{ __('words.company_name') }}:
                                                                {{ setting('iziibuy.company_name') }}
                                                        </p>
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b>{{ __('words.address') }} :
                                                                {{ setting('iziibuy.address') }}
                                                        </p>
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b>{{ __('words.city_post_code') }}
                                                                :{{ setting('iziibuy.post_code') }}
                                                                {{ setting('iziibuy.city') }}
                                                        </p>
                                                        <p
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            <b>{{ __('words.organization_number') }} :
                                                                {{ setting('iziibuy.organization_number') }}
                                                        </p>
                                                        @if (setting('iziibuy.email'))
                                                            <p
                                                                style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                                <b>{{ __('words.email') }} :
                                                                    {{ setting('iziibuy.email') }}
                                                            </p>
                                                        @endif
                                                        @if (setting('iziibuy.phone'))
                                                            <p
                                                                style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                                <b>{{ __('words.phone') }} :
                                                                    {{ setting('iziibuy.phone') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="25" cellspacing="0"
                                        class="image_block block-4" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                        <tr>
                                            <td class="pad">
                                                {{-- <div align="center" class="alignment" style="line-height:10px"><img alt="Separator" src="{{secure_asset('images/separator.png')}}" style="display: block; height: auto; border: 0; width: 136px; max-width: 100%;" title="Separator" width="136"/></div> --}}
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


    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-7" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content"
                        role="presentation"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;background-color: #f8f9fc;padding:0 10px;"
                        width="680">
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="70%">
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
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;text-align: left;">
                                                            {{ __('words.plugin_cost') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="column column-2"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="30%">
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
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            {{ Iziibuy::price($fee_with_out_tax) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td class="column column-1"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="70%">
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
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;text-align: left;">
                                                            {{ __('words.tax') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="column column-2"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="30%">
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
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            {{ Iziibuy::price($tax_amount) }}
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
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="70%">
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
                                                            style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;text-align: left;">
                                                            {{ __('words.total') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="column column-2"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: center; background-color: #f9feff; padding-left: 15px; padding-right: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                    width="30%">
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
                                                            style="margin: 0; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                                            {{ Iziibuy::price($fee) }}
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
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px;background-color: #f8f9fc;padding:0 10px;"
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
                                                                    <p
                                                                        style="margin: 0; padding-bottom:5px; font-size: 14px; font-weight:700;mso-line-height-alt: 21px;">
                                                                        {{ __('words.invoice_address') }}</p>
                                                                    <div class=""
                                                                        style="font-size: 12px; border:1px solid #777; padding:10px 7px; mso-line-height-alt: 18px; color: #44464a; line-height: 1.5; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;">
                                                                        <p
                                                                            style="margin: 0; font-size: 14px;mso-line-height-alt: 21px;">
                                                                            {{ $paymentMethodAccess->user->name }}
                                                                            {{ $paymentMethodAccess->user->last_name }}
                                                                        </p>
                                                                        <p
                                                                            style="margin: 0; font-size: 14px;mso-line-height-alt: 21px;">
                                                                            {{ $paymentMethodAccess->user->phone }}</p>
                                                                        <p
                                                                            style="margin: 0; font-size: 14px;mso-line-height-alt: 21px;">
                                                                            {{ @$paymentMethodAccess->company_address->street }}
                                                                        </p>
                                                                        <p
                                                                            style="margin: 0; font-size: 14px;mso-line-height-alt: 21px;">
                                                                            {{ @$paymentMethodAccess->company_address->zip ? @$paymentMethodAccess->company_address->zip.', '  : ''}} {{ @$paymentMethodAccess->company_address->city }} 
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
                    </div>
                </td>
            </tr>
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
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px;background-color: #f8f9fc;padding:0 10px;"
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
                                                                        style="margin: 0; font-size: 14px;mso-line-height-alt: 21px; text-align:center">
                                                                        {{ __('words.email_footer') }} <a
                                                                            href="{{ env('APP_URL') }}"
                                                                            style="text-decoration: none; color:#555; font-weight:700">iziibuy.com</a>
                                                                    </p>
                                                                    {{-- <img alt="Separator" src="{{secure_asset('images/separator.png')}}" style="display: block; height: auto; border: 0; width: 136px; max-width: 100%;" title="Separator" width="136"/> --}}
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

    </td>
    </tr>
    </tbody>
    </table><!-- End -->
</body>

</html>
