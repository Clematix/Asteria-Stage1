<?php

class Zend_Controller_Action_Helper_Mail extends Zend_Controller_Action_Helper_Abstract {

   public function sendmail($data)
   {
 $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' .
                '<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <title>CustomDesign_email</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <style type="text/css">
@media only screen and (max-width:500px) {
table[class="wrapper"] {
 min-width: 320px !important;
}
table[class="flexible"] {
 width: 100% !important;
}
td[class="img-flex"] img {
 width: 100% !important;
 height: auto !important;
}
.im{
color:#555 !important;
}
}
</style>
 </head>' . '<body style="margin:0; padding:0;">
<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0"><div class="adM">
    </div><div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0"><div class="adM">
        </div><table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
            <tbody><tr>
                <td align="center" valign="top" style="padding:20px 0 20px 0">
                    <table bgcolor="FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #e0e0e0">
                        <tbody><tr>
                            <td valign="top">
                                <a href="http://demo.clematix.com/asteria/admin" style="color:#1e7ec8" target="_blank"><img src="http://demo.clematix.com/asteria/public/asteria/logo.png" alt="Asteria" border="0" class="CToWUd"></a>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <h1 style="font-size:22px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Dear '.$data['firstname'].' '. $data['lastname'].'</h1>
                                <p style="font-size:12px;line-height:16px;margin:0 0 8px 0">New account hase been created for your account in Asteria ERP.</p>
                                <p style="font-size:12px;line-height:16px;margin:0">Please click on the following link to access Asteria ERP: <a href="http://demo.clematix.com/asteria/admin/auth/login" style="color:#1e7ec8" target="_blank">http://demo.clematix.com/asteria/admin/auth/login</a></p>
                                <p style="font-size:12px;line-height:16px;margin:0">If clicking the link does not work, please copy and paste the URL into your browser instead.</p>
                               
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#eaeaea;text-align:center"><p style="font-size:12px;margin:0;text-align:center">Thank you, <strong>Asteria Aerospace</strong></p></td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table><div class="yj6qo"></div><div class="adL">
    </div></div><div class="adL">
</div></div>
</body>
</html>';
        $to = $data['email'];
        $subject = 'Asteria Aerospace :  New account';
        $from = 'info@clematixdigital.com';
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $from . "\r\n";
        $headers .= "Bcc: kumaran.m89@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        if (mail($to, $subject, $message, $headers)) {
           return true;
        } else {
            return false;
        }
   }
}
