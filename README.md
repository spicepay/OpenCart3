# OpenCart3
SpicePay payment plugin for OpenCart3

Installation guide

1.	Download plugin and save to local disk. No need to unpack.
2.	Go to Opencart3 Admin -> Extension Installer -> Upload.
3.	Choose file with SpicePay module (opencart30.ocmod.zip). 
4.	If installation was successful, go to Extensions -> Payments. Find SpicePay module in the list. Enable it by clicking the "+" button.
5.	Set module settings:
SpicePay site ID: Add new site on https://www.spicepay.com/tools.php and set site ID in module settings.
SpicePay Callback Secret: - Set the same random secret string when adding site, and in OpenCart2 SpicePay module settings.
Order Status After Pay: - Complete Status: enabled.
Status: Enabled
Result URL: http://your-site.com/index.php?route=payment/spicepay/callback
Success URL: http://your-site.com/index.php?route=checkout/success
Fail URL: http://your-site.com/index.php?route=checkout/failure
6.  Click save button

Find more info on https://www.spicepay.com

SpicePay Team
