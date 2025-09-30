<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Title and button -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-gray-900 dark:text-gray-100 text-xl">{{ __("Products") }}</h2>
                    <p><strong>Branch: {{ $currentUserData->branch_name }}</strong></p>
                    <a href="{{ route('product_detail') }}" 
                        class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"  
                             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
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
                <!-- Products table -->
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
                                <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $product->category->name ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $product->stocks }}
                                </td>
                                <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $product->code }}
                                </td>
                                <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $product->product_name }}
                                </td>
                                <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                    {{ $product->details }}
                                </td>
                                <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">
                                    <!-- Wrap buttons + modal in x-data for each product -->
                                    <div x-data="{ open: false }">
                                        <!-- Action Buttons -->
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

                                        <!-- Modal -->
                                        <div
                                            x-show="open"
                                            x-transition
                                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                            style="display: none;"
                                        >
                                            <!-- Modal content -->
                                            <div @click.away="open = false"
                                                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-md">
                                                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                                                    QR for {{ $product->product_name }}
                                                </h2>

                                                <p class="mb-4 text-gray-600 dark:text-gray-300">
                                                    Code: <strong>{{ $product->code }}</strong>
                                                </p>

                                                <!-- QR CODE IMAGE (Optional) -->
                                                {{-- Example using QRServer API --}}
                                               <!-- QR Code Image -->
                                                <img 
                                                    id="qr-image-{{ $product->id }}" 
                                                    src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($product->code) }}" 
                                                    alt="QR Code for {{ $product->code }}" 
                                                    class="mx-auto mb-4"
                                                />

                                                <div class="flex justify-between">
                                                    <!-- Download Button -->
                                                   <button 
                                                        @click.prevent="
                                                            const imageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($product->code) }}';

                                                            const img = new Image();
                                                            img.crossOrigin = 'anonymous'; // Important for cross-origin fetch

                                                            img.onload = () => {
                                                                const padding = 10; // pixels
                                                                const canvas = document.createElement('canvas');
                                                                const size = img.width + padding * 2;

                                                                canvas.width = size;
                                                                canvas.height = size;

                                                                const ctx = canvas.getContext('2d');
                                                                ctx.fillStyle = '#ffffff'; // background (white)
                                                                ctx.fillRect(0, 0, size, size);

                                                                ctx.drawImage(img, padding, padding);

                                                                const a = document.createElement('a');
                                                                a.href = canvas.toDataURL('image/png');
                                                                a.download = 'qr-{{ $product->code }}.png';
                                                                a.click();
                                                            };

                                                            img.src = imageUrl;
                                                        "
                                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                                                    >
                                                        Download QR
                                                    </button>


                                                    <!-- Close Button -->
                                                    <button 
                                                        @click="open = false"
                                                        class="px-4 py-2 bg-gray-300 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-400"
                                                    >
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
