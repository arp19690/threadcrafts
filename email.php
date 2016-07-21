<?php
$to = "arp19690@gmail.com";
$subject = "Hacking you now";
$txt = "Change your password by visiting here - [VIRUS LINK HERE]";
$headers = "From: customercare@craftsvilla.com";
if(mail($to,$subject,$txt,$headers))
{
    print 'sent';
}
else
{
    print 'not sent';
}
?>