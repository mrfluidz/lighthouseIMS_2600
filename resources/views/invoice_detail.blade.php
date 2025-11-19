<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Invoice Management</h2>
    </x-slot>

    <div class="mt-4 max-w-7xl mx-auto p-6 bg-white shadow rounded" x-data="invoiceManager()">
        <!-- Invoice Details -->
        <div>
            <label class="block mb-2 font-semibold">Invoice Number</label>
            <input type="text" x-model="invoiceNumber" :readonly="invoiceSaved" class="w-full border rounded p-2 mb-4">

            <label class="block mb-2 font-semibold">Invoice Date</label>
            <input type="date" x-model="invoiceDate" class="w-full border rounded p-2 mb-4">

            <label class="block mb-2 font-semibold">Customer</label>
            <input type="text" x-model="customerName" class="w-full border rounded p-2 mb-4">
        </div>

        <div class="flex justify-end mt-4 mb-6">
            <button @click="saveDraft()" :disabled="invoiceSaved" class="bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-600 disabled:opacity-50">Save as Draft</button>
        </div>

        <!-- Items Section -->
        <template x-if="invoiceSaved">
            <div>
                <button @click="addRow()" class="bg-green-500 text-white px-4 py-2 rounded mb-2">Add Item</button>

                <table class="w-full border mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Product</th>
                            <th class="border p-2">Price</th>
                            <th class="border p-2">Quantity</th>
                            <th class="border p-2">Subtotal</th>
                            <th class="border p-2">Discount</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item,index) in items" :key="index">
                            <tr>
                                <td class="border p-2">
                                    <input list="productList" x-model="item.product_code" @change="selectProduct(index)" class="border p-1 w-full">
                                </td>
                                <td class="border p-2 text-right"><span x-text="item.price.toFixed(2)"></span></td>
                                <td class="border p-2"><input type="number" min="1" x-model.number="item.quantity" @input="updateItem(index)" class="border p-1 w-20"></td>
                                <td class="border p-2 text-right"><span x-text="item.subtotal.toFixed(2)"></span></td>
                                <td class="border p-2 text-center">
                                    <button @click="openDiscountModal(index)" class="bg-blue-500 text-white px-2 py-1 rounded">Add Discount</button>
                                </td>
                                <td class="border p-2 text-center">
                                    <button @click="saveItem(index)" x-show="!item.id" class="bg-indigo-500 text-white px-2 py-1 rounded mr-1">Save</button>
                                    <button @click="removeItem(index,item.id)" class="bg-red-500 text-white px-2 py-1 rounded">Remove</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <p class="text-right font-bold">Total: ₱<span x-text="total.toFixed(2)"></span></p>
            </div>
        </template>

        <datalist id="productList">
            @foreach($products as $product)
                <option value="{{ $product->code }}">{{ $product->product_name }}</option>
            @endforeach
        </datalist>

        <!-- Discount Modal -->
        <div x-show="discountModal.show" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow w-80">
                <h4 class="font-bold mb-2">Add Discount</h4>
                <label>Type:</label>
                <select x-model="discountModal.type" class="border p-1 w-full mb-2">
                    <option value="amount">Amount</option>
                    <option value="percent">Percentage</option>
                </select>
                <label>Value:</label>
                <input type="number" min="0" x-model.number="discountModal.value" class="border p-1 w-full mb-4">
                <div class="flex justify-end">
                    <button @click="applyDiscount()" class="bg-green-500 text-white px-3 py-1 rounded mr-2">Apply</button>
                    <button @click="discountModal.show=false" class="bg-gray-300 px-3 py-1 rounded">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<script>
