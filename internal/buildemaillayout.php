<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$DOMAIN = $_SERVER['HTTP_HOST'];
$PROTOCOL = $_SERVER['HTTPS'] ? 'https://' : 'http://';

function getEmailObject($mailContext, $mailAddress, array $mailBody = null){    
    //strings
    error_log(print_r($mailBody));
    global $DOMAIN, $PROTOCOL;
    switch($mailContext){
        case 0:
            $heading = "Welcome to Ahvelo!";
            $bodyText = "Thank you for creating an account with us. We hope to serve you well!";
            $btnText = "VIEW ACCOUNT";
            $btnHref = $PROTOCOL.$DOMAIN."/customer/index.php";
            $closureText = "You can visit your account dashboard by pressing the button above.";
            break;
        case 1:
            $mailStatus = $mailBody['status'];
            $mailOrderId = $mailBody['order_id'];
            switch($mailStatus){
                case 'Pending':
                    $heading = "Your order is pending!";
                    $bodyText = "We have received your order, order $mailOrderId, and we are waiting for your payment! You can complete your payment by going to Your Orders.";
                    break;
                case 'Paid':
                    $heading = "You have paid for your order!";
                    $bodyText = "The payment for your order, order $mailOrderId, has been received. We will prepare your order shortly.";
                    break;
                case 'Preparing':
                    $heading = "Your order is in the kitchen!";
                    $bodyText = "We are now preparing for your order, order $mailOrderId.";
                    break;
                case 'Ready':
                    $heading = "Your order is ready!";
                    $bodyText = "Order $mailOrderId is now ready for pickup over the counter!";
                    break;
                case 'Complete':
                    $heading = "Thank you for your order!";
                    $bodyText = "We thank you for your order. Please enjoy your order, and we hope to see you soon!";
                    break;
                case 'Canceled':
                    $heading = "Your order was canceled!";
                    $bodyText = "Your order was canceled. Please contact the shop if you did not initiate this.";
                    break;
                default:
                    $heading = "Your order?";
                    $bodyText = "We did not know what happened to your order. Hopefully nothing really happened.";
                    break;
            }
            $btnText = "ACCOUNT PAGE";
            $btnHref = $PROTOCOL.$DOMAIN."/customer/index.php";
            $closureText = "You may view all your orders from your account page.";
            break;
        case 2:
            $resetPassUrl = $mailBody['reset_url'];
            $heading = "You requested for a password reset!";
            $bodyText = "We have received a request to send you a password reset link. This request is made using your email.";
            $btnText = "RESET PASSWORD";
            $btnHref = $PROTOCOL.$DOMAIN.$resetPassUrl;
            $closureText = "If this request was not from you, please ignore the email. Your account has not been compromised.";
            break;
        case 3:
            $heading = "New order received!";
            $bodyText = "A new order has been received from a customer. Please check the order.";
            $btnText = "VIEW ORDERS";
            $btnHref = $PROTOCOL.$DOMAIN."/staff/orders/index.php";
            $closureText = "Prepare the after payment confirmation.";
            break;
        default:
            $heading = "THIS EMAIL IS A BUG";
            $bodyText = "If you receive this email, please contact the system administrator IMMEDIATELY.";
            $btnText = "CONTACT ADMIN";
            $btnHref = $PROTOCOL.$DOMAIN."/contact.php";
            $closureText = "This email is a default email.";
            break;
    }
    return '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <!--[if gte mso 9]>
                <xml>
                    <o:OfficeDocumentSettings>
                        <o:AllowPNG/>
                        <o:PixelsPerInch>
                            96
                        </o:PixelsPerInch>
                    </o:OfficeDocumentSettings>
                </xml>
            <![endif]-->
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="x-apple-disable-message-reformatting">
            <!--[if !mso]>
                <!-->
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!--<![endif]-->
            <title>
            </title>
            <style type="text/css">
                @import url("https://fonts.googleapis.com/css2?family=League+Spartan:&display=swap");
                body {
                    font-family:"League Spartan",sans-serif;
                }
                .fw-black {
                    font-weight:900;
                }
                @media only screen and (min-width:520px) {
                    .u-row {
                        width:500px !important;
                    }
                    .u-row .u-col {
                        vertical-align:top;
                    }
                    .u-row .u-col-50 {
                        width:250px !important;
                    }
                    .u-row .u-col-100 {
                        width:500px !important;
                    }
                }@media (max-width:520px) {
                    .u-row-container {
                        max-width:100% !important;
                        padding-left:0px !important;
                        padding-right:0px !important;
                    }
                    .u-row .u-col {
                        min-width:320px !important;
                        max-width:100% !important;
                        display:block !important;
                    }
                    .u-row {
                        width:100% !important;
                    }
                    .u-col {
                        width:100% !important;
                    }
                    .u-col > div {
                        margin:0 auto;
                    }
                }
                body {
                    margin:0;
                    padding:0;
                }
                table,tr,td {
                    vertical-align:top;
                    border-collapse:collapse;
                }
                p {
                    margin:0;
                }
                .ie-container table,.mso-container table {
                    table-layout:fixed;
                }
                * {
                    line-height:inherit;
                }
                a[x-apple-data-detectors="true"] {
                    color:inherit!important;
                    text-decoration:none !important;
                }
                table,td {
                    color:#000000;
                }
                #u_body a {
                    color:#0000ee;
                    text-decoration:underline;
                }
                @media (max-width:480px) {
                    #u_column_1 .v-col-background-color {
                        background-color:#f0f0f0 !important;
                    }
                    #u_column_8 .v-col-background-color {
                        background-color:#f0f0f0 !important;
                    }
                }
            </style>
        </head>
        <body class="clean-body u_body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">
            <!--[if IE]>
                <div class="ie-container">
                <![endif]-->
                <!--[if mso]>
                    <div class="mso-container">
                    <![endif]-->
                    <table id="u_body" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%"
                    cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr style="vertical-align: top">
                                <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                    <!--[if (mso)|(IE)]>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="background-color: #e7e7e7;">
                                                <![endif]-->
                                                <div class="u-row-container" style="padding: 0px;background-color: transparent">
                                                    <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                                        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                                                            <!--[if (mso)|(IE)]>
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="padding: 0px;background-color: transparent;" align="center">
                                                                            <table cellpadding="0" cellspacing="0" border="0" style="width:500px;">
                                                                                <tr style="background-color: transparent;">
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                    <td align="center" width="500" class="v-col-background-color" style="background-color: #f0f0f0;width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"
                                                                                    valign="top">
                                                                                    <![endif]-->
                                                                                    <div id="u_column_1" class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
                                                                                        <div class="v-col-background-color" style="background-color: #f0f0f0;height: 100%;width: 100% !important;">
                                                                                            <!--[if (!mso)&(!IE)]><!-->
                                                                                                <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                                                                                <!--<![endif]-->
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:League Spartan,arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <h1 style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-family: League Spartan,arial black,AvenirNext-Heavy,avant garde,arial; font-size: 30px; font-weight: 900;">
                                                                                                                    AHVELO COFFEE
                                                                                                                </h1>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <!--[if (!mso)&(!IE)]><!-->
                                                                                                </div>
                                                                                            <!--<![endif]-->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--[if (mso)|(IE)]>
                                                                                    </td>
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            <![endif]-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="u-row-container" style="padding: 0px;background-color: transparent">
                                                    <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                                        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                                                            <!--[if (mso)|(IE)]>
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="padding: 0px;background-color: transparent;" align="center">
                                                                            <table cellpadding="0" cellspacing="0" border="0" style="width:500px;">
                                                                                <tr style="background-color: transparent;">
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                    <td align="center" width="500" class="v-col-background-color" style="background-color: #ffffff;width: 500px;padding: 15px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"
                                                                                    valign="top">
                                                                                    <![endif]-->
                                                                                    <div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
                                                                                        <div class="v-col-background-color" style="background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                            <!--[if (!mso)&(!IE)]><!-->
                                                                                                <div style="box-sizing: border-box; height: 100%; padding: 15px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                                <!--<![endif]-->
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <h2 style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-family: League Spartan, arial black,AvenirNext-Heavy,avant garde,arial; font-size: 24px; font-weight: 700;">
                                                                                                                    '.strtoupper($heading).'
                                                                                                                </h2>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:league spartan,arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <div style="font-size: 20px; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                                                                    <p style="line-height: 140%;">
                                                                                                                        '.$bodyText.' 
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <!--[if mso]>
                                                                                                                    <style>
                                                                                                                        .v-button {background: transparent !important;}
                                                                                                                    </style>
                                                                                                                <![endif]-->
                                                                                                                <div align="center">
                                                                                                                    <!--[if mso]>
                                                                                                                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
                                                                                                                        href="" style="height:37px; v-text-anchor:middle; width:132px;" arcsize="11%"
                                                                                                                        stroke="f" fillcolor="#3AAEE0">
                                                                                                                            <w:anchorlock/>
                                                                                                                            <center style="color:#FFFFFF;font-family:arial,helvetica,sans-serif;">
                                                                                                                            <![endif]-->
                                                                                                                            <a href="'. $btnHref. '" target="_blank" class="v-button" style="box-sizing: border-box;display: inline-block;font-family:league spartan,arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #FA3F3F; border-radius: 30px;-webkit-border-radius: 30px; -moz-border-radius: 30px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 14px;">
                                                                                                                                <span style="display:block;padding:10px 20px;line-height:120%;">
                                                                                                                                    <span style="line-height: 16.8px;">
                                                                                                                                        '. $btnText .'
                                                                                                                                    </span>
                                                                                                                                </span>
                                                                                                                            </a>
                                                                                                                            <!--[if mso]>
                                                                                                                            </center>
                                                                                                                        </v:roundrect>
                                                                                                                    <![endif]-->
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:league spartan,arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <div style="font-size: 20px; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                                                                    <p style="line-height: 140%;">
                                                                                                                        ' . $closureText . '
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <!--[if (!mso)&(!IE)]><!-->
                                                                                                </div>
                                                                                            <!--<![endif]-->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--[if (mso)|(IE)]>
                                                                                    </td>
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            <![endif]-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="u-row-container" style="padding: 0px;background-color: transparent">
                                                    <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                                        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                                                            <!--[if (mso)|(IE)]>
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="padding: 0px;background-color: transparent;" align="center">
                                                                            <table cellpadding="0" cellspacing="0" border="0" style="width:500px;">
                                                                                <tr style="background-color: transparent;">
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                    <td align="center" width="500" class="v-col-background-color" style="background-color: #f0f0f0;width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"
                                                                                    valign="top">
                                                                                    <![endif]-->
                                                                                    <div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
                                                                                        <div class="v-col-background-color" style="background-color: #f0f0f0;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                            <!--[if (!mso)&(!IE)]><!-->
                                                                                                <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                                <!--<![endif]-->
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:league spartan,arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <div style="font-size: 16px; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                                                                    <p style="line-height: 140%;">
                                                                                                                        For any inquiries regarding your order or account, please contact the
                                                                                                                        shop via phone.
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <!--[if (!mso)&(!IE)]><!-->
                                                                                                </div>
                                                                                            <!--<![endif]-->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--[if (mso)|(IE)]>
                                                                                    </td>
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            <![endif]-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="u-row-container" style="padding: 0px;background-color: transparent">
                                                    <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                                        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                                                            <!--[if (mso)|(IE)]>
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="padding: 0px;background-color: transparent;" align="center">
                                                                            <table cellpadding="0" cellspacing="0" border="0" style="width:500px;">
                                                                                <tr style="background-color: transparent;">
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                    <td align="center" width="250" class="v-col-background-color" style="background-color: #f0f0f0;width: 250px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"
                                                                                    valign="top">
                                                                                    <![endif]-->
                                                                                    <div id="u_column_8" class="u-col u-col-50" style="max-width: 320px;min-width: 250px;display: table-cell;vertical-align: top;">
                                                                                        <div class="v-col-background-color" style="background-color: #f0f0f0;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                            <!--[if (!mso)&(!IE)]><!-->
                                                                                                <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                                <!--<![endif]-->
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:league spartan,arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <div style="font-size: 15px; font-weight: 400; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                                                                    <p style="line-height: 140%; font-weight:900;">
                                                                                                                        AHVELO COFFEE SHOP
                                                                                                                    </p>
                                                                                                                    <p style="line-height: 140%;">
                                                                                                                        Laman Rafa,
                                                                                                                        <br />
                                                                                                                        Cendering,
                                                                                                                        <br />
                                                                                                                        21080 Kuala Terengganu,
                                                                                                                        <br />
                                                                                                                        Terengganu
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <!--[if (!mso)&(!IE)]><!-->
                                                                                                </div>
                                                                                            <!--<![endif]-->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--[if (mso)|(IE)]>
                                                                                    </td>
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                    <td align="center" width="250" class="v-col-background-color" style="background-color: #f0f0f0;width: 250px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"
                                                                                    valign="top">
                                                                                    <![endif]-->
                                                                                    <div class="u-col u-col-50" style="max-width: 320px;min-width: 250px;display: table-cell;vertical-align: top;">
                                                                                        <div class="v-col-background-color" style="background-color: #f0f0f0;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                            <!--[if (!mso)&(!IE)]><!-->
                                                                                                <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                                <!--<![endif]-->
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:league spartan,arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <div style="font-size: 15px; line-height: 140%; text-align: right; word-wrap: break-word;">
                                                                                                                    <p style="line-height: 140%; font-weight:900;">
                                                                                                                        OPERATING HOURS
                                                                                                                    </p>
                                                                                                                    <div>
                                                                                                                        <div>
                                                                                                                            <div>
                                                                                                                                Every day, 7.30AM - 2.00AM
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <!--[if (!mso)&(!IE)]><!-->
                                                                                                </div>
                                                                                            <!--<![endif]-->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--[if (mso)|(IE)]>
                                                                                    </td>
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            <![endif]-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="u-row-container" style="padding: 0px;background-color: transparent">
                                                    <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                                        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
                                                            <!--[if (mso)|(IE)]>
                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="padding: 0px;background-color: transparent;" align="center">
                                                                            <table cellpadding="0" cellspacing="0" border="0" style="width:500px;">
                                                                                <tr style="background-color: transparent;">
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                    <td align="center" width="500" class="v-col-background-color" style="background-color: #f0f0f0;width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"
                                                                                    valign="top">
                                                                                    <![endif]-->
                                                                                    <div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
                                                                                        <div class="v-col-background-color" style="background-color: #f0f0f0;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                            <!--[if (!mso)&(!IE)]><!-->
                                                                                                <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                                                                                                <!--<![endif]-->
                                                                                                <table style="font-family:arial,helvetica,sans-serif;" role="presentation"
                                                                                                cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:league spartan,arial,helvetica,sans-serif;"
                                                                                                            align="left">
                                                                                                                <div style="font-size: 12px; font-weight: 500; line-height: 140%; text-align: left; word-wrap: break-word;">
                                                                                                                    <p style="line-height: 140%;">
                                                                                                                        Disclaimer: This email was intended to be sent to '.$mailAddress.' from the Ahvelo Coffee Shop. If you are not the intended recipient, please
                                                                                                                        contact the shop via phone or email.
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <!--[if (!mso)&(!IE)]><!-->
                                                                                                </div>
                                                                                            <!--<![endif]-->
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--[if (mso)|(IE)]>
                                                                                    </td>
                                                                                <![endif]-->
                                                                                <!--[if (mso)|(IE)]>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            <![endif]-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--[if (mso)|(IE)]>
                                                </td>
                                            </tr>
                                        </table>
                                    <![endif]-->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!--[if mso]>
                    </div>
                <![endif]-->
                <!--[if IE]>
                </div>
            <![endif]-->
        </body>

    </html>

    ';
}
?>