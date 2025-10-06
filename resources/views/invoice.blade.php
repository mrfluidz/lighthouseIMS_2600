<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Invoice Management
        </h2>
    </x-slot>

    <div x-data="{ step: 1 }" class="max-w-2xl p-6 mx-auto mt-10 bg-white rounded shadow">
        <!-- Step Indicators -->
        <div class="flex items-center justify-between mb-8">
            <template x-for="s in 3" :key="s">
                <div class="flex-1">
                    <div :class="{
                        'bg-blue-600 text-white': step === s,
                        'bg-gray-200 text-gray-600': step !== s
                    }" class="flex items-center justify-center w-10 h-10 mx-auto text-lg font-bold rounded-full">
                        <span x-text="s"></span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Step 1 -->
        <div x-show="step === 1">
            <h3 class="mb-4 text-lg font-semibold">Step 1: Invoice Details</h3>
            <input type="text" placeholder="Full Name" class="w-full mb-4 form-input" />
            <input type="email" placeholder="Email" class="w-full mb-4 form-input" />
        </div>

        <!-- Step 2 -->
        <div x-show="step === 2">
            <h3 class="mb-4 text-lg font-semibold">Step 2: Address</h3>
            <input type="text" placeholder="Address Line 1" class="w-full mb-4 form-input" />
            <input type="text" placeholder="City" class="w-full mb-4 form-input" />
        </div>

        <!-- Step 3 -->
        <div x-show="step === 3">
            <h3 class="mb-4 text-lg font-semibold">Step 3: Confirmation</h3>
            <p>Please review your information and click submit.</p>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            <button
                type="button"
                class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600"
                @click="step = Math.max(step - 1, 1)"
                x-show="step > 1"
            >
                Back
            </button>

            <button
                type="button"
                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                @click="step < 3 ? step++ : alert('Submitted!')"
            >
                <span x-show="step < 3">Next</span>
                <span x-show="step === 3">Submit</span>
            </button>
        </div>
    </div>
</x-app-layout>
