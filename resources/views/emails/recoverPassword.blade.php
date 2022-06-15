{{--<head></head>--}}
{{--<body><p> You recently requested a password reset with us.</p>--}}
{{--<p>Please click <a href='$ConfirmationUrl$'>here</a> to be directed to a page to reset your password. Thanks!</p>--}}


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0px;
            padding: 0px;
            border: 0px;
        }

        html {
            margin: 0px;
            padding: 0px;
            border: 0px;
        }

        main {
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        section {
            /* border: 0.1px solid black; */
            display: flex;
            flex-direction: column;
            margin: 7% 12% 12% 12%;
            width: 480px;
            height: 500px;
            box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.15);
        }

        img {
            width: 100px;
        }

        h3 {
            font-weight: bold;
            font-size: 20px;
            font-family: Verdana, Geneva, Tahoma, sans-serif ;
            padding: 20px 20px 7px 20px;
        }

        #we {
            padding: 20px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color:#50504E;
        }

        h2 {
            border: 0.1px solid rgb(118, 111, 111);
            font-size: 16px;
            font-weight: bold;
            padding: 24px 0px 24px 15px;
            font-family:  'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border-top-left-radius: 9px 9px;
            border-top-right-radius: 9px 9px;
        }

        #others {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            border: 0.1px solid rgb(118, 111, 111);
        }

        #others div {
            padding: 10px 20px 10px 20px;
        }

        #others div p {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        #div1 {
            color: #797A74;
        }
        #div2 {
            color:#50504E;
        }

        #base {
            border: 0.1px solid rgb(118, 111, 111);
            padding: 22px 15px 22px 15px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            border-bottom-left-radius: 9px 9px;
            border-bottom-right-radius: 9px 9px;
        }

        #base p {
            background: #76938F;
            width: 250px;
            /* height: 33px; */
            color: white;
            text-align: center;
            padding: 10px 13px 10px 13px;
            font-size: 14px;
            border-radius: 5px;
        }

        article {
            box-shadow: 0 8px 8px 0 rgba(0, 0, 0, 0.15);
            /* border: 2px solid blue; */
            border-radius: 9px;
            /* border-top-left-radius: 40px 40px; */
        }

        #footer {
            color:#50504E;
            font-weight: bold;
        }
    </style>
</head>
<body>
<main>
    <section>
        <img src="{{ asset('images/logo.png') }}" alt="">
        <h3>Did you change your password?</h3>
        <p id="we"> We noticed the password  for your Atelier account  was recently changed if this was you can safely disregard this email</p>
        <article>
            <h2>Changed password</h2>
            <div id="others">
                <div id="div1">
                    <p>When</p>
                    <p>Where</p>
                    <p>Device</p>
                </div>
                <div id="div2">
                    <p>Sun, Mar 24, 2021, 3:18 PM</p>
                    <p>Denver, United States</p>
                    <p>Chrome using Mac</p>
                </div>
            </div>
            <div id="base">
                <p><a href="{{ route('resetPassword', ['token' => $token]) }}">Yes, recover my password</a></p>
            </div>
            <div id="base">
                <p> This wasn't me- review my account</p>
            </div>
        </article>
        <br><br>
        <p id="footer">Sent from Atelier</p>
        <p id="footer">Atelier, Inc, Address</p>
    </section>
</main>
</body>
</html>
