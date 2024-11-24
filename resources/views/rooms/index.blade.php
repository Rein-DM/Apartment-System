<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Available Rooms') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-full mx-auto sm:px-4 lg:px-6">
            <div class="py-4">
                @if(session('success'))
                    <div id="successMessage" class="bg-green-500 text-white p-2 rounded mb-4">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div id="errorMessage" class="bg-red-500 text-white p-2 rounded mb-4">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div id="errorMessage" class="bg-red-500 text-white p-2 rounded mb-4">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="mr-4">
                <form method="GET" action="{{ route('rooms.index') }}" class="relative justify-between flex items-center space-x-2 py-2">
                    <!-- Search Input -->
                    <div class="relative flex items-center w-full max-w-md">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-search text-gray-500"></i>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="block w-70 pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm transition duration-150 ease-in-out hover:border-blue-400"
                            placeholder="SEARCH" oninput="toggleResetButton()" />

                        <!-- Reset Button Inside Input -->
                        <a href="{{ route('rooms.index') }}" id="reset-button" class="absolute inset-y-0 right-52 flex items-center pr-3 text-gray-500 hover:text-blue-500 hidden">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>

                    <button type="button" class="btn btn-primary whitespace-nowrap" data-toggle="modal" data-target="#addRoomModal">
                        <i class="bi bi-house-add"></i> Add New Room
                    </button>
                </form>
            </div>
            <div class="overflow-hidden shadow-md sm:rounded-lg">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600 w-42 text-center">Room Number</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Type</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Price</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Capacity</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Description</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Availability</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-4 text-sm text-gray-700 text-center">{{ $room->room_number }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700 uppercase">{{ $room->type }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700 uppercase">Php: {{ number_format($room->price, 2) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->capacity }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700 uppercase">{{ $room->description }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700 uppercase">{{ $room->available ? 'Available' : 'Not Available' }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">
                                    <div class="flex space-x-2">
                                        @if($room->status === 1)
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editRoomModal{{ $room->id }}" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Delete">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form id="restoreForm{{ $room->id }}" action="{{ route('rooms.restore', $room->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white hover:bg-green-500" onclick="confirmRestore('{{ $room->id }}')" title="Restore">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Room Modal -->
                            <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel{{ $room->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editRoomModalLabel{{ $room->id }}">Edit Room</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body overflow-auto max-h-96 overflow-y-auto">
                                                <div class="form-group mb-4">
                                                    <label for="room_number">Room Number</label>
                                                    <select class="form-control" name="room_number" required>
                                                        <option value="">Select a room</option>
                                                        @foreach(range(1, 13) as $number)
                                                            <option value="{{ $number }}" {{ old('room_number', $room->room_number) == $number ? 'selected' : '' }}>Room {{ $number }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('room_number')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="type">Room Type</label>
                                                    <select class="form-control" name="type" required>
                                                        <option value="">Select a room type</option>
                                                        <option value="apartment-a" {{ old('type', $room->type) == 'apartment-a' ? 'selected' : '' }}>Apartment-A</option>
                                                        <option value="apartment-b" {{ old('type', $room->type) == 'apartment-b' ? 'selected' : '' }}>Apartment-B</option>
                                                        <option value="apartment-c" {{ old('type', $room->type) == 'apartment-c' ? 'selected' : '' }}>Apartment-C</option>
                                                        <option value="apartment-d" {{ old('type', $room->type) == 'apartment-d' ? 'selected' : '' }}>Apartment-D</option>
                                                    </select>
                                                    @error('type')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="price">Price</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₱</span>
                                                        <input type="text" class="form-control" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" value="{{ old('price', $room->price) }}" required>
                                                    </div>
                                                    @error('price')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="capacity">Capacity</label>
                                                    <input type="number" class="form-control" name="capacity" min="1" value="{{ old('capacity', $room->capacity) }}" required>
                                                    @error('capacity')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description">{{ old('description', $room->description) }}</textarea>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="available">Available</label>
                                                    <select class="form-control" name="available">
                                                        <option value="1" {{ old('available', $room->available) == '1' ? 'selected' : '' }}>Yes</option>
                                                        <option value="0" {{ old('available', $room->available) == '0' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>

                                                <!-- Apartment Image -->
                                                <div class="form-group mb-4">
                                                    <label for="apartment_image">Apartment Image</label>
                                                    @if ($room->apartment_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->apartment_image) }}" alt="Apartment Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="apartment_image" accept="image/*" onchange="previewImage(event, 'apartmentPreview{{ $room->id }}')">
                                                    <img id="apartmentPreview{{ $room->id }}" alt="Apartment Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>

                                                <!-- Bathroom Image -->
                                                <div class="form-group mb-4">
                                                    <label for="bathroom_image">Bathroom Image</label>
                                                    @if ($room->bathroom_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->bathroom_image) }}" alt="Bathroom Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="bathroom_image" accept="image/*" onchange="previewImage(event, 'bathroomPreview{{ $room->id }}')">
                                                    <img id="bathroomPreview{{ $room->id }}" alt="Bathroom Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>

                                                <!-- Outside Image -->
                                                <div class="form-group mb-4">
                                                    <label for="outside_image">Outside Image</label>
                                                    @if ($room->outside_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->outside_image) }}" alt="Outside Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="outside_image" accept="image/*" onchange="previewImage(event, 'outsidePreview{{ $room->id }}')">
                                                    <img id="outsidePreview{{ $room->id }}" alt="Outside Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>

                                                <!-- Additional Images as Needed -->

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 px-4">
            <div class="flex items-center mb-2 md:mb-0">
                <form method="GET" action="{{ route('rooms.index') }}" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm mt-2">Show</label>
                    <select name="per_page" id="per_page" class="border border-gray-300 rounded px-4 py-1 text-sm" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-sm ml-2">of <strong>{{ $rooms->total() }}</strong> entries</span>
            </div>

            <div class="md:mt-0">
                <x-room-pagination :rooms="$rooms" />
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body overflow-auto max-h-96 overflow-y-auto">
                        <div class="form-group mb-4">
                            <label for="room_number">Room Number</label>
                            <select class="form-control" name="room_number" required>
                                <option value="">Select a room</option>
                                    <option value="1">Room 1</option>
                                    <option value="2">Room 2</option>
                                    <option value="3">Room 3</option>
                                    <option value="4">Room 4</option>
                                    <option value="5">Room 5</option>
                                    <option value="6">Room 6</option>
                                    <option value="7">Room 7</option>
                                    <option value="8">Room 8</option>
                                    <option value="9">Room 9</option>
                                    <option value="10">Room 10</option>
                                    <option value="11">Room 11</option>
                                    <option value="12">Room 12</option>
                                    <option value="13">Room 13</option>
                            </select>
                            @error('room_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="type">Room Type</label>
                            <select class="form-control" name="type" required>
                                <option value="">Select a room</option>
                                    <option value="apartment-a">Apartment-A</option>
                                    <option value="apartment-b">Apartment-B</option>
                                    <option value="apartment-c">Apartment-C</option>
                                    <option value="apartment-d">Apartment-D</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" value="{{ old('price') }}" required>
                            </div>
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="capacity">Capacity</label>
                            <input type="text" class="form-control" name="capacity" min="1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').slice(0, 10)" value="{{ old('capacity') }}" required>
                            @error('capacity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="available">Available</label>
                            <select class="form-control" name="available">
                                <option value="">Select Available</option>
                                <option value="1" {{ old('available') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <!-- Room Images -->
                        <div class="form-group mb-4">
                            <label for="apartment_image">Apartment Image</label>
                            <input type="file" class="form-control" name="apartment_image" accept="image/*" onchange="previewImage(event, 'apartmentPreviewAdd')">
                            <img id="apartmentPreviewAdd" alt="Apartment Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="bathroom_image">Bathroom Image</label>
                            <input type="file" class="form-control" name="bathroom_image" accept="image/*" onchange="previewImage(event, 'bathroomPreviewAdd')">
                            <img id="bathroomPreviewAdd" alt="Bathroom Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="outside_image">Outside Image</label>
                            <input type="file" class="form-control" name="outside_image" accept="image/*" onchange="previewImage(event, 'outsidePreviewAdd')">
                            <img id="outsidePreviewAdd" alt="Outside Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmRestore(roomId) {
            if (confirm("Are you sure you want to restore this room?")) {
                fetch('/rooms/restore/' + roomId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({}),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Room restored successfully!");
                        // Optionally, update the UI or remove the restore button.
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert("Failed to restore room.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while restoring the room.");
                });
            }
        }

        function toggleResetButton() {
            const searchInput = document.getElementById('search');
            const resetButton = document.getElementById('reset-button');

            if (searchInput.value) {
                resetButton.classList.remove('hidden'); // Show the reset button
            } else {
                resetButton.classList.add('hidden'); // Hide the reset button
            }
        }
        // Preview image function
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
        window.onload = function() {
            const fadeOut = (element) => {
                if (!element) return;
                setTimeout(() => {
                    element.style.transition = "opacity 0.5s ease";
                    element.style.opacity = 0;
                    setTimeout(() => {
                        element.style.display = 'none';
                    }, 500); // Matches the CSS transition duration
                }, 3000); // 3 seconds delay before fading
            };

            fadeOut(document.getElementById('successMessage'));
            fadeOut(document.getElementById('errorMessage'));
        };
    </script>
</x-app-layout>
