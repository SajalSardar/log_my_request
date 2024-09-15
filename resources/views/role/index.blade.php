 <x-app-layout>
     <div class="relative overflow-x-auto bg-white">
         <div class="flex justify-end pb-3 fixed top-24 right-10">
             <x-actions.href href="{{ route('dashboard.role.create') }}">
                 Create Role
             </x-actions.href>
         </div>
         <table class="w-full overflow-x-auto">
             <thead class="w-full bg-slate-100 mb-5">
                 <tr>
                     <th class="text-start ps-10 py-2">#</th>
                     <th class="text-start ps-10 py-2">Role Name</th>
                     <th class="text-start ps-10 py-2">Modified At</th>
                     <th class="text-start ps-10 py-2">Action</th>
                 </tr>
             </thead>

             <tbody class="mt-5">
                 @forelse ($roles as $each)
                     <tr class="rounded shadow">
                         <td class="p-10 flex">

                             <div class="infos ps-5">
                                 <h5 class="font-medium text-slate-900">{{ $each?->id }}</h5>
                             </div>
                         </td>
                         <td class="p-10 font-normal text-gray-400">{{ $each?->name }}</td>
                         <td class="p-10 font-normal text-gray-400">
                             {!! Helper::ISOdate($each->updated_at) !!}
                         </td>
                         <td>
                             <div class="flex">
                                 <x-actions.edit route="{{ route('dashboard.role.edit', $each->id) }}" />
                                 {{-- <x-actions.delete action="{{ route('dashboard.role.destroy', ['role' => $each->id]) }}" /> --}}
                             </div>
                         </td>
                     </tr>
                 @empty
                     <tr>
                         <td colspan="4" class="text-center">
                             <h5 class="font-medium text-slate-900">No data found !!!</h5>
                         </td>
                     </tr>
                 @endforelse

             </tbody>
         </table>
     </div>
 </x-app-layout>
