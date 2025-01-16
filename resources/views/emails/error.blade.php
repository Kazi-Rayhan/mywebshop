<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error in Your Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #e74c3c;
        }

        pre {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            overflow-x: auto;
        }

        p {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Error in Your Application</h1>
        <p>{{ $exception->getMessage() }}</p>

        <ul>
            @auth
                <li>User : {{ auth()->id() }} </li>
            @endauth
            <li>Url : {{ request()->url() }}</li>
            <li>File : {{ $exception->getFile() }}</li>
            <li>Line : {{ $exception->getLine() }}</li>
        </ul>
        <pre>
{{ $exception }}
        </pre>
    </div>
</body>

</html>
