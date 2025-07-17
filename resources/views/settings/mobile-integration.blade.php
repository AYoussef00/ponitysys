@extends('layouts.app')

@section('header')
دليل تكامل التطبيق
@endsection

@section('content')
<div class="space-y-6">
    <!-- SDK Download -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                تحميل SDK
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- iOS SDK -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v15m0 0h3.75M9 18H5.25M9 3h3.75M9 3H5.25M9 18l3-3m0 0l3 3m-3-3v12" />
                        </svg>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">iOS SDK</h4>
                            <p class="mt-1 text-sm text-gray-500">Swift Package Manager</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <pre class="bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>dependencies: [
    .package(url: "https://github.com/loyalty-saas/ios-sdk.git", from: "1.0.0")
]</code></pre>
                    </div>
                </div>

                <!-- Android SDK -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v15m0 0h3.75M9 18H5.25M9 3h3.75M9 3H5.25M9 18l3-3m0 0l3 3m-3-3v12" />
                        </svg>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Android SDK</h4>
                            <p class="mt-1 text-sm text-gray-500">Gradle</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <pre class="bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>implementation 'com.loyaltysaas:android-sdk:1.0.0'</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Integration Guide -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                دليل التكامل
            </h3>
        </div>
        <div class="p-6">
            <div class="prose max-w-none">
                <h4>التهيئة</h4>

                <div class="mt-6 space-y-6">
                    <!-- iOS Example -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="text-lg font-medium text-gray-900">iOS</h5>
                        <pre class="mt-2 bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>import LoyaltySaaS

LoyaltySaaS.initialize(apiKey: "YOUR_API_KEY")

// تسجيل نقاط
LoyaltySaaS.addPoints(
    customerId: "123",
    points: 100,
    description: "مشتريات في المتجر"
) { result in
    switch result {
    case .success(let points):
        print("تم إضافة النقاط بنجاح: \(points)")
    case .failure(let error):
        print("خطأ: \(error)")
    }
}</code></pre>
                    </div>

                    <!-- Android Example -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="text-lg font-medium text-gray-900">Android</h5>
                        <pre class="mt-2 bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>import com.loyaltysaas.sdk.LoyaltySaaS;

LoyaltySaaS.INSTANCE.initialize("YOUR_API_KEY");

// تسجيل نقاط
LoyaltySaaS.INSTANCE.addPoints(
    "123",
    100,
    "مشتريات في المتجر",
    new PointsCallback() {
        @Override
        public void onSuccess(Points points) {
            Log.d("LoyaltySaaS", "تم إضافة النقاط بنجاح: " + points);
        }

        @Override
        public void onError(Exception e) {
            Log.e("LoyaltySaaS", "خطأ: " + e.getMessage());
        }
    }
);</code></pre>
                    </div>
                </div>

                <h4 class="mt-8">استبدال المكافآت</h4>

                <div class="mt-6 space-y-6">
                    <!-- iOS Redemption -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="text-lg font-medium text-gray-900">iOS</h5>
                        <pre class="mt-2 bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>LoyaltySaaS.redeemReward(
    customerId: "123",
    rewardId: "456"
) { result in
    switch result {
    case .success(let redemption):
        print("تم الاستبدال بنجاح: \(redemption)")
    case .failure(let error):
        print("خطأ: \(error)")
    }
}</code></pre>
                    </div>

                    <!-- Android Redemption -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="text-lg font-medium text-gray-900">Android</h5>
                        <pre class="mt-2 bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>LoyaltySaaS.INSTANCE.redeemReward(
    "123",
    "456",
    new RedemptionCallback() {
        @Override
        public void onSuccess(Redemption redemption) {
            Log.d("LoyaltySaaS", "تم الاستبدال بنجاح: " + redemption);
        }

        @Override
        public void onError(Exception e) {
            Log.e("LoyaltySaaS", "خطأ: " + e.getMessage());
        }
    }
);</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- UI Components -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                مكونات واجهة المستخدم
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Points Balance Widget -->
                <div class="border rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900">عرض رصيد النقاط</h4>
                    <div class="mt-4">
                        <pre class="bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>// iOS
let pointsView = LoyaltyPointsView(customerId: "123")
view.addSubview(pointsView)

// Android
&lt;com.loyaltysaas.ui.PointsView
    android:id="@+id/pointsView"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    app:customerId="123" /&gt;</code></pre>
                    </div>
                </div>

                <!-- Rewards List Widget -->
                <div class="border rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900">قائمة المكافآت</h4>
                    <div class="mt-4">
                        <pre class="bg-gray-800 text-white p-4 rounded-md overflow-x-auto"><code>// iOS
let rewardsView = LoyaltyRewardsView(customerId: "123")
view.addSubview(rewardsView)

// Android
&lt;com.loyaltysaas.ui.RewardsView
    android:id="@+id/rewardsView"
    android:layout_width="match_parent"
    android:layout_height="wrap_content"
    app:customerId="123" /&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
