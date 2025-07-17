@extends('layouts.app')

@section('header')
إضافة عميل جديد
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('customers.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    معلومات العميل
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    يرجى إدخال معلومات العميل الأساسية
                </p>
            </div>
            <div class="p-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">الاسم الأول</label>
                    <div class="mt-1">
                        <input type="text" name="first_name" id="first_name" autocomplete="given-name" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">الاسم الأخير</label>
                    <div class="mt-1">
                        <input type="text" name="last_name" id="last_name" autocomplete="family-name" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" autocomplete="email" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="phone" class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
                    <div class="mt-1">
                        <input type="tel" name="phone" id="phone" autocomplete="tel" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">تاريخ الميلاد</label>
                    <div class="mt-1">
                        <input type="date" name="birth_date" id="birth_date" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="address" class="block text-sm font-medium text-gray-700">العنوان</label>
                    <div class="mt-1">
                        <textarea id="address" name="address" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    إعدادات النقاط
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    تحديد الإعدادات الأولية لنقاط العميل
                </p>
            </div>
            <div class="p-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="initial_points" class="block text-sm font-medium text-gray-700">النقاط الأولية</label>
                    <div class="mt-1">
                        <input type="number" name="initial_points" id="initial_points" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="0">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="tier" class="block text-sm font-medium text-gray-700">المستوى</label>
                    <select id="tier" name="tier" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="bronze">برونزي</option>
                        <option value="silver">فضي</option>
                        <option value="gold">ذهبي</option>
                        <option value="platinum">بلاتيني</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    إعدادات إضافية
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="notifications" name="notifications" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </div>
                    <div class="mr-3 text-sm">
                        <label for="notifications" class="font-medium text-gray-700">تفعيل الإشعارات</label>
                        <p class="text-gray-500">سيتم إرسال إشعارات للعميل عند تحديث النقاط أو توفر مكافآت جديدة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('customers.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                إلغاء
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                حفظ
            </button>
        </div>
    </form>
</div>
@endsection
