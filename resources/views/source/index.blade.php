<x-app-layout> 
    <div class="flex justify-end pb-3 fixed top-24 right-10">
        <a type="submit" class="px-8 py-2 bg-primary-400 text-white rounded" href="{{ route('admin.source.create') }}">
Create Source
</a>
    </div>
                   <table class="w-full table-fixed">
                    <thead class="w-full bg-slate-100 mb-5">
                        <tr>
                            <th class="text-start ps-10 py-2">Published Events</th>
                            <th class="text-start ps-10 py-2">Sold</th>
                            <th class="text-start ps-10 py-2">Gross</th>
                            <th class="text-start ps-10 py-2">Status</th>
                        </tr>
                    </thead>

                    <tbody class="mt-5">
                        <tr class="rounded shadow">
                            <td class="p-10 flex">
                                <div class="profile">
                                    <img src="" alt="user_picture">
                                </div>
                                <div class="infos ps-5">
                                    <h5 class="font-medium text-slate-900">Business Innovation conf 24</h5>
                                    <p class="font-normal text-gray-400">11 Aug, 2024 - Sunday</p>
                                    <p class="font-normal text-gray-400">11.00-11.30 AM</p>
                                    <p class="font-normal text-gray-400">334,New York,USA</p>
                                </div>
                            </td>
                            <td class="p-10 font-normal text-gray-400">0/3</td>
                            <td class="p-10 font-normal text-gray-400">$50</td>
                            <td class="p-10 font-normal text-gray-400">Upcoming Event</td>
                        </tr>
                    </tbody>
                </table></x-app-layout>