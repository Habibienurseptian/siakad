<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Staf;

class CheckBidang
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('bidang:keuangan') or ->middleware('bidang:akademik')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$allowed
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$allowed)
    {
        $user = Auth::user();

        // if no authenticated user, deny
        if (!$user) {
            abort(403, 'Akses ditolak');
        }

        // staff record must exist
        $staf = Staf::where('user_id', $user->id)->first();
        if (!$staf) {
            abort(403, 'Akses staf tidak ditemukan');
        }

        $bidang = Str::lower(trim($staf->bidang ?? ''));

        // normalize allowed values
        $normalized = array_map(function ($v) {
            return Str::lower(trim($v));
        }, $allowed);

        // if any allowed value matches (partial match allowed e.g. 'keu' in 'keuangan')
        foreach ($normalized as $allow) {
            if ($allow === $bidang || Str::contains($bidang, $allow) || Str::contains($allow, $bidang)) {
                return $next($request);
            }
        }

        // otherwise forbidden
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini');
    }
}
