<!-- resources/views/layouts/navigation.blade.php -->

<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('notes.index') }}">
                        <!-- <x-application-logo class="block h-9 w-5 fill-current text-gray-800 dark:text-gray-200" /> -->
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('notes.index')" :active="request()->routeIs('notes.*')">
                        {{ __('Notes') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings / Auth removed for now -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- You can add user dropdown later if you add authentication -->
            </div>
        </div>
    </div>
</nav>
