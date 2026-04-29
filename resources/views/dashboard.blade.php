<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white dark:bg-gray-900 transition-colors -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('Welcome to Ambulance Dispatch System') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('Manage ambulances, dispatches, and drivers efficiently') }}
                </p>
            </div>

            <!-- Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md dark:shadow-lg sm:rounded-lg mb-6 transition-colors border border-gray-200 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-50">
                    <h2 class="text-xl font-semibold mb-3 text-indigo-600 dark:text-indigo-400">
                        {{ __('Dark Mode Activated! ✨') }}
                    </h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        {{ __('You can toggle Dark Mode using the button in the top-right corner of the navbar. Your preference is automatically saved and will be remembered on your next visit.') }}
                    </p>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <ul class="list-disc list-inside space-y-1">
                            <li>{{ __('Smooth transitions between light and dark modes') }}</li>
                            <li>{{ __('Preference saved in your browser') }}</li>
                            <li>{{ __('Follows system preference if not set') }}</li>
                            <li>{{ __('Comfortable colors for extended viewing') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg dark:hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">🚑 Ambulances</h3>
                        <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-xs font-medium">
                            Active
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Manage and monitor all ambulances in your fleet') }}
                    </p>
                    <button class="inline-block bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        View Fleet
                    </button>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg dark:hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📋 Dispatches</h3>
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-xs font-medium">
                            48 Today
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Track all dispatch assignments and status') }}
                    </p>
                    <button class="inline-block bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        View Dispatches
                    </button>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg dark:hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">👨‍✈️ Drivers</h3>
                        <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1 rounded-full text-xs font-medium">
                            28 Drivers
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Manage driver information and schedules') }}
                    </p>
                    <button class="inline-block bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        View Drivers
                    </button>
                </div>

                <!-- Card 4 -->
                <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg dark:hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📅 Schedule</h3>
                        <span class="bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 px-3 py-1 rounded-full text-xs font-medium">
                            12 Events
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('View upcoming events and ambulance schedules') }}
                    </p>
                    <button class="inline-block bg-orange-600 hover:bg-orange-700 dark:bg-orange-700 dark:hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        View Schedule
                    </button>
                </div>

                <!-- Card 5 -->
                <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg dark:hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">🎪 Events</h3>
                        <span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full text-xs font-medium">
                            5 Upcoming
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Manage event-based ambulance requests') }}
                    </p>
                    <button class="inline-block bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        View Events
                    </button>
                </div>

                <!-- Card 6 -->
                <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg dark:hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📊 Analytics</h3>
                        <span class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 px-3 py-1 rounded-full text-xs font-medium">
                            Reports
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('View system statistics and reports') }}
                    </p>
                    <button class="inline-block bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        View Analytics
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
