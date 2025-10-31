<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" 
                        x-init="setTimeout(() => show = false, 2000)" 
                        x-show="show"
                        class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded flex justify-between items-center transition-all duration-500">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="ml-4 font-bold text-green-800">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" 
                        x-init="setTimeout(() => show = false, 3000)" 
                        x-show="show"
                        class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded flex justify-between items-center transition-all duration-500">
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="ml-4 font-bold text-red-800">&times;</button>
                    </div>
                @endif



                <!-- Title and Button -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-gray-900 dark:text-gray-100 text-xl">{{ __("Products") }}</h2>
                    <p><strong>Branch: {{ $currentUserData->branch_name }}</strong></p>
                    <a href="{{ route('product_detail') }}" 
                        class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Add New Product
                    </a>
                </div>

                <!-- Search form -->
                <form method="GET" action="{{ route('product') }}" class="mb-4">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search by code or product name..." 
                        class="border border-gray-300 rounded px-3 py-2 w-full md:w-1/3 dark:bg-gray-700 dark:text-gray-200"
                    >
                </form>

                <div class="myline"></div>
                <div class="mt-4"></div>

                <!-- Products Table -->
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Category</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Stocks</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Product Code</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Product Name</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Product Description</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                    @forelse ($products as $product)
                        <tr>
                            <!-- Category -->
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                {{ $product->category->name ?? 'N/A' }}
                            </td>

                            <!-- Stocks with Update Modal -->
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100 flex justify-between items-center">
                                <span>{{ $product->stocks }}</span>

                                <div x-data="{ stockOpen: false, newStock: {{ $product->stocks }} }">
                                    <button @click="stockOpen = true"
                                        type="button"
                                        class="ml-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-2 py-1 rounded">
                                        Update Stock
                                    </button>

                                    <!-- Modal -->
                                    <div x-show="stockOpen" x-cloak x-transition
                                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div @click.away="stockOpen = false"
                                             class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-md">

                                            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                                                Update Stock for {{ $product->product_name }}
                                            </h2>

                                            <p class="mb-2 text-gray-700 dark:text-gray-200">
                                                Current Stock: <strong>{{ $product->stocks }}</strong>
                                            </p>

                                            <form method="POST" action="{{ route('product.updateStock', $product->id) }}">
                                                @csrf
                                                <label class="block text-gray-700 dark:text-gray-200 mb-2">New Stock:</label>
                                                <input type="number" min="0" name="stocks" x-model.number="newStock"
                                                       class="border border-gray-300 rounded px-3 py-2 w-full dark:bg-gray-700 dark:text-gray-200"
                                                       required>

                                                <div class="flex justify-end mt-4 space-x-2">
                                                    <button type="submit"
                                                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                        Save
                                                    </button>
                                                    <button type="button" @click="stockOpen = false"
                                                            class="px-4 py-2 bg-gray-300 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-400">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Product Code -->
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                {{ $product->code }}
                            </td>

                            <!-- Product Name -->
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                {{ $product->product_name }}
                            </td>

                            <!-- Product Description -->
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                {{ $product->details }}
                            </td>

                            <!-- Actions -->
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                <div x-data="{ open: false }">
                                    <button type="button"
                                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                        Edit
                                    </button>
                                    <button type="button"
                                        class="ml-2 bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded">
                                        Delete
                                    </button>
                                    <button @click="open = true"
                                        type="button"
                                        class="ml-2 bg-gray-500 hover:bg-gray-600 text-white text-xs px-2 py-1 rounded">
                                        Generate QR
                                    </button>

                                    <!-- QR Modal -->
                                    <div x-show="open" x-transition x-cloak
                                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div @click.away="open = false"
                                             class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-md">
                                            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                                                QR for {{ $product->product_name }}
                                            </h2>

                                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                                Code: <strong>{{ $product->code }}</strong>
                                            </p>

                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($product->code) }}"
                                                 alt="QR Code for {{ $product->code }}" class="mx-auto mb-4">

                                            <div class="flex justify-between">
                                                <button @click.prevent="
                                                    const imageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($product->code) }}';
                                                    const img = new Image();
                                                    img.crossOrigin = 'anonymous';
                                                    img.onload = () => {
                                                        const padding = 10;
                                                        const canvas = document.createElement('canvas');
                                                        const size = img.width + padding * 2;
                                                        canvas.width = size;
                                                        canvas.height = size;
                                                        const ctx = canvas.getContext('2d');
                                                        ctx.fillStyle = '#ffffff';
                                                        ctx.fillRect(0,0,size,size);
                                                        ctx.drawImage(img,padding,padding);
                                                        const a = document.createElement('a');
                                                        a.href = canvas.toDataURL('image/png');
                                                        a.download = 'qr-{{ $product->code }}.png';
                                                        a.click();
                                                    };
                                                    img.src = imageUrl;
                                                "
                                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                    Download QR
                                                </button>
                                                <button @click="open = false"
                                                        class="px-4 py-2 bg-gray-300 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-400">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border px-4 py-2 text-center text-gray-600 dark:text-gray-300">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
