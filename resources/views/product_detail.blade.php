<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Panel box with 3 columns -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Flex container for title and button -->
                <div class="flex justify-between items-center mb-6">
                    <!-- Title -->
                    <h2 class="text-gray-900 dark:text-gray-100 text-xl">{{ __("Add New Product") }}</h2>
                    <p><strong>Branch: {{ $currentUserData->branch_name }}</p></strong>
                    <!-- Button -->
                    <a href="{{ route('product') }}" 
                        class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                            Back
                    </a>
                   
                </div>
                <div class="myline"></div>
                <div class="mt-4"></div>
                <form method="POST" action="{{ route('product.store') }}">
                @csrf
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full sm:w-1/3 px-2 mb-4 sm:mb-0">
                            <x-input-label for="category" :value="__('Category')" required />
                                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm ">
                                    <option value="">-- Select Category --</option>
                                        @foreach($categories as $id => $category)
                                        <option value="{{ $id }}">{{ $category }}</option>
                                        @endforeach
                                </select>
                        </div>
                        <div class="w-full sm:w-1/3 px-2 mb-4 sm:mb-0">
                            <div>
                                <x-input-label for="product_code" :value="__('Product Code')" />
                                <x-text-input id="product_code" class="block mt-1 w-full" type="text" name="product_code" :value="old('product_code')" required autofocus autocomplete="product_code" />
                                <x-input-error :messages="$errors->get('product_code')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full sm:w-1/3 px-2">
                            <div>
                                <x-input-label for="name" :value="__('Product Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4"></div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                            <x-input-label for="product_image" :value="__('Product Image')" />
                            <input 
                                type="file" 
                                id="product_image" 
                                name="product_image" 
                                accept="image/*" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            />
                            <x-input-error :messages="$errors->get('product_image')" class="mt-2" />
                        </div>
                        @php
                        $branchCode = $currentUserData->branch_code ?? 'XX'; // Fallback to 'XX' if not available
                        @endphp
                        <div class="w-full sm:w-1/2 px-2">
                            <div>
                                <x-input-label for="details" :value="__('Details')" />
                                <textarea 
                                    id="details" 
                                    name="details" 
                                    required 
                                    autofocus 
                                    autocomplete="details"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm resize-y"
                                    placeholder="eg. 10W, Warm-light, 3mm"
                                >{{ old('details') }}</textarea>
                                <x-input-error :messages="$errors->get('details')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4"></div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full sm:w-1/3 px-2 mb-4 sm:mb-0">
                            <div>
                                <x-input-label for="supplier" :value="__('Supplier')" />
                                <x-text-input id="supplier" class="block mt-1 w-full" type="text" name="supplier" :value="old('supplier')" required autofocus autocomplete="supplier" />
                                <x-input-error :messages="$errors->get('supplier')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full sm:w-1/3 px-2 mb-4 sm:mb-0">
                            <div>
                                <x-input-label for="brand" :value="__('Brand')" />
                                <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand')" required autofocus autocomplete="brand" />
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full sm:w-1/3 px-2">
                            <div>
                                <x-input-label for="stocks" :value="__('Stocks')" /><x-text-input id="stocks" class="block mt-1 w-full" type="number" name="stocks" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" :value="old('stocks')" required autofocus autocomplete="stocks" /><x-input-error :messages="$errors->get('stocks')" class="mt-2" />

                            </div>
                        </div>
                        
                    </div>
                    <div class="mt-4"></div>
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full sm:w-1/3 px-2 mb-4 sm:mb-0">
                            <div>
                                <x-input-label for="priceCode" :value="__('Price Code')" />
                                <x-text-input id="priceCode" class="block mt-1 w-full" type="text" name="priceCode" :value="old('priceCode')" required autofocus autocomplete="priceCode" />
                                <x-input-error :messages="$errors->get('priceCode')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full sm:w-1/3 px-2 mb-4 sm:mb-0">
                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('prcie')" required autofocus autocomplete="price" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full sm:w-1/3 px-2">
                            <div class="mt-6"></div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                Create Product
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    // Your prefix code for product code input
    const input = document.getElementById('product_code');
    const input_name = document.getElementById('name');
    const prefix =  @json($branchCode . '-');

    if (!input.value.startsWith(prefix)) {
        input.value = prefix;
    }

    if (!input_name.value.startsWith(prefix)) {
        input_name.value = prefix;
    }

    input.addEventListener('keydown', function(e) {
        if ((input.selectionStart <= prefix.length) && (e.key === 'Backspace' || e.key === 'Delete')) {
            e.preventDefault();
        }
    });

    input.addEventListener('input', function() {
        if (!input.value.startsWith(prefix)) {
            input.value = prefix;
        }
    });

    input_name.addEventListener('input', function() {
        if (!input_name.value.startsWith(prefix)) {
            input_name.value = prefix;
        }
    });
   
</script>
