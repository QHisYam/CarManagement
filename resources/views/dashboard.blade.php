<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

  <div class="max-w-6xl mx-auto p-6">
    
    <!-- Flash success message -->
    @if(session('success'))
      <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    <!-- Logout Button -->
    <div class="flex justify-end mb-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>

    <!-- Header with Image -->
    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('favpng_0ec60d3c843ddf12f3335d79ed871fb9.png') }}" 
             alt="Car Logo" 
             class="w-32 h-32 mb-4">
        <h1 class="text-2xl font-bold">Car Dashboard</h1>
    </div>

    <!-- Add Car Form -->
    <div class="mb-8 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800">
      <h2 class="text-lg font-semibold mb-4">Add a New Car</h2>
      <form action="{{ route('cars.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
        @csrf
        <div>
          <label class="block mb-1">Make</label>
          <input type="text" name="make" 
                 class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-900 text-white px-3 py-2">
        </div>
        <div>
          <label class="block mb-1">Model</label>
          <input type="text" name="model" 
                 class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-900 text-white px-3 py-2">
        </div>
        <div>
          <label class="block mb-1">Year</label>
          <input type="number" name="year" 
                 class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-900 text-white px-3 py-2">
        </div>
        <div>
          <label class="block mb-1">Price</label>
          <input type="number" step="0.01" name="price" 
                 class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-900 text-white px-3 py-2">
        </div>
        <div class="md:col-span-2 flex justify-end">
          <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
            Add Car
          </button>
        </div>
      </form>
    </div>

    <!-- Cars Table -->
    <div class="overflow-x-auto rounded-lg border border-neutral-200 dark:border-neutral-700">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-gray-100 dark:bg-neutral-800">
          <tr>
            <th class="px-4 py-2 text-left">Make</th>
            <th class="px-4 py-2 text-left">Model</th>
            <th class="px-4 py-2 text-left">Year</th>
            <th class="px-4 py-2 text-left">Price</th>
            <th class="px-4 py-2 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
          @forelse($cars as $car)
            <tr>
              <td class="px-4 py-2">{{ $car->make }}</td>
              <td class="px-4 py-2">{{ $car->model }}</td>
              <td class="px-4 py-2">{{ $car->year }}</td>
              <td class="px-4 py-2">${{ number_format($car->price, 2) }}</td>
              <td class="px-4 py-2 text-right space-x-2">
                <!-- Inline Edit Form -->
                <form action="{{ route('cars.update', $car->id) }}" method="POST" class="inline-flex gap-2 items-center">
                  @csrf
                  @method('PUT')
                  <input type="text" name="make" value="{{ $car->make }}" 
                         class="w-24 rounded border-neutral-600 bg-neutral-800 text-white px-2 py-1">
                  <input type="text" name="model" value="{{ $car->model }}" 
                         class="w-24 rounded border-neutral-600 bg-neutral-800 text-white px-2 py-1">
                  <input type="number" name="year" value="{{ $car->year }}" 
                         class="w-20 rounded border-neutral-600 bg-neutral-800 text-white px-2 py-1">
                  <input type="number" step="0.01" name="price" value="{{ $car->price }}" 
                         class="w-28 rounded border-neutral-600 bg-neutral-800 text-white px-2 py-1">
                  <button type="submit" class="px-2 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600">
                    Save
                  </button>
                </form>

                <!-- Delete -->
                <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" 
                          class="px-2 py-1 rounded bg-red-600 text-white hover:bg-red-700"
                          onclick="return confirm('Are you sure?')">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                No cars found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      {{ $cars->links() }}
    </div>
  </div>

</body>
</html>
