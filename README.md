<p>1)composer update/install </p>
 
<p>2)Run Migration 
php artisan migrate  </p>

<p>3)update Paypal cilent id and client secrite key in .env file.
PAYPAL_MODE=sandbox/live
PAYPAL_CLIENT_ID=sandbox-id
PAYPAL_CLIENT_SECRET=sandbox-secret</p>

<p>4) update client busness detaill like Business Email Name, Business Email, Paypal Business Email, website url at app/Services/PayPalInvoiceService.
"business_name" => "ABC Business", // Business Name
"email" => "abc@xyz.com", // Business Email
"email_address" => "abc-xyz@business.example.com",  // Paypal Business Email
"website" => "https://abc-xyz.com"  // Business Webside</p>
					
<p>5) php artisan serve</p>
