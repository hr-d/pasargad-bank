# pasargad-gateway

set under params to environment
PASARGAD_BASE_API_URL
PASARGAD_TERMINAL_ID
PASARGAD_USERNAME
PASARGAD_PASSWORD

for purchase use purchase method
(new payment)->purchase(
    $invoice, // invoice number
    $invoiceDate,  // invoice date with any format
    $amount, // amount by Rial
    $callbackApi, 
    $mobileNumber (optional),
    $email (optional)
);

for confirm transaction use confirm method
(new payment)->confirm(
    $invoice,
    $urlId
);
