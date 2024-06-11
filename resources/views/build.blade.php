<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <title>QR code</title>
</head>
<body>
    <div class="card text-center" class="mx-auto">

        <h2>Use me</h2>

        {!! $qr_image !!}
        <p style="font-size: 12px;"><b>Your Purchase Code Is this:</b>  {!! $randomString !!}</p>
        <p style="font-size: 12px;"><b>Your Purchase Offer:</b>  {!! $offerTitle !!}</p>
        <p style="font-size: 12px;"><b>Your Purchase Amount Is This:</b>  {!! $offerAmount !!}</p>


    </div>
</body>
</html>
