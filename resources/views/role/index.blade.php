 <x-app-layout>
     @section('title', 'Role List')
     @section('breadcrumb')
         <x-breadcrumb>
             Role List
         </x-breadcrumb>
     @endsection

     <div class="flex justify-between items-center !mt-3">
         <div>
             <p class="text-detail-heading">Role List</p>
         </div>
         <div class="flex-1 mt-1">
             <div class="flex justify-end gap-3">
                 <div>
                     <x-actions.href href="{{ route('admin.role.create') }}" class="block">
                         Create Role
                         <svg class="inline-block" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M12.5 8V16M16.5 12H8.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                             <path d="M12.5 22C18.0228 22 22.5 17.5228 22.5 12C22.5 6.47715 18.0228 2 12.5 2C6.97715 2 2.5 6.47715 2.5 12C2.5 17.5228 6.97715 22 12.5 22Z" stroke="white" stroke-width="1.5" />
                         </svg>
                     </x-actions.href>
                 </div>
             </div>
         </div>
     </div>

     <div class="relative">
         <table class="display nowrap" id="data-table" style="width: 100%;border:1px solid #ddd">
             <thead style="background:#F3F4F6;">
                 <tr>
                     <th class="text-heading-dark !text-end">
                         <span class="flex gap-1 !justify-center !items-center">
                             <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M2.5 5H4.16667H17.5" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M15.8332 5.00008V16.6667C15.8332 17.1088 15.6576 17.5327 15.345 17.8453C15.0325 18.1578 14.6085 18.3334 14.1665 18.3334H5.83317C5.39114 18.3334 4.96722 18.1578 4.65466 17.8453C4.3421 17.5327 4.1665 17.1088 4.1665 16.6667V5.00008M6.6665 5.00008V3.33341C6.6665 2.89139 6.8421 2.46746 7.15466 2.1549C7.46722 1.84234 7.89114 1.66675 8.33317 1.66675H11.6665C12.1085 1.66675 12.5325 1.84234 12.845 2.1549C13.1576 2.46746 13.3332 2.89139 13.3332 3.33341V5.00008" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M8.3335 9.16675V14.1667" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M11.6665 9.16675V14.1667" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                             </svg>
                             <input type="checkbox" class="border text-center border-slate-200 rounded focus:ring-transparent p-1" style="background-color: #9b9b9b; accent-color: #5C5C5C;">
                         </span>
                     </th>
                     <th class="text-heading-dark text-center">Id</th>
                     <th class="text-heading-dark">Role Name</th>
                     <th class="text-heading-dark">Permission</th>
                     <th class="text-heading-dark">Created At</th>
                     <th class="text-heading-dark">Action</th>
                 </tr>
             </thead>

             <tbody>
             </tbody>
         </table>
     </div>

     @section('script')
         <script>
             $(function() {
                 var dTable = $('#data-table').DataTable({
                     processing: true,
                     serverSide: true,
                     responsive: true,
                     searching: false,
                     scrollX: true,
                     order: [
                         0, 'desc'
                     ],
                     ajax: {
                         url: "{{ route('admin.role.list.datatable') }}",
                         type: "GET",
                         //  data: function(d) {
                         //      d._token = "{{ csrf_token() }}";
                         //      d.unser_name_search = $('#unser_name_search').val();
                         //      d.unser_email_search = $('#unser_email_search').val();
                         //  }
                     },
                     columns: [{
                             data: 'select',
                             name: 'select'
                         },
                         {
                             data: 'id',
                             name: 'id'
                         },
                         {
                             data: 'name',
                             name: 'name'
                         },
                         {
                             data: 'permission',
                             name: 'permission'
                         },
                         {
                             data: 'created_at',
                             name: 'created_at'
                         },
                         {
                             data: 'action_column',
                             name: 'action_column'
                         }
                     ]
                 });
                 //  $(document).on('change keyup',
                 //      '#unser_name_search, #unser_email_search',
                 //      function(e) {
                 //          dTable.draw();
                 //          e.preventDefault();
                 //      });
             });
         </script>
     @endsection
 </x-app-layout>
