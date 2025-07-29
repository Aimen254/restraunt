@extends('spa')

@section('title', 'Profile')
@section('header', 'Your Profile')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="md:flex md:space-x-8">
                    <!-- Sidebar Navigation -->
                    <div class="md:w-1/4 mb-6 md:mb-0">
                        <div class="space-y-1">
                            <a href="#profile-info" 
                               class="block px-4 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md">
                                Profile Information
                            </a>
                            <a href="#update-password" 
                               class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                                Update Password
                            </a>
                            <a href="#delete-account" 
                               class="block px-4 py-2 text-sm font-medium text-red-600 hover:bg-gray-100 rounded-md">
                                Delete Account
                            </a>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="md:w-3/4 space-y-6">
                        <!-- Profile Information -->
                        <div id="profile-info">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h2>
                            <div class="bg-white p-6 rounded-lg shadow">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <!-- Update Password -->
                        <div id="update-password">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Update Password</h2>
                            <div class="bg-white p-6 rounded-lg shadow">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                        <!-- Delete Account -->
                        <div id="delete-account">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Delete Account</h2>
                            <div class="bg-white p-6 rounded-lg shadow">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection