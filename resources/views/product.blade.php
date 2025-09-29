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

                <!-- Products table -->
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Category</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Stocks</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Product Code</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Product Name</th>
                            <th class="border px-4 py-2 text-left text-gray-700 dark:text-gray-200">Product Description</th>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-2 text-center text-gray-600 dark:text-gray-300">
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
