<?php

use App\Helpers\Helper;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthCheckMiddleware;
use App\Http\Middleware\DeveloperMiddleware;
use App\Http\Middleware\OtpVerifiedMiddleware;
use App\Http\Middleware\OwnerMiddleware;
use App\Http\Middleware\RenterMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'auth', 'developer'])->prefix('developer')->name('developer.')->group(base_path('routes/developer.php'));
            Route::middleware(['web', 'auth', 'admin'])->prefix('admin')->name('admin.')->group(base_path('routes/backend.php'));
            Route::middleware(['api', 'otp', 'owner'])->prefix('api/owner')->name('api.owner.')->group(base_path('routes/owner.php'));
            Route::middleware(['api', 'otp', 'renter'])->prefix('api/renter')->name('api.renter.')->group(base_path('routes/renter.php'));
            Route::middleware(['api'])->prefix('api/')->name('api.')->group(base_path('routes/stripe.php'));
        }
    )
    ->withBroadcasting(
        __DIR__.'/../routes/channels.php',
        ['prefix' => 'api', 'middleware' => ['auth:api']],
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'developer' => DeveloperMiddleware::class,
            'admin' => AdminMiddleware::class,
            'owner' => OwnerMiddleware::class,
            'renter' => RenterMiddleware::class,
            'otp' => OtpVerifiedMiddleware::class,
            'authCheck' => AuthCheckMiddleware::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class
        ]);
        $middleware->validateCsrfTokens(except: [
            'api/payment/stripe/webhook',
        ]);
        $middleware->api([
            StartSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof ValidationException) {
                    return Helper::jsonErrorResponse($e->getMessage(), 422,$e->errors());
                }

                if ($e instanceof ModelNotFoundException) {
                    return Helper::jsonErrorResponse($e->getMessage(), 404);
                }

                if ($e instanceof AuthenticationException) {
                    return Helper::jsonErrorResponse( $e->getMessage(), 401);
                }
                if ($e instanceof AuthorizationException) {
                    return Helper::jsonErrorResponse( $e->getMessage(), 403);
                }
                // Dynamically determine the status code if available
                $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

                return Helper::jsonErrorResponse($e->getMessage(), $statusCode);
            }else{
                return null;
            }
        });
    })->create();
