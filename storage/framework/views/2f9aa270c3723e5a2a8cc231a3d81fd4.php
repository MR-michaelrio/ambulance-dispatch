<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm dark:shadow-xl transition-colors" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2">
                        <img src="<?php echo e(asset('logo.png')); ?>" alt="GMCI Logo" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex items-center">
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.ambulances.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">Ambulance</a>
                        <a href="<?php echo e(route('admin.ambulance-types.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">Tipe Armada</a>
                        <a href="<?php echo e(route('admin.drivers.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">Driver</a>
                        <a href="<?php echo e(route('admin.dispatches.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">Dispatch</a>
                        <a href="<?php echo e(route('admin.schedules.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">📅 Jadwal</a>
                        <a href="<?php echo e(route('admin.event-requests.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">🎪 Event</a>
                        <a href="<?php echo e(route('admin.patient-requests.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">📋 Permintaan</a>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">👥 User</a>
                        <a href="<?php echo e(route('admin.maps')); ?>" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">🗺️ Maps</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- User Auth, Dark Mode Toggle & Burger -->
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle Button -->
                <button 
                    id="dark-mode-toggle"
                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-300 transform hover:scale-110"
                    title="Toggle Dark Mode">
                    <span id="dark-mode-icon" class="block text-xl">🌙</span>
                    <span id="light-mode-icon" class="hidden text-xl">☀️</span>
                </button>

                <div class="hidden lg:block">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors">Logout</button>
                    </form>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center lg:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-400 transition-colors duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 transition-colors">
        <div class="pt-2 pb-3 space-y-1">
            <?php if(auth()->user()->role === 'admin'): ?>
                <a href="<?php echo e(route('admin.ambulances.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">Ambulance</a>
                <a href="<?php echo e(route('admin.ambulance-types.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">Tipe Armada</a>
                <a href="<?php echo e(route('admin.drivers.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">Driver</a>
                <a href="<?php echo e(route('admin.dispatches.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">Dispatch</a>
                <a href="<?php echo e(route('admin.schedules.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">📅 Jadwal</a>
                <a href="<?php echo e(route('admin.event-requests.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">🎪 Event</a>
                <a href="<?php echo e(route('admin.patient-requests.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">📋 Permintaan</a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">👥 User</a>
                <a href="<?php echo e(route('admin.maps')); ?>" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-500 transition-colors">🗺️ Maps</a>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="pt-2 border-t border-gray-200 dark:border-gray-700">
                <?php echo csrf_field(); ?>
                <button class="w-full text-left pl-3 pr-4 py-2 text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">Logout</button>
            </form>
        </div>
    </div>
</nav>
<?php /**PATH /Applications/Dev/ambulance-dispatch/resources/views/layouts/navigation.blade.php ENDPATH**/ ?>