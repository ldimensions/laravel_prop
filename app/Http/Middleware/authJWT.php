namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class authJWT
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
        try {
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error'=>'Token is Invalid. Please logout and login again']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error'=>'Token is Expired. Please logout and login again']);
            }else{
                return response()->json(['error'=>'Something is wrong!. Please logout and login again']);
            }
        }
        return $next($request);
    }
}
