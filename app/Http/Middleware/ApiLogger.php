<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class ApiLogger
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$controllerName = class_basename(Route::current()->controller)
			. '@' . class_basename(Route::current()->getActionMethod());
		activity()->log("Operation: {$controllerName} (controller)");
		return $next($request);
	}
}
