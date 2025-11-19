<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoice Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Title and button -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-gray-900 dark:text-gray-100 text-xl">{{ __("Invoices") }}</h2>
                    <p><strong>Branch: {{ $currentUserData->branch_name }}</strong></p>
                    <a href="{{ route('invoice_detail') }}" 
                        class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"  
                             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
 