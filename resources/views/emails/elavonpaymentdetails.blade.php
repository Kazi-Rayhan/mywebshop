<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details for Elavon Payment</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }



        table {
            width: 600px;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        h4 {
            font-family: 'Verdana', Geneva, Tahoma, sans-serif;
            margin: 0;
            color: #333;
        }

        img {
            max-width: 100%;
            height: auto;
        }

    </style>
</head>

<body>


    <table class="table table-bordered  w-50 mx-auto">
        <thead>
            <tr>
                <th colspan="2">
                    <h4 class="text-center" style="font-family: Verdana, Geneva, Tahoma, sans-serif">
                        {{ __('words.company_information') }}
                    </h4>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    {{ __('words.name') }} :
                </th>
                <td>
                    {{ $shop->name }}
                </td>
            </tr>
            <tr>
                <th>
                    {{ __('words.business_address') }} :
                </th>
                <td>
                    {{ $shop->businessAddress }}
                </td>
            </tr>

            <tr>
                <th>
                    {{ __('words.contact_phone') }} :
                </th>
                <td>
                    {{ $shop->contact_phone }}
                </td>
            </tr>
            <tr>
                <th>
                    {{ __('words.contact_person') }} :
                </th>
                <td>
                    {{ $shop->contactPerson }}
                </td>
            </tr>
            <tr>
                <th>
                    {{ __('words.contact_email') }} :
                </th>
                <td>
                    {{ $shop->contact_email }}
                </td>
            </tr>
            <tr>
                <th>
                    {{ __('words.company_name') }} :
                </th>
                <td>
                    {{ $shop->company_name }}
                </td>
            </tr>
            <tr>
                <th>
                    {{ __('words.comapny_address') }} :
                </th>
                <td>
                    {{ $shop->comapny_address }}
                </td>
            </tr>
            
        </tbody>

    </table>


</body>

</html>
