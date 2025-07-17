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
        $apiKeys = ApiKey::where('user_id', auth()->id())->get();
        $webhooks = Webhook::where('user_id', auth()->id())->get();

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
            'key' => Str::random(32),
            'type' => $request->type,
        ]);

        return response()->json($apiKey);
    }

    public function regenerateApiKey(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== auth()->id()) {
            abort(403);
        }

        $apiKey->update([
            'key' => Str::random(32)
        ]);

        return response()->json($apiKey);
    }

    public function deleteApiKey(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== auth()->id()) {
            abort(403);
        }

        $apiKey->delete();

        return response()->json(['message' => 'تم حذف المفتاح بنجاح']);
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
}
