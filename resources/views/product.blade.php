<x-app-layout>
    
        <x-slot name="header">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Product Management') }}
            </h2>
        </x-slot>
    

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <!-- Panel box -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Flex container for title and button -->
                <div class="flex justify-between items-center mb-6">
                    <!-- Title -->
                    <h2 class="text-gray-900 dark:text-gray-100 text-xl">{{ __("Products") }}</h2>
                    <p><strong>Branch: {{ $currentUserData->branch_name }}</p></strong>
                    <!-- Button -->
                    <a href="{{ route('product_detail') }}" 
                        class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <!-- Plus Icon -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Product
                    </a>
                   
                </div>
                    
                
                <div class="myline"></div>

                <div class="mt-4"></div>

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
                        <tr>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">Light Bulb</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">50</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">LB-302013</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">Omni slash Bulb</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-100">50w, warm light, round</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
