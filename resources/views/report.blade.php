<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Report Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Search & Filters --}}
                <form method="GET" action="{{ route('report') }}" class="mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <input type="text" name="searchText" value="{{ $searchText }}" placeholder="Search product code or name..."
                           class="w-full sm:w-1/4 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">

                    <select name="branch_id" class="w-full sm:w-1/5 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">All Branches</option>
                        @foreach($branches as $id => $name)
                            <option value="{{ $id }}" {{ $branchId == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>

                    <select name="activity_type" class="w-full sm:w-1/5 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">All Activities</option>
                        @foreach($activities as $id => $name)
                            <option value="{{ $id }}" {{ $activityType == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>

                    <select name="month" class="w-full sm:w-1/6 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">Select Month</option>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endforeach
                    </select>

                    <select name="year" class="w-full sm:w-1/6 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">Select Year</option>
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="date_from" value="{{ $fromDate }}" placeholder="From" class="w-full sm:w-1/6 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                    <input type="date" name="date_to" value="{{ $toDate }}" placeholder="To" class="w-full sm:w-1/6 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Filter</button>
                        <a href="{{ route('report') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Reset</a>
                    </div>
                </form>

                {{-- Reports Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Code</th>
                                <th class="px-4 py-2">Product Name</th>
                                <th class="px-4 py-2">Branch</th>
                                <th class="px-4 py-2">Activity</th>
                                <th class="px-4 py-2">Activity Log Message</th>
                                <th class="px-4 py-2">Activity By</th>
                                <th class="px-4 py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-300">
                        @forelse($reports as $index => $report)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-4 py-2">{{ $reports->firstItem() + $index }}</td>
                                <td class="px-4 py-2">{{ $report->product->code ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $report->product->product_name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $report->branch->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $report->activity->activity ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $report->activity_log_message }}</td>
                                <td class="px-4 py-2">{{ $report->user->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ optional($report->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No reports found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">{{ $reports->links() }}</div>

            </div>
        </div>
    </div>
</x-app-layout>