function invoiceManager(){
    return {
        invoiceNumber: @json($invoice->invoice_num ?? $generatedInvoiceNumber),
        invoiceDate: @json(optional($invoice)->invoice_datetime?->format('Y-m-d') ?? ''),
        customerName: @json($invoice->customer ?? ''),
        invoiceId: @json($invoice->id ?? null),
        invoiceSaved: @json(isset($invoice) && $invoice ? true : false),
        products: @json($products),
        items: @json($invoice->items ?? []),
        discountModal: {show:false,type:'amount',value:0,index:null},

        get total(){ 
            return this.items.reduce((sum,i)=>sum+i.subtotal,0); 
        },

        saveDraft(){
            if(!this.invoiceNumber || !this.invoiceDate || !this.customerName){
                alert("Fill all invoice details");
                return;
            }

            fetch("{{ route('invoice.saveDraft') }}",{
                method:'POST',
                headers: {"Content-Type":"application/json","X-CSRF-TOKEN":"{{ csrf_token() }}"},
                body: JSON.stringify({
                    invoice_num: this.invoiceNumber,
                    invoice_datetime: this.invoiceDate,
                    customer: this.customerName
                })
            })
            .then(res=>res.json())
            .then(data=>{
                if(data.success){
                    alert(data.message);
                    this.invoiceSaved = true;
                    this.invoiceId = data.invoice_id;
                }else alert(data.message);
            })
            .catch(err=>{ console.error(err); alert('Error saving draft'); });
        },

        addRow(){ 
            if(!this.invoiceSaved) return;
            this.items.push({id:null,product_code:'',product_id:null,price:0,quantity:1,subtotal:0,discount_price:0,discount_percent:0});
        },

        selectProduct(index){
            const code = this.items[index].product_code;
            const prod = this.products.find(p=>p.code===code);
            if(prod){
                this.items[index].product_id = prod.id;
                this.items[index].price = parseFloat(prod.price);
                this.updateItem(index);
            }
        },

        updateItem(index){
            this.updateSubtotal(index);
            this.recalculateTotal();
            if(this.items[index].id) this.saveItem(index); // auto-save if already exists
        },

        updateSubtotal(index){
            const i = this.items[index];
            const base = i.price * i.quantity;
            const discount = (i.discount_percent || 0)/100 * base + (i.discount_price || 0);
            i.subtotal = base - discount;
        },

        recalculateTotal(){
            this.items.forEach((i,idx)=>this.updateSubtotal(idx));
        },

        openDiscountModal(index){
            this.discountModal.show=true;
            this.discountModal.index=index;
            this.discountModal.type='amount';
            this.discountModal.value=0;
        },

        applyDiscount(){
            const i = this.items[this.discountModal.index];
            if(this.discountModal.type==='amount') i.discount_price=this.discountModal.value;
            else i.discount_percent=this.discountModal.value;
            this.updateItem(this.discountModal.index);
            this.discountModal.show=false;
        },

        saveItem(index){
            const i = this.items[index];
            if(!i.product_id){ alert("Select a product first"); return; }

            fetch(`/invoice/item/${this.invoiceId}`,{
                method:'POST',
                headers: {"Content-Type":"application/json","X-CSRF-TOKEN":"{{ csrf_token() }}"},
                body: JSON.stringify({
                    product_id: i.product_id,
                    quantity: i.quantity,
                    discount_price: i.discount_price,
                    discount_percent: i.discount_percent
                })
            })
            .then(res=>res.json())
            .then(data=>{
                if(data.success){
                    i.id = data.item.id;
                    this.updateSubtotal(index);
                    this.recalculateTotal();
                }else alert(data.message);
            })
            .catch(err=>{ console.error(err); alert('Error saving item'); });
        },

        removeItem(index,itemId=null){
            if(itemId){
                fetch(`/invoice/item/${itemId}`,{
                    method:'DELETE',
                    headers: {"X-CSRF-TOKEN":"{{ csrf_token() }}"}
                })
                .then(res=>res.json())
                .then(data=>{
                    if(data.success){
                        this.items.splice(index,1);
                        this.recalculateTotal();
                    } else alert(data.message);
                });
            } else {
                this.items.splice(index,1);
                this.recalculateTotal();
            }
        }
    }
}
</script>
</x-app-layout>
