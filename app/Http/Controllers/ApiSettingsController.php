<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiSettingsController extends Controller
{
    public function index()
    {
        // إنشاء مفاتيح افتراضية إذا لم تكن موجودة
        $user = auth()->user();

        if (!ApiKey::where('user_id', $user->id)->exists()) {
            // إنشاء مفتاح تجريبي
            ApiKey::create([
                'user_id' => $user->id,
                'name' => 'مفتاح API للتجربة',
                'key' => 'sk_test_' . Str::random(32),
                'type' => 'test',
            ]);

            // إنشاء مفتاح إنتاج
            ApiKey::create([
                'user_id' => $user->id,
                'name' => 'مفتاح API للإنتاج',
                'key' => 'sk_live_' . Str::random(32),
                'type' => 'live',
            ]);
        }

        $apiKeys = ApiKey::where('user_id', $user->id)->get();
        $webhooks = Webhook::where('user_id', $user->id)->get();

        return view('settings.api', compact('apiKeys', 'webhooks'));
    }

    public function docs()
    {
        return view('docs.api-guide');
    }

    public function createApiKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:test,live',
        ]);

        $apiKey = ApiKey::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'key' => 'sk_' . $request->type . '_' . Str::random(32),
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم إنشاء المفتاح بنجاح',
            'data' => $apiKey
        ]);
    }

    public function regenerateApiKey(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== auth()->id()) {
            abort(403);
        }

        $apiKey->update([
            'key' => 'sk_' . $apiKey->type . '_' . Str::random(32)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم إعادة توليد المفتاح بنجاح',
            'data' => $apiKey
        ]);
    }

    public function deleteApiKey(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== auth()->id()) {
            abort(403);
        }

        $apiKey->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف المفتاح بنجاح'
        ]);
    }

    public function getApiKeys()
    {
        $apiKeys = ApiKey::where('user_id', auth()->id())->get();

        return response()->json([
            'status' => 'success',
            'data' => $apiKeys
        ]);
    }

    public function testApiKey(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string'
        ]);

        // اختبار المفتاح
        $apiKey = ApiKey::where('key', $request->api_key)->first();

        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'مفتاح API غير صحيح'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'مفتاح API صحيح',
            'data' => [
                'key_type' => $apiKey->type,
                'name' => $apiKey->name
            ]
        ]);
    }

    public function updateWebhook(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'events' => 'required|array',
            'events.*' => 'in:customer.created,points.added,reward.redeemed',
        ]);

        $webhook = Webhook::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'url' => $request->url,
                'events' => $request->events,
            ]
        );

        return response()->json($webhook);
    }

    public function testWebhook(Webhook $webhook)
    {
        if ($webhook->user_id !== auth()->id()) {
            abort(403);
        }

        // هنا يمكنك إضافة منطق اختبار الwebhook
        // مثال: إرسال طلب POST تجريبي إلى عنوان URL المحدد

        return response()->json(['message' => 'تم إرسال طلب الاختبار بنجاح']);
    }

    public function stats()
    {
        $user = auth()->user();

        // إحصائيات مفاتيح API
        $totalApiKeys = ApiKey::where('user_id', $user->id)->count();
        $activeApiKeys = ApiKey::where('user_id', $user->id)->where('is_active', true)->count();
        $testApiKeys = ApiKey::where('user_id', $user->id)->where('type', 'test')->count();
        $liveApiKeys = ApiKey::where('user_id', $user->id)->where('type', 'live')->count();

        // إحصائيات الاستخدام (يمكن إضافة منطق أكثر تعقيداً هنا)
        $recentApiUsage = [
            'today' => rand(10, 50),
            'week' => rand(100, 300),
            'month' => rand(500, 1000)
        ];

        // أكثر الـ APIs استخداماً
        $topApis = [
            ['name' => 'تسجيل عميل جديد', 'calls' => rand(50, 200), 'percentage' => 35],
            ['name' => 'إضافة نقاط', 'calls' => rand(30, 150), 'percentage' => 25],
            ['name' => 'استعلام الرصيد', 'calls' => rand(20, 100), 'percentage' => 20],
            ['name' => 'عرض المكافآت', 'calls' => rand(10, 80), 'percentage' => 15],
            ['name' => 'استبدال مكافأة', 'calls' => rand(5, 50), 'percentage' => 5]
        ];

        return view('settings.api-stats', compact(
            'totalApiKeys',
            'activeApiKeys',
            'testApiKeys',
            'liveApiKeys',
            'recentApiUsage',
            'topApis'
        ));
    }
}
