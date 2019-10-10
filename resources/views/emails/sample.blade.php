<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <title>Invoice</title>



    <style>

        body {

            background-color: #f9f9f9;

        }



        .invoice-box {

            max-width: 800px;

            margin: auto;

            padding: 30px;

            border: 1px solid #eee;

            box-shadow: 0 0 10px rgba(0, 0, 0, .15);

            font-size: 16px;

            line-height: 24px;

            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;

            color: #555;

        }



        .invoice-box table {

            width: 100%;

            line-height: inherit;

            text-align: left;

        }



        .invoice-box table td {

            padding: 5px;

            vertical-align: top;

        }



        .invoice-box table tr td:last-child {

            text-align: center;

        }



        .invoice-box table tr.top table td {

            padding-bottom: 20px;

        }



        .invoice-box table tr.top table td.title {

            font-size: 45px;

            line-height: 45px;

            color: #333;

        }



        .invoice-box table tr.information table td {

            padding-bottom: 40px;

        }



        .invoice-box table tr.heading td {

            background: #eee;

            border-bottom: 1px solid #ddd;

            font-weight: bold;

        }



        .invoice-box table tr.details td {

            padding-bottom: 20px;

        }



        .invoice-box table tr.item td {

            border-bottom: 1px solid #eee;

        }



        .invoice-box table tr.item.last td {

            border-bottom: none;

            border-bottom: 1px solid #eee;

        }



        .invoice-box table tr.total td:nth-child(3) {

            border-top: 2px solid #eee;

            font-weight: bold;

        }



        .payment-btn {

            padding: 10px 15px;

            line-height: 16px;

            text-decoration: none;

            color: #fff;

            background: #f2f0f0;

            border: none;

        }



        .payment-btn:visited {

            padding: 10px 15px;

            line-height: 16px;

            text-decoration: none;

            color: #fff;

            background: #f2f0f0;

            border: none;

        }



        @media only screen and (max-width: 600px) {

            .invoice-box table tr.top table td {

                width: 100%;

                display: block;

                text-align: center;

            }



            .invoice-box table tr.information table td {

                width: 100%;

                display: block;

                text-align: center;

            }

        }



        /** RTL **/

        .rtl {

            direction: rtl;

            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;

        }



        .rtl table {

            text-align: left;

        }



        .rtl table tr td:nth-child(3) {

            text-align: left;

        }



        .box {

            background-color: #FFF;

            max-width: 800px;

            margin: auto;

            padding: 30px;

            border: 1px solid #eee;

            box-shadow: 0 0 10px rgba(0, 0, 0, .15);

            font-size: 16px;

            line-height: 24px;

            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;

            color: #555;

        }



        .box-information {

            margin: 0;

            margin-bottom: 30px;

            font-family: 'Open Sans', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;

            font-weight: 300;

            line-height: 1.5;

            font-size: 24px;

            color: #294661 !important;

        }



        .footer-logo tr {

            text-align: center !important;

        }



        .footer-title {

            box-sizing: border-box;

            font-family: 'Open Sans', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;

            vertical-align: top;

            font-size: 12px;

            text-align: center;

        }



    </style>

</head>



<body>

<div class="invoice-box">

    <table cellpadding="0" cellspacing="0">

        <tr class="top">

            <td colspan="4">

                <table>

                    <tr>

                        <td class="title" style="width:150px; height: 53px;">

                            <img src="{{$logoUrl}}" style="width:150px; height: 53px;">

                        </td>

                        <td></td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>





    <div class="box">

        <table cellpadding="0" cellspacing="0">

            <tr class="box-information" style="text-align:left;">

                <td colspan="4">

                    <table>

                        <tr>

                        </tr>

                    </table>

                </td>

            </tr>

            <tr class="information" style="text-align:left;">

                <td colspan="4">

                    <table>

                        <tr><td style="text-align: left">{!! $msg !!}</td></tr>

                    </table>

                </td>

            </tr>

        </table>

    </div>



    <table class="footer-logo" style="box-sizing:border-box;width:100%;border-spacing:0;font-size:12px;border-collapse:separate!important" width="100%">

        <tbody>

            <tr style="font-size:12px">

                <td>

                    <img src="{{$logoUrl}}" style="width:100%; max-width: 100px; margin-top: 30px;">

                </td>

            </tr>

            <tr style="font-size:12px">

                <td align="center" class="footer-title" valign="top">

                    <p style="margin:0;color:#294661;font-family:'Open Sans','Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif;font-weight:300;font-size:12px;margin-bottom:5px">© 2009 Trigger<sup>®</sup>, All Rights Reserved.</p>

                    <p style="margin:0;color:#294661;font-family:'Open Sans','Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif;font-weight:300;font-size:12px;margin-bottom:5px">

                        <a href="#" style="box-sizing:border-box;color:#348eda;font-weight:400;text-decoration:none;font-size:12px;padding:0 5px" target="_blank">Contact Us</a>

                        <a href="#" style="box-sizing:border-box;color:#348eda;font-weight:400;text-decoration:none;font-size:12px;padding:0 5px" target="_blank">Terms of Use</a>

                        <a href="#" style="box-sizing:border-box;color:#348eda;font-weight:400;text-decoration:none;font-size:12px;padding:0 5px" target="_blank">Privacy Policy</a>

                    </p>

                </td>

            </tr>

        </tbody>



    </table>

</div>

</body>

</html>