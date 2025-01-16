<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iziipay Payment</title>

</head>

<body>
    <div id="abcd"></div>


    <script src="{{asset('payment/iziipay.js')}}"></script>
    <script>
        Iziipay.init('#abcd', {
            apiKey: "6326ffdb-87a1-44d9-8950-cc87e8f5f8eb",
            buttonText: 'Pay',
            source_key: "e598021f-4841-469c-a000-4e211005c46d",
        
            amount: "10000",
            currency: "NOK",
        });
    </script>
</body>

</html>
