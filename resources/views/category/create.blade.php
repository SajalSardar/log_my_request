 <x-app-layout>
    @section('title', 'Create Category')
    @section('breadcrumb')
        <x-breadcrumb>
            Create Category
        </x-breadcrumb>
    @endsection
     <div class="p-5 rounded-lg shadow-lg">
         <header class="py-5 px-2 grid md:grid-cols-2 sm:grid-cols-1 md:gap-1 sm:gap-1">
             <div class="infos">
                 <h3 class="font-bold text-xl">Create Category</h3>
                 <p>Please fill the input field where sign <span class="text-red-500">(*) </span> have.</p>
             </div>

             <div class="flex md:flex-row-reverse sm:flex-row">
                 <div>
                     <x-actions.href href="{{ route('admin.category.index') }}">
                         {{ __('Categories') }}
                     </x-actions.href>
                 </div>
             </div>
         </header>
         <hr>
         <livewire:category.create-category :parent_categories="$parent_categories" />
     </div>
 </x-app-layout>
