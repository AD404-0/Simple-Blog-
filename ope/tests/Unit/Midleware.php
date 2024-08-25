<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RedirectIfAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Define a test route
        Route::get('/home', function () {
            return 'Home';
        })->name('home');
    }

    public function testRedirectsAuthenticatedUser()
    {
        // Mock the Auth facade
        Auth::shouldReceive('guard')
            ->with(null)
            ->andReturnSelf()
            ->shouldReceive('check')
            ->andReturn(true);

        // Create a request and middleware instance
        $request = Request::create('/some-path', 'GET');
        $middleware = new RedirectIfAuthenticated();

        // Call the middleware
        $response = $middleware->handle($request, function () {});

        // Assert the user is redirected to the home route
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('home'), $response->headers->get('Location'));
    }

    public function testDoesNotRedirectUnauthenticatedUser()
    {
        // Mock the Auth facade
        Auth::shouldReceive('guard')
            ->with(null)
            ->andReturnSelf()
            ->shouldReceive('check')
            ->andReturn(false);

        // Create a request and middleware instance
        $request = Request::create('/some-path', 'GET');
        $middleware = new RedirectIfAuthenticated();

        // Call the middleware
        $response = $middleware->handle($request, function () {
            return response('Next middleware');
        });

        // Assert the user is not redirected and the next middleware is called
        $this->assertEquals('Next middleware', $response->getContent());
    }

    public function testRedirectsAuthenticatedUserWithCustomGuard()
    {
        // Mock the Auth facade for a custom guard
        Auth::shouldReceive('guard')
            ->with('custom_guard')
            ->andReturnSelf()
            ->shouldReceive('check')
            ->andReturn(true);

        // Create a request and middleware instance
        $request = Request::create('/some-path', 'GET');
        $middleware = new RedirectIfAuthenticated();

        // Call the middleware with a custom guard
        $response = $middleware->handle($request, function () {}, 'custom_guard');

        // Assert the user is redirected to the home route
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('home'), $response->headers->get('Location'));
    }
}