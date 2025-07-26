<p>1) Composer update/install </p>
 
<p>2) Run Migration 
php artisan migrate  </p>
					
<br />

<p>3) Update Paypal cilent id and client secrite key in .env file.</p>
<p>PAYPAL_MODE=sandbox/live</p>
<p>PAYPAL_CLIENT_ID=sandbox-id</p>
<p>PAYPAL_CLIENT_SECRET=sandbox-secret</p>

<br />

<p>4) Update client busness detaill like Business Email Name, Business Email, Paypal Business Email, website url at app/Services/PayPalInvoiceService./p>
<p>"business_name" => "ABC Business", // Business Name/p>
<p>"email" => "abc@xyz.com", // Business Email/p>
<p>"email_address" => "abc-xyz@business.example.com",  // Paypal Business Email/p>
<p>"website" => "https://abc-dummy-xyz.com"  // Business Webside</p>


<p>5) php artisan serve</p>
