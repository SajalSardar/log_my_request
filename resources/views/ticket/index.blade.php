<x-app-layout>
    <div class="relative overflow-x-auto">
        <table class="w-full overflow-x-auto">
            <thead class="w-full bg-slate-100 mb-5">
                <tr>
                    <th class="text-start p-2" style="width: 70px">Select</th>
                    <th class="text-start p-2" style="width: 70px">ID</th>
                    <th class="text-start p-2" style="width: 80px">Priority</th>
                    <th class="text-start p-2" style="width: 180px">Status</th>
                    <th class="text-start p-2" style="width: 210px">Requester Name</th>
                    <th class="text-start p-2">Requester Type</th>
                    <th class="text-start p-2">Assigned Team</th>
                    <th class="text-start p-2">Assigned Agent</th>
                    <th class="text-start p-2">Created Date</th>
                    <th class="text-start p-2" style="width: 210px">Request Age</th>
                    <th class="text-start p-2">Source</th>
                    <th class="text-start p-2">Due Date</th>
                </tr>
            </thead>

            <tbody class="mt-5">
                <tr class="rounded shadow">
                    <td class="p-2" style="width: 70px">
                        <x-forms.checkbox-input />
                    </td>
                    <td class="p-2" style="width: 70px">
                        <span class="font-inter font-bold">
                            #006
                        </span>
                    </td>
                    <td class="p-2 font-normal text-gray-400" style="width: 80px">
                        <span class="text-info-400 font-inter font-bold">
                            High
                        </span>
                    </td>
                    <td class="p-2 font-normal text-gray-400" style="width: 80px">
                        <x-buttons.primary class="bg-teal-400">
                            Open
                            </x-buttons.button>
                    </td>
                    <td class="p-2 font-normal text-gray-400 flex justify-between">
                        <img src="https://i.pravatar.cc/300" alt="img" width="50" height="50" style="border-radius: 50%">
                        <span class="ml-2">
                            Marvin McKinney
                        </span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Teacher</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Leslie Alexander</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Cody Fisher</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Approximate 13 hours</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">17 Oct, 2024</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Website</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">17 Oct, 2024</span>
                    </td>
                </tr>
                <tr class="rounded shadow">
                    <td class="p-2" style="width: 70px">
                        <x-forms.checkbox-input />
                    </td>
                    <td class="p-2" style="width: 70px">
                        <span class="font-inter font-bold">
                            #006
                        </span>
                    </td>
                    <td class="p-2 font-normal text-gray-400" style="width: 80px">
                        <span class="text-info-400 font-inter font-bold">
                            High
                        </span>
                    </td>
                    <td class="p-2 font-normal text-gray-400" style="width: 180px">
                        <x-buttons.primary class="bg-process-400">
                            In process
                            </x-buttons.button>
                    </td>
                    <td class="p-2 font-normal text-gray-400 flex justify-between" style="width: 210px">
                        <img src="https://i.pravatar.cc/300" alt="img" width="50" height="50" style="border-radius: 50%">
                        <span class="ml-2">
                            Marvin McKinney
                        </span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Teacher</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Leslie Alexander</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Cody Fisher</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400" style="width: 210px">Approximate 13 hours</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">17 Oct, 2024</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">Website</span>
                    </td>
                    <td class="p-2">
                        <span class="font-normal text-gray-400">17 Oct, 2024</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</x-app-layout>
