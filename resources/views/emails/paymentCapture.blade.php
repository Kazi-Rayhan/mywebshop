<!-- resources/views/emails/payment_capture.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('words.elavon_verification-title') }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .button {
            display: inline-block;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out,
                box-shadow 0.15s ease-in-out;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>{{ __('words.elavon_verification-title') }}</h2>

        <p>{{ __('words.elavon_verification-body') }}.</p>

        <p>{{ __('words.elavon_verification-instuction') }}</p>

        <a class="button" href="{{ $viewLink }}">{{ __('words.elavon_verification-btntxt') }}</a>
    </div>

</body>

</html>
