@php
    $months = [
        'January','February','March','April','May','June',
        'July','August','September','October','November','December'
    ];
    $currentMonth = date('F'); // Current month
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Out of Stock Products Panel -->
                <div class="panel panel-red">
                    <div class="panel-header">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Out of Stock Products
                        </h3>
                        <span class="panel-label label-red">Top 10</span>
                    </div>

                    <!-- Full-width Dropdown with margin -->
                    <select class="w-full mb-4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @foreach($months as $month)
                            <option value="{{ $month }}" @if($month == $currentMonth) selected @endif>{{ $month }}</option>
                        @endforeach
                    </select>

                    @php
                        $outOfStockItems = collect([
                            ['name'=>'Wireless Mouse'],
                            ['name'=>'Keyboard'],
                            ['name'=>'USB-C Cable'],
                            ['name'=>'Laptop Stand'],
                            ['name'=>'Webcam'],
                            ['name'=>'Headphones'],
                            ['name'=>'Microphone'],
                        ])->forPage(request('page',1), 3); 
                        $totalPages = ceil(7/3); 
                        $currentPage = request('page',1);
                    @endphp

                    <ul>
                        @foreach($outOfStockItems as $item)
                        <li>
                            <span>{{ $item['name'] }}</span>
                            <span class="value">Out</span>
                        </li>
                        @endforeach
                    </ul>

                    <div class="pagination mt-4 flex justify-center">
                        @for($i=1; $i<=$totalPages; $i++)
                            <a href="?page={{ $i }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
                        @endfor
                    </div>

                    <div class="view-more">
                        <a href="report">View More Reports</a>
                    </div>
                </div>

                <!-- Most Sold Products Panel -->
                <div class="panel panel-green">
                    <div class="panel-header">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4"/>
                            </svg>
                            Most Sold Products
                        </h3>
                        <span class="panel-label label-green">Top 10</span>
                    </div>

                    <!-- Full-width Dropdown with margin -->
                    <select class="w-full mb-4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @foreach($months as $month)
                            <option value="{{ $month }}" @if($month == $currentMonth) selected @endif>{{ $month }}</option>
                        @endforeach
                    </select>

                    <ul>
                        @for($i=1; $i<=10; $i++)
                        <li>
                            <span>Product {{ $i }}</span>
                            <span class="value">{{ rand(50,200) }} sold</span>
                        </li>
                        @endfor
                    </ul>

                    <div class="view-more">
                        <a href="report">View More Reports</a>
                    </div>
                </div>

                <!-- Most Restocked Products Panel -->
                <div class="panel panel-blue">
                    <div class="panel-header">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Most Restocked Products
                        </h3>
                        <span class="panel-label label-blue">Top 10</span>
                    </div>

                    <!-- Full-width Dropdown with margin -->
                    <select class="w-full mb-4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @foreach($months as $month)
                            <option value="{{ $month }}" @if($month == $currentMonth) selected @endif>{{ $month }}</option>
                        @endforeach
                    </select>

                    <ul>
                        @for($i=1; $i<=10; $i++)
                        <li>
                            <span>Product {{ $i }}</span>
                            <span class="value">{{ rand(20,100) }} restocked</span>
                        </li>
                        @endfor
                    </ul>

                    <div class="view-more">
                        <a href="report">View More Reports</a>
                    </div>
                </div>

                <!-- Low Sales Products Panel -->
                <div class="panel panel-yellow">
                    <div class="panel-header">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z"/>
                            </svg>
                            Low Sales Products
                        </h3>
                        <span class="panel-label label-yellow">Top 10</span>
                    </div>

                    <!-- Full-width Dropdown with margin -->
                    <select class="w-full mb-4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @foreach($months as $month)
                            <option value="{{ $month }}" @if($month == $currentMonth) selected @endif>{{ $month }}</option>
                        @endforeach
                    </select>

                    <ul>
                        @for($i=1; $i<=10; $i++)
                        <li>
                            <span>Product {{ $i }}</span>
                            <span class="value">{{ rand(1,20) }} sold</span>
                        </li>
                        @endfor
                    </ul>

                    <div class="view-more">
                        <a href="report">View More Reports</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
