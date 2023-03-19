# System Introduction

This is a Laravel Readme.md file for a project that introduces the system as follows:

There is a table named Tenant, and once this table is created, a job is triggered. First, you need to make a request to "/tenant" in the Tenant table.

```
Route::post('/tenant', [LaravelForgeController::class, 'createTenant']);
```

# Example Response

```
{
    "project_name": "forge",
    "domain": "deneme213.org",
    "subdomain":null
}
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
