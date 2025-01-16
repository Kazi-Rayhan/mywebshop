<table class="text-center" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fff;color: black; padding: 40px 30px;">
    <tbody>
        <tr>
            <td>
                <table border="0" cellpadding="0" align="left" class="footer-social-icon" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td style="margin-top:15px; font-size: 12px; color: #44464a; line-height: 1.5;">
                                <p style="margin: 0; font-size: 14px;">
                                    {{ __('words.email_thankyou_pera') }}
                                </p>
                                <p style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px;">
                                    {{ __('words.email_regards') }} {{ $order->shop->company_name }},
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%">
                                <table class="contact-table" style="width: 100%; margin-top: 10px;">
                                    <tbody style="display: block; width: 100%;">
                                        <tr style="display: block; width: 100%;display: flex; align-items: center; justify-content: center;">
                                            <td>
                                                <p style="margin: 0; font-size: 14px;  mso-line-height-alt: 21px; text-align:center">
                                                    {{__('words.email_footer')}} <a href="{{ env('APP_URL') }}" style="text-decoration: none; color:#555; font-weight:700">iziibuy.com</a>
                                                </p>
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
</table>