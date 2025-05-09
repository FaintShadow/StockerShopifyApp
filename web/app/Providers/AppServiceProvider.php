<?php

namespace App\Providers;

use App\Lib\DbSessionStorage;
use App\Lib\Handlers\AppUninstalled;
use App\Lib\Handlers\Privacy\CustomersDataRequest;
use App\Lib\Handlers\Privacy\CustomersRedact;
use App\Lib\Handlers\Privacy\ShopRedact;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Shopify\ApiVersion;
use Shopify\Context;
use Shopify\Exception\MissingArgumentException;
use Shopify\Webhooks\Registry;
use Shopify\Webhooks\Topics;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @throws MissingArgumentException
     */
    public function boot(): void
    {
        $host = config('shopify.host');

        $customDomain = config('SHOP_CUSTOM_DOMAIN', null);
        Context::initialize(
            config('shopify.api_key', 'not_defined'),
            config('shopify.api_secret', 'not_defined'),
            config('shopify.api_scopes', 'not_defined'),
            $host,
            new DbSessionStorage(),
            ApiVersion::LATEST,
            true,
            false,
            null,
            '',
            null,
            (array)$customDomain,
        );

        URL::useOrigin("https://$host");
        URL::forceScheme('https');

        Registry::addHandler(Topics::APP_UNINSTALLED, new AppUninstalled());

        /*
         * This sets up the mandatory privacy webhooks. You’ll need to fill in the endpoint to be used by your app in
         * the “Privacy webhooks” section in the “App setup” tab, and customize the code when you store customer data
         * in the handlers being registered below.
         *
         * More details can be found on shopify.dev:
         * https://shopify.dev/docs/apps/webhooks/configuration/mandatory-webhooks
         *
         * Note that you'll only receive these webhooks if your app has the relevant scopes as detailed in the docs.
         */
        Registry::addHandler('CUSTOMERS_DATA_REQUEST', new CustomersDataRequest());
        Registry::addHandler('CUSTOMERS_REDACT', new CustomersRedact());
        Registry::addHandler('SHOP_REDACT', new ShopRedact());
    }
}
