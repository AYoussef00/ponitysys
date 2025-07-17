@extends('layouts.app')

@section('header')
إضافة مكافأة جديدة
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('rewards.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    معلومات المكافأة
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    يرجى إدخال تفاصيل المكافأة
                </p>
            </div>
            <div class="p-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">عنوان المكافأة</label>
                    <div class="mt-1">
                        <input type="text" name="title" id="title" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('title') }}">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">وصف المكافأة</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">وصف مختصر للمكافأة وشروط استخدامها</p>
                </div>

                <div class="sm:col-span-3">
                    <label for="points_required" class="block text-sm font-medium text-gray-700">النقاط المطلوبة</label>
                    <div class="mt-1">
                        <input type="number" name="points_required" id="points_required" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('points_required') }}">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">الكمية المتاحة</label>
                    <div class="mt-1">
                        <input type="number" name="quantity" id="quantity" min="0" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('quantity') }}">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
                    <div class="mt-1">
                        <select name="status" id="status" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="expires_at" class="block text-sm font-medium text-gray-700">تاريخ الانتهاء</label>
                    <div class="mt-1">
                        <input type="date" name="expires_at" id="expires_at" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('expires_at') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('rewards.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                إلغاء
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                حفظ
            </button>
        </div>
    </form>
</div>
@endsection
