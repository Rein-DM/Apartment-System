<main class="p-6 sm:p-10 space-y-6">
    <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 uppercase">
        <div class="flex items-center p-8 bg-purple-100 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-purple-600 bg-purple-200 rounded-full mr-6">
                <i class="bi bi-people-fill text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">{{ \App\Models\ApartmentRoom::count() }}</span>
                <span class="block text-gray-500">Booking</span>
            </div>
        </div>

        <!-- Voters Section -->
        <div class="flex items-center p-8 bg-yellow-100 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-yellow-600 bg-yellow-200 rounded-full mr-6">
                <i class="bi bi-fingerprint text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">6</span>
                <span class="block text-black">Reminders</span>
            </div>
        </div>
    </section>
</main>