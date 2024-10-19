 <x-app-layout>
     <div class="flex justify-end pb-3">
         <x-actions.href href="{{ route('admin.role.create') }}">
             Create Role
         </x-actions.href>
     </div>
     <div class="relative overflow-x-auto bg-white">

         <table class="w-full overflow-x-auto">
             <thead class="w-full bg-slate-100 mb-5">
                 <tr>
                     <th class="text-start pl-3 py-2">#</th>
                     <th class="text-start pl-3 py-2">Role Name</th>
                     <th class="text-start pl-3 py-2">Permissions</th>
                     <th class="text-start pl-3 py-2">Modified At</th>
                     <th class="text-start pl-3 py-2">Action</th>
                 </tr>
             </thead>

             <tbody class="mt-5">
                 @forelse ($roles as $each)
                     <tr class="rounded shadow">
                         <td class="p-3 flex">

                             <div class="infos ps-5">
                                 <h5 class="font-medium text-slate-900">{{ $each?->id }}</h5>
                             </div>
                         </td>

                         <td class="p-3 font-normal text-gray-400">{{ $each?->name }}</td>
                         <td class="p-3 font-normal text-gray-400">
                             @foreach ($each?->permissions as $permission)
                                 <span class="bg-green-200 px-1 rounded text-gray-500">{{ $permission->name }}</span>
                             @endforeach
                         </td>
                         <td class="p-3 font-normal text-gray-400">
                             {!! Helper::ISOdate($each->updated_at) !!}
                         </td>
                         <td>
                             <div class="flex ">
                                 <x-actions.edit route="{{ route('admin.role.edit', $each->id) }}" />
                                 {{-- <x-actions.delete action="{{ route('admin.role.destroy', ['role' => $each->id]) }}" /> --}}
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
