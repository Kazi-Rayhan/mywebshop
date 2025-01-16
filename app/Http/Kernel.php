<?php

namespace App\Http;

use App\Http\Middleware\CartIsEmpty;
use App\Http\Middleware\checkMaster;
use App\Http\Middleware\EnterprisePaid;
use App\Http\Middleware\ExternalPaid;
use App\Http\Middleware\Localization;
use App\Http\Middleware\Paid;
use App\Http\Middleware\PaymentMethodAccessPaymentCheck;
use App\Http\Middleware\PermisssionMiddleware;
use App\Http\Middleware\PersonalClientMiddleware;
use App\Http\Middleware\PersonalTrainerMiddleware;
use App\Http\Middleware\ProtectedLink as MiddlewareProtectedLink;
use App\Http\Middleware\ShopCheck;
use App\Http\Middleware\ShopValidation;
use App\Http\Middleware\SubscribedForService;
use App\Models\ProtectedLink;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\ExtractUsernameFromRoute::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            Localization::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' => \App\Http\Middleware\CheckYourRoleHasPermission::class,
        'shopCheck' =>    ShopCheck::class,
        'canProvideService' => SubscribedForService::class,
        'isPersonalTrainer' => PersonalTrainerMiddleware::class,
        'personalClient' => PersonalClientMiddleware::class,
        'Paid' =>    Paid::class,
        'ExternalPaid' =>    ExternalPaid::class,
        'EnterprisePaid' =>  EnterprisePaid::class,
        'permission' => PermisssionMiddleware::class,
        'cartIsntEmpty' => CartIsEmpty::class,
        'checkShop' => ShopValidation::class,
        'checkMaster' => checkMaster::class,
        'checkIfPaid' => PaymentMethodAccessPaymentCheck::class,
        'protectedLink' => MiddlewareProtectedLink::class
    ];
}
