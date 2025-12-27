namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LibrarianOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isLibrarian()) {
            abort(403, 'Forbidden: Librarian only');
        }
        return $next($request);
    }
}
