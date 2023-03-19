# System Introduction

This is a Laravel Readme.md file for a project that introduces the system as follows:

There is a table named Tenant, and once this table is created, a job is triggered. First, you need to make a request to "/tenant" in the Tenant table.

```
Route::post('/tenant', [LaravelForgeController::class, 'createTenant']);
```
# Postman Link
### https://www.postman.com/dark-station-425448/workspace/laravel-forge/collection/20110215-adc663f1-3ed6-44fc-836d-2c88243e9072?action=share&creator=20110215

# Example Response

```
{
    "project_name": "forge",
    "domain": "deneme213.org",
    "subdomain":null
}
```
# .env
```
# LARAVAL FORGE
FORGE_CLIENT_ID=
FORGE_SERVER_ID=
FORGE_SERVER_IP="123.123.123.123"
FORGE_API_KEY=
FORGE_BASE_URL="https://forge.laravel.com/api/v1",

# CLOUDFLARE
CLOUDFLARE_URL=https://api.cloudflare.com/
CLOUDFLARE_EMAIL=
CLOUDFLARE_API_KEY=
CLOUDFLARE_ACCOUNT_ID=
```

Then, the observer in the system will be triggered, and the request will be made through the domain in the table.

# Jobs

There are three jobs, and the necessary parameter operations are performed there.

# Notification

There are three notifications, and they perform the email process according to the conditions determined in the system.

# Integration

-   app/Integration/Client

I used Guzzle client here to avoid writing the same thing in each class.

-   app/Integration/CloudFlare

I created integration requirement functions here to create a site on Cloudflare.

-   app/Integration/Forge/Site

I created the necessary functions to create a site on Laravel Forge here.

-   app/Integration/Forge/SSL

I created the necessary functions to create an SSL on Laravel Forge here.

-   app/Integration/Forge/Forge

I created an intermediate layer for Laravel Forge requirements here. I added the necessary parameters and call functions.
