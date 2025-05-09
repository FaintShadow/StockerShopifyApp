<?php

use App\Lib\EnsureBilling;

return [

    /*
    |--------------------------------------------------------------------------
    | Shopify billing
    |--------------------------------------------------------------------------
    |
    | You may want to charge merchants for using your app. Setting required to true will cause the EnsureShopifySession
    | middleware to also ensure that the session is for a merchant that has an active one-time payment or subscription.
    | If no payment is found, it starts off the process and sends the merchant to a confirmation URL so that they can
    | approve the purchase.
    |
    | Learn more about billing in our documentation: https://shopify.dev/docs/apps/billing
    |
    */
    "billing" => [
        "required" => false,

        // Example set of values to create a charge for $5 one time
        "chargeName" => "My Shopify App One-Time Billing",
        "amount" => 5.0,
        "currencyCode" => "USD", // Currently only supports USD
        "interval" => EnsureBilling::INTERVAL_ONE_TIME,
    ],

    /*
    |--------------------------------------------------------------------------
    | Shopify API Key
    |--------------------------------------------------------------------------
    |
    | This option is for the app's API key.
    |
    */

    'api_key' => env('SHOPIFY_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Shopify API Secret
    |--------------------------------------------------------------------------
    |
    | This option is for the app's API secret.
    |
    */

    'api_secret' => env('SHOPIFY_API_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Shopify API Scopes
    |--------------------------------------------------------------------------
    |
    | This option is for the scopes your application needs in the API.
    |
    */

    'api_scopes' => env('SHOPIFY_API_SCOPES', 'read_products,write_products,read_themes'),

    /*
    |--------------------------------------------------------------------------
    | Shopify App Name
    |--------------------------------------------------------------------------
    |
    | This option simply lets you display your app's name.
    |
    */

    'app_name' => env('SHOPIFY_APP_NAME', 'Shopify App'),


    'host' => env('SHOPIFY_HOST', env('APP_URL')),

];
