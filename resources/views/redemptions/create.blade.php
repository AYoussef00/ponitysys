@extends('layouts.app')

@section('header')
تسجيل استبدال جديد
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('redemptions.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    تفاصيل الاستبدال
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    يرجى اختيار العميل والمكافأة المراد استبدالها
                </p>
            </div>
            <div class="p-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <label for="customer" class="block text-sm font-medium text-gray-700">العميل</label>
                    <div class="mt-1">
                        <select id="customer" name="customer" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">اختر العميل</option>
                            <option value="1">عبدالرحمن يوسف - 1,250 نقطة</option>
                            <option value="2">سارة أحمد - 3,500 نقطة</option>
                            <option value="3">محمد علي - 750 نقطة</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="reward" class="block text-sm font-medium text-gray-700">المكافأة</label>
                    <div class="mt-1">
                        <select id="reward" name="reward" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">اختر المكافأة</option>
                            <option value="1">قسيمة شراء بقيمة 100 ريال - 1,000 نقطة</option>
                            <option value="2">خصم 25% على المشتريات - 2,500 نقطة</option>
                            <option value="3">هدية مجانية - 500 نقطة</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">ملخص الاستبدال</h4>
                                <div class="mt-1 space-y-1">
                                    <p class="text-sm text-gray-500">النقاط المتاحة: <span class="font-medium text-gray-900">1,250</span></p>
                                    <p class="text-sm text-gray-500">النقاط المطلوبة: <span class="font-medium text-gray-900">1,000</span></p>
                                    <p class="text-sm text-gray-500">النقاط المتبقية: <span class="font-medium text-gray-900">250</span></p>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    متاح للاستبدال
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700">ملاحظات</label>
                    <div class="mt-1">
                        <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    تأكيد الاستبدال
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="confirm_customer" name="confirm_customer" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </div>
                        <div class="mr-3 text-sm">
                            <label for="confirm_customer" class="font-medium text-gray-700">تأكيد هوية العميل</label>
                            <p class="text-gray-500">لقد تحققت من هوية العميل وأنه مؤهل للاستبدال</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="confirm_terms" name="confirm_terms" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </div>
                        <div class="mr-3 text-sm">
                            <label for="confirm_terms" class="font-medium text-gray-700">الموافقة على الشروط</label>
                            <p class="text-gray-500">أوافق على شروط وأحكام برنامج الولاء</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('redemptions.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                إلغاء
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                تأكيد الاستبدال
            </button>
        </div>
    </form>
</div>
@endsection
