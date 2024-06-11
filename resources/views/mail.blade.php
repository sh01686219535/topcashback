<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/custom.css" />
    <title>QR code</title>
   
</head>
<body>
    <div class="card">


        <button type="button" style="background-color: #777;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;" class="collapsible1"><strong><h2 style="color: #B33DAB;">What could stop me from getting Cash Back?</h2></strong></button>
        <div style="padding: 0 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;" class="content1">
        <ul style="color: #1E603D;">
            <li>Physical Gift cards and e-Gift Cards purchases are not eligible for Cash Back with Under Armour.</li>
            <li>Cash Back is not available on orders deemed by Under Armour to be for reselling purposes.</li>
            <li>Orders placed by Under Armour employees or Under Armour sponsored athletes, Orders placed by Under Armour representatives via the Under Armour call center are not eligible for cash back.</li>
            <li>Combining promotions from another site and/or using a coupon code not posted and approved by TopCashback.</li>
            <li>Returning, exchanging, or canceling part of your order.</li>
            <li>Purchases made on other sites than Under Armour's US site.</li>
        </ul>
        </div>


        <button type="button" style="background-color: #777;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;" class="collapsible1"><strong><h2 style="color: #B33DAB;">What else is essential?</h2></strong>

    </button>
        <div style="padding: 0 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;" class="content1">
        <ul style="color: #1E603D;">
            <li>Cash Back amounts are generally based on your final purchase amount and do not include taxes, shipping, and the actual discount amount saved through coupons.</li>
            <li>Cash Back rates are subject to change, both up and down.</li>
            <li>You must start with an empty basket before clicking through to the retailer.</li>
            <li>Purchases must be completed immediately and fully online.</li>
        </ul>
        </div>

    </div>
    <script>
        var coll = document.querySelectorAll(".collapsible1");
        coll.forEach(function(item) {
            item.addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        });
    </script>
</body>
</html>
