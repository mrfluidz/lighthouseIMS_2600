<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoice Management') }}
        </h2>
    </x-slot>
    <div class="mt-4"></div>
    <div class="note-text-info max-w-7xl mx-auto p-6 bg-white shadow rounded">
        
        <span class="info-icon mr-1" aria-hidden="true">ℹ️</span>To create an invoice, please complete the 3 steps below. Make sure to save it as a draft before navigating away or switching pages.
        <div class="ml-6">
            Once all steps are finalized, you may submit and generate your invoice.
        </div> 
        
    </div>
    <div class="mt-4"></div>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow rounded">
        <div>
             <p><strong>Branch: {{ $currentUserData->branch_name }}</strong></p>
        </div>
        <!-- Step Indicators -->
        <div class="flex justify-between mb-8">
            <div class="step-indicator active" data-step="1">1. Invoice Details</div>
            <div class="step-indicator" data-step="2">2. Add Invoice Items</div>
            <div class="step-indicator" data-step="3">3. Compute & Submit</div>
        </div>

        <!-- Step 1 -->
        <div class="step-content" data-step="1">
            <h2 class="text-xl font-semibold mb-4">Invoice Details</h2>
            <input type="text" id="invoice-number" placeholder="Invoice Number" class="w-full border rounded p-2 mb-4" />
            <input type="date" id="invoice-date" class="w-full border rounded p-2 mb-4" />
            <input type="text" id="customer-name" placeholder="Customer Name" class="w-full border rounded p-2 mb-4" />
        </div>

        <!-- Step 2 -->
        <div class="step-content hidden" data-step="2">
            <h2 class="text-xl font-semibold mb-4">Add Invoice Items</h2>
            <input type="search" id="product-search" placeholder="Search product..." class="w-full border rounded p-2 mb-2" autocomplete="off" />
            <ul id="suggestions" class="border rounded max-h-40 overflow-auto hidden bg-white z-10 absolute"></ul>

            <div id="added-items" class="mt-4 space-y-2 border rounded p-4 min-h-[120px]">
                <p class="text-gray-500">No items added yet.</p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step-content hidden" data-step="3">
            <h2 class="text-xl font-semibold mb-4">Review & Submit</h2>
            <div id="summary"></div>
        </div>

        <!-- Navigation -->
        <div class="mt-6 flex justify-between items-center">
            <button id="btn-back" class="bg-gray-300 text-gray-700 px-4 py-2 rounded" disabled>Back</button>
            <button id="btn-save" class="bg-amber-500 text-white px-4 py-2 rounded">Save as Draft</button>
            <button id="btn-next" class="bg-blue-600 text-white px-4 py-2 rounded">Next</button>
            <button id="btn-submit" class="bg-green-600 text-white px-4 py-2 rounded hidden" disabled>Submit</button>
        </div>
    </div>

    <script>
        (() => {
            let currentStep = 1;
            let draftSaved = false;
            const maxStep = 3;

            const steps = document.querySelectorAll('.step-content');
            const indicators = document.querySelectorAll('.step-indicator');
            const btnBack = document.getElementById('btn-back');
            const btnNext = document.getElementById('btn-next');
            const btnSave = document.getElementById('btn-save');
            const btnSubmit = document.getElementById('btn-submit');

            const productSearch = document.getElementById('product-search');
            const suggestions = document.getElementById('suggestions');
            const addedItems = document.getElementById('added-items');
            const summary = document.getElementById('summary');

            // Dummy product list
            const products = [
                { id: 1, name: 'Product A', price: 10.00 },
                { id: 2, name: 'Product B', price: 20.00 },
                { id: 3, name: 'Service C', price: 15.50 }
            ];

            let invoiceItems = [];

            // Show current step UI
            function showStep(step) {
                steps.forEach(s => s.classList.toggle('hidden', parseInt(s.dataset.step) !== step));
                indicators.forEach(i => i.classList.toggle('active', parseInt(i.dataset.step) === step));
                btnBack.disabled = step === 1;
                btnNext.classList.toggle('hidden', step === maxStep);
                btnSubmit.classList.toggle('hidden', step !== maxStep);
                btnSubmit.disabled = !draftSaved;
            }

            // Render invoice items list with quantity inputs
            function renderAddedItems() {
                if (invoiceItems.length === 0) {
                    addedItems.innerHTML = '<p class="text-gray-500">No items added yet.</p>';
                    return;
                }
                addedItems.innerHTML = invoiceItems.map(item => `
                    <div class="flex items-center justify-between border rounded p-2 mb-1 space-x-4">
                        <div class="flex-1">${item.name}</div>
                        <input type="number" min="1" value="${item.quantity}" data-id="${item.id}" class="quantity-input w-16 border rounded px-2 py-1" />
                        <div>$${item.price.toFixed(2)}</div>
                        <div>$${(item.price * item.quantity).toFixed(2)}</div>
                        <button class="text-red-600 font-bold" data-id="${item.id}">Remove</button>
                    </div>
                `).join('');

                // Quantity input change event
                addedItems.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('change', (e) => {
                        const id = parseInt(e.target.dataset.id);
                        let newQty = parseInt(e.target.value);
                        if (isNaN(newQty) || newQty < 1) newQty = 1;
                        e.target.value = newQty; // reset valid value
                        const item = invoiceItems.find(i => i.id === id);
                        if (item) {
                            item.quantity = newQty;
                            updateSummary();
                            renderAddedItems(); // re-render to update totals and inputs
                        }
                    });
                });

                // Remove item button
                addedItems.querySelectorAll('button').forEach(btn => {
                    btn.addEventListener('click', e => {
                        const id = parseInt(e.target.dataset.id);
                        invoiceItems = invoiceItems.filter(i => i.id !== id);
                        updateSummary();
                        renderAddedItems();
                    });
                });

                updateSummary();
            }

            // Update invoice summary on Step 3
            function updateSummary() {
                if (invoiceItems.length === 0) {
                    summary.innerHTML = '<p>No items added.</p>';
                    return;
                }
                let html = '<table class="w-full border-collapse border border-gray-300">';
                html += `<thead>
                    <tr>
                        <th class="border border-gray-300 px-2">Description</th>
                        <th class="border border-gray-300 px-2 text-right">Qty</th>
                        <th class="border border-gray-300 px-2 text-right">Price</th>
                        <th class="border border-gray-300 px-2 text-right">Total</th>
                    </tr>
                </thead><tbody>`;

                let subtotal = 0;
                invoiceItems.forEach(item => {
                    const total = item.quantity * item.price;
                    subtotal += total;
                    html += `<tr>
                        <td class="border border-gray-300 px-2">${item.name}</td>
                        <td class="border border-gray-300 px-2 text-right">${item.quantity}</td>
                        <td class="border border-gray-300 px-2 text-right">$${item.price.toFixed(2)}</td>
                        <td class="border border-gray-300 px-2 text-right">$${total.toFixed(2)}</td>
                    </tr>`;
                });
                const tax = subtotal * 0.1;
                const total = subtotal + tax;

                html += `</tbody></table>`;
                html += `<div class="mt-4 text-right">
                    <p>Subtotal: $${subtotal.toFixed(2)}</p>
                    <p>Tax (10%): $${tax.toFixed(2)}</p>
                    <p><strong>Total: $${total.toFixed(2)}</strong></p>
                </div>`;

                summary.innerHTML = html;
            }

            // Search input logic: show matching products in suggestions list
            productSearch.addEventListener('input', () => {
                const query = productSearch.value.trim().toLowerCase();
                if (query.length < 2) {
                    suggestions.classList.add('hidden');
                    return;
                }
                const matches = products.filter(p => p.name.toLowerCase().includes(query));
                if (matches.length === 0) {
                    suggestions.innerHTML = '<li class="px-2 py-1 italic text-gray-500 cursor-default">Product not found</li>';
                } else {
                    suggestions.innerHTML = matches.map(p => `
                        <li class="px-2 py-1 cursor-pointer hover:bg-gray-200" data-id="${p.id}">
                            ${p.name} - $${p.price.toFixed(2)}
                        </li>`).join('');
                }
                suggestions.classList.remove('hidden');
            });

            // Clicking a product suggestion adds it to invoice items or increases quantity if already added
            suggestions.addEventListener('click', e => {
                if (e.target.tagName === 'LI' && e.target.dataset.id) {
                    const id = parseInt(e.target.dataset.id);
                    const product = products.find(p => p.id === id);
                    if (!product) return;

                    const existing = invoiceItems.find(i => i.id === product.id);
                    if (existing) {
                        existing.quantity++;
                    } else {
                        invoiceItems.push({ ...product, quantity: 1 });
                    }
                    renderAddedItems();

                    // Clear search input and hide suggestions so user can add another product easily
                    productSearch.value = '';
                    suggestions.classList.add('hidden');

                    // Focus quantity input of newly added item for quick edit
                    setTimeout(() => {
                        const input = addedItems.querySelector(`.quantity-input[data-id="${product.id}"]`);
                        if (input) input.focus();
                    }, 100);
                }
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', (e) => {
                if (!productSearch.contains(e.target) && !suggestions.contains(e.target)) {
                    suggestions.classList.add('hidden');
                }
            });

            // Navigation buttons
            btnBack.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            btnNext.addEventListener('click', () => {
                // Enforce saving draft on step 2 before next
                if (currentStep === 2 && !draftSaved) {
                    alert('Please save draft before proceeding!');
                    return;
                }
                if (currentStep < maxStep) {
                    currentStep++;
                    if (currentStep === 3) updateSummary();
                    showStep(currentStep);
                }
            });

            btnSave.addEventListener('click', () => {
                // Here you would typically save draft to backend via AJAX or form submission
                draftSaved = true;
                alert('Draft saved!');
                btnSubmit.disabled = false;
            });

            btnSubmit.addEventListener('click', () => {
                if (!draftSaved) {
                    alert('Please save draft before submitting!');
                    return;
                }
                alert('Invoice submitted!');
                // Submit the invoice - send data to your backend here (e.g. AJAX or form)
            });

            // Initialize UI
            showStep(currentStep);
            renderAddedItems();
        })();
    </script>

   
</x-app-layout>
