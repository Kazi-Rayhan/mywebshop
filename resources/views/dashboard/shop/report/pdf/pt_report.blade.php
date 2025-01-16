<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            font-size: 16px;
            text-align: center;
        }

        table th,
        table td {
            text-align: left;
            border: 1px solid #ccc;
            padding: 10px;
            vertical-align: middle;
            font-family: 'AdorshoLipi', sans-serif !important;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .ms-auto {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <h3 style="text-align:center;font-size:30px">{{ __('words.pt_report_sec_title') }} </h3>
    <hr>
    <table>

        @foreach ($data as $key => $value)
            @if (!in_array($key, ['inactive_client_list', 'bookings_do_not_show_up_list']))
                <tr>
                    <th>
                        {{ __('words.' . $key) }}
                    </th>
                    <td>
                        @if (is_array($value))
                            {{ implode(' / ', $value) }}
                        @else
                            {{ $value }}
                        @endif

                    </td>
                </tr>
            @else
                @if (count($value))
                    <tr>
                        <td colspan="2">
                            <table>
                                <tr>
                                    <th colspan="{{ count($value[0]) }}">
                                        {{ __('words.' . $key) }}
                                    </th>
                                </tr>
                                <tr>
                                    @foreach (array_keys($value[0]) as $header)
                                        <th>
                                            {{ __('words.' . $header) }}
                                        </th>
                                    @endforeach

                                </tr>
                                @foreach ($value as $row)
                                    <tr>
                                        @foreach ($row as $col)
                                            <td>
                                                {{ $col }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endif
            @endif
        @endforeach
    </table>

</body>

</html>
