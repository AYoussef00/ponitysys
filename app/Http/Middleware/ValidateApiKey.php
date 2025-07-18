<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // الحصول على مفتاح API من header
        $apiKey = $request->header('Authorization');

        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'مفتاح API مطلوب'
            ], 401);
        }

        // إزالة "Bearer " من بداية المفتاح
        $apiKey = str_replace('Bearer ', '', $apiKey);

        // البحث عن مفتاح API في قاعدة البيانات
        $key = ApiKey::where('key', $apiKey)
                    ->where('is_active', true)
                    ->first();

        if (!$key) {
            return response()->json([
                'status' => 'error',
                'message' => 'مفتاح API غير صحيح أو غير نشط'
            ], 401);
        }

        // تحديث آخر استخدام للمفتاح
        $key->markAsUsed();

        // إضافة معلومات المستخدم والمفتاح إلى الطلب للاستخدام لاحقاً
        $request->merge([
            'api_key_user_id' => $key->user_id,
            'api_key_type' => $key->type,
            'api_key_id' => $key->id
        ]);

        return $next($request);
    }
}
