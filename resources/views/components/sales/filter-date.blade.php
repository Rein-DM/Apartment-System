<div class="flex mx-auto px-4 py-6 whitespace-nowrap">
    <!-- Toggle Button -->
    <button id="toggleDrawer" class="text-gray-500 bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-md focus:outline-none"> 
        <i class="bi bi-filter"></i>
        Sales Report
    </button>
    <!-- Drawer Form for Sales Report Generation -->
    <div id="drawer" class="transition-transform transform {{ session('drawer_open') ? 'translate-x-0' : 'translate-x-full' }} fixed top-0 right-0 h-full w-96 bg-white shadow-lg z-50 overflow-y-auto">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Generate Sales Report</h2>
            <form action="{{ route('sales.report') }}" method="GET" class="grid grid-cols-1 gap-4">
                <div>
                    <label for="start_date" class="block font-semibold mb-1">Start Date:</label>
                    <input type="date" name="start_date" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="end_date" class="block font-semibold mb-1">End Date:</label>
                    <input type="date" name="end_date" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="filter" class="block font-semibold mb-1">Filter:</label>
                    <select name="filter" id="filter" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" >Select date</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full mt-2 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Generate Sales Report
                    </button>
                </div>
            </form>
        </div>
        <!-- Close Drawer Button -->
        <button id="closeDrawer" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 focus:outline-none">
            <i class="bi bi-x-lg text-2xl"></i> <!-- Use an icon or text for closing -->
        </button>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-50 {{ session('drawer_open') ? 'block' : 'hidden' }} z-40"></div>

    <!-- Display the Date Range -->
    @if(request('start_date') && request('end_date'))
    <div class="mb-6">
        <p class="text-lg font-semibold text-gray-600">Sales Report from <span class="font-bold">{{ request('start_date') }}</span> to <span class="font-bold">{{ request('end_date') }}</span></p>
    </div>
    @endif
</div>

@section('scripts')
<script>
    document.getElementById('toggleDrawer').addEventListener('click', function() {
        const drawer = document.getElementById('drawer');
        const overlay = document.getElementById('overlay');
        drawer.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
    });

    document.getElementById('closeDrawer').addEventListener('click', function() {
        const drawer = document.getElementById('drawer');
        const overlay = document.getElementById('overlay');
        drawer.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    });
</script>
@endsection
