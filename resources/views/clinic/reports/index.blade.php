@extends('layouts.clinic')
@section('title','Reports')
@section('page-title','Reports')
@section('breadcrumb','Home / Reports')

@section('content')
<div class="py-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        <a href="{{ route('reports.monthly') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition border border-gray-100 group">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-600 transition">
                    <i class="fas fa-calendar-alt text-blue-600 text-2xl group-hover:text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Monthly Report</h3>
                    <p class="text-gray-500 text-sm">Patient-wise monthly inspection and billing report</p>
                </div>
            </div>
        </a>
        <a href="{{ route('reports.income') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition border border-gray-100 group">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-600 transition">
                    <i class="fas fa-rupee-sign text-green-600 text-2xl group-hover:text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Income Report</h3>
                    <p class="text-gray-500 text-sm">Total income with monthly breakdown and trends</p>
                </div>
            </div>
        </a>
        <a href="{{ route('reports.repeated') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition border border-gray-100 group">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-600 transition">
                    <i class="fas fa-redo text-orange-600 text-2xl group-hover:text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Repeated Patients</h3>
                    <p class="text-gray-500 text-sm">Patients who visited more than once</p>
                </div>
            </div>
        </a>
        <a href="{{ route('patients.index') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition border border-gray-100 group">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-600 transition">
                    <i class="fas fa-users text-purple-600 text-2xl group-hover:text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Patient Reports</h3>
                    <p class="text-gray-500 text-sm">Click any patient to view their full report</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
