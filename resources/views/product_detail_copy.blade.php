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
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full sm:w-1/3 px-2 mb-4 sm:mb-0">
                        <x-input-label for="category" :value="__('Category')" />
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Select Category --</option>
                               
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
                        <x-input-label for="category_image" :value="__('Category Image')" />
                        <input 
                            type="file" 
                            id="category_image" 
                            name="category_image" 
                            accept="image/*" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        />
                        <x-input-error :messages="$errors->get('category_image')" class="mt-2" />
                    </div>
                    @php
                    $branchCode = $currentUserData->branch_code ?? 'XX'; // Fallback to 'XX' if not available
                    @endphp
                    <div class="w-full sm:w-1/2 px-2">
                        <div>
                            <x-input-label for="code" :value="__('Details')" />
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
                            <x-input-label for="priceCode" :value="__('Supplier')" />
                            <x-text-input id="priceCode" class="block mt-1 w-full" type="text" name="Price" :value="old('priceCode')" required autofocus autocomplete="priceCode" />
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
                        <div>
                           

                            <button id="generateBtn">Generate QR Code</button>

                            <div id="qr-output"></div>
                            <button id="download-qr">Download QR Code</button>
                        </div>
                    </div>
                </div>
                <!-- Input to show scanned QR code -->
                <div class="mt-4">
                    <label for="scanned_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Scanned QR Code:</label>
                    <input
                        type="text"
                        id="scanned_code"
                        name="scanned_code"
                        readonly
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"
                    />
                </div>

                <!-- QR scanner preview area -->
                <div id="qr-reader" style="width: 300px; margin-top: 20px;"></div>

                <!-- Buttons to start/stop scanning -->
                <div class="mt-2 space-x-2">
                    <button
                        id="start-scan"
                        type="button"
                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none"
                    >
                        Start Scan
                    </button>
                    <button
                        id="stop-scan"
                        type="button"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none"
                        disabled
                    >
                        Stop Scan
                    </button>
                </div>
           <div> </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    // Your prefix code for product code input
    const input = document.getElementById('product_code');
    const prefix =  @json($branchCode . '-');

    if (!input.value.startsWith(prefix)) {
        input.value = prefix;
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

    // QR code generation on button click
    document.getElementById('generateBtn').addEventListener('click', function (e) {
        e.preventDefault();

        const productCode = document.getElementById('product_code').value.trim();
        const qrOutput = document.getElementById('qr-output');

        qrOutput.innerHTML = '';

        if (!productCode) {
            qrOutput.innerHTML = '<p style="color:red;">Please enter a product code.</p>';
            return;
        }

        fetch("{{ route('product_detail.qr') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_code: productCode })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.qr && typeof data.qr === 'string') {
                qrOutput.innerHTML = data.qr;
            } else {
                qrOutput.innerHTML = '<p style="color:red;">Unexpected server response.</p>';
                console.error('Unexpected response:', data);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            qrOutput.innerHTML = `<p style="color:red;">Failed to generate QR code: ${error.message}</p>`;
        });
    });

    // QR Code scanner setup
    

    let html5QrCode;

    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        console.log(`QR Code detected: ${decodedText}`);
        document.getElementById('scanned_code').value = decodedText;

        html5QrCode.stop().then(() => {
            document.getElementById('start-scan').disabled = false;
            document.getElementById('stop-scan').disabled = true;
        }).catch(err => {
            console.error('Failed to stop scanning', err);
        });
    };

    const config = { fps: 10, qrbox: 250 };

    document.getElementById('start-scan').addEventListener('click', () => {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            qrCodeSuccessCallback
        ).then(() => {
            document.getElementById('start-scan').disabled = true;
            document.getElementById('stop-scan').disabled = false;
        }).catch(err => {
            console.error('Unable to start scanning:', err);
            alert('Unable to start scanning. Please allow camera access.');
        });
    });

    document.getElementById('stop-scan').addEventListener('click', () => {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                document.getElementById('start-scan').disabled = false;
                document.getElementById('stop-scan').disabled = true;
            }).catch(err => {
                console.error('Failed to stop scanning', err);
            });
        }
    });

    document.getElementById('download-qr').addEventListener('click', function () {
        const svg = document.querySelector('#qr-output svg');
        if (!svg) {
            alert('No QR code found to download.');
            return;
        }

        // Convert SVG to XML string
        const svgData = new XMLSerializer().serializeToString(svg);

        // Create a canvas and an image element
        const canvas = document.createElement("canvas");
        const img = new Image();
        const svgBlob = new Blob([svgData], { type: "image/svg+xml;charset=utf-8" });
        const url = URL.createObjectURL(svgBlob);

        img.onload = function () {
            const margin = 20; // Margin in pixels

            // Set canvas size with margin
            canvas.width = img.width + margin * 2;
            canvas.height = img.height + margin * 2;

            const ctx = canvas.getContext("2d");

            // Fill background with white (optional)
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw the QR image in the center with margin
            ctx.drawImage(img, margin, margin);

            URL.revokeObjectURL(url);

            // Generate PNG data and trigger download
            const pngUrl = canvas.toDataURL("image/png");
            const downloadLink = document.createElement("a");
            downloadLink.href = pngUrl;
            downloadLink.download = "qr-code.png";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        };

        img.src = url;
    });
</script>
<!--test-->