<x-app-layout>
    <div class="relative overflow-x-auto">
        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start p-2" style="width: 70px">Select</th>
                    <th class="text-start p-2" style="width: 70px">ID</th>
                    <th class="text-start p-2" style="width: 80px">Priority</th>
                    <th class="text-start p-2" style="width: 210px">Requester Name</th>
                    <th class="text-start p-2">Requester Type</th>
                    <th class="text-start p-2">Assigned Team</th>
                    <th class="text-start p-2">Assigned Agent</th>
                    <th class="text-start p-2">Created Date</th>
                    <th class="text-start p-2" style="width: 210px">Request Age</th>
                    <th class="text-start p-2">Source</th>
                    <th class="text-start p-2">Due Date</th>
                    <th class="text-start p-2"></th>
                </tr>
            </thead>

            <tbody class="mt-5">
                @forelse ($tickets as $each)
                    <tr class="rounded shadow">

                        <td class="p-2" style="width: 70px">
                            <x-forms.checkbox-input />
                        </td>
                        <td class="p-2" style="width: 70px">
                            <span class="font-inter font-bold">
                                #{{ $each?->id }}
                            </span>
                        </td>
                        <td class="p-2 font-normal text-gray-400" style="width: 80px">
                            <span class="text-{{ $each?->priority == 'high' ? 'high' : 'medium' }}-400 font-inter font-bold">
                                {{ $each?->priority }}
                            </span>
                        </td>

                        <td class="p-2 font-normal text-gray-400 flex justify-between items-center" style="width: 210px">
                            <img src="https://i.pravatar.cc/300/5" alt="img" width="50" height="50" style="border-radius: 50%">
                            <span class="ml-2">
                                {{ $each?->requester_name }}
                            </span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">
                                {{ $each?->requester_type?->name }}
                            </span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">
                                {{ $each?->team?->name }}
                            </span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">Cody Fisher</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ Helper::humanReadableDate($each?->created_at) }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ Helper::ISODate($each?->due_date) }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">{{ $each?->source?->title }}</span>
                        </td>
                        <td class="p-2">
                            <span class="font-normal text-gray-400">17 Oct, 2024</span>
                        </td>
                        <td>
                            <button>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </td>


                    </tr>

                @empty
                    <tr>
                        <td colspan="14" class="text-center">
                            <span class="text-red">No data found !!</span>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</x-app-layout>
