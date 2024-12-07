<x-app-layout>
    @section('title', camelCase(request()->entity))
    @include('entity.breadcrumb', ['value' => camelCase(request()->entity)])
    <div class="flex justify-between items-center !mt-3 mb-6">
        <div>
            <p class="text-detail-heading">All {{ camelCase(request()->entity) }}</p>
        </div>
    </div>

    <div class="relative">
        <table class="display nowrap" id="data-table" style="width: 100%;border:none;">
            <thead style="background:#F3F4F6; border:none">
                <tr>
                    <th class="text-heading-dark pl-5 text-start">ID</th>
                    <th class="text-heading-dark pl-2 text-start">{{ camelCase(request()->entity) }}</th>
                    @php
                        $heading = match(request()->entity){
                         'requesters'   => 'Requests',
                         'agents'       => 'Resolved',
                         'categories'   => 'Requests',
                         'teams'        => 'Agents',
                          default => 'Total'
                        }
                    @endphp
                    <th class="text-heading-dark pl-2 text-start"> {{  $heading }}</th>
                    <th class="text-heading-dark text-start"></th>
                </tr>
            </thead>

            @forelse ($collections as $each)
                <tbody>
                    <tr class="text-center border border-base-500">
                        <td>
                            <h5 class="text-paragraph pl-3"> # {{ $each?->id }}</h5>
                        </td>
                        <td>
                            <h5 class="text-paragraph">{{ $each?->name }}</h5>
                        </td>
                        <td>
                            <h5 class="text-paragraph">{{ $each?->total }}</h5>
                        </td>
                        <td>
                            <div class="relative">
                                <button onclick="toggleAction({{$each->id}})" class="p-3 hover:bg-slate-100 rounded-full">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.9922 12H12.0012" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.9844 18H11.9934" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 6H12.009" stroke="#666666" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <div id="action-{{ $each->id }}" class="shadow-lg z-30 absolute top-5 right-10" style="display: none">
                                    <ul>
                                        <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                            <a href="{{ $each->action->edit }}">Edit</a>
                                        </li>
                                        <li class="px-5 py-2 text-center bg-white text-paragraph hover:bg-primary-600 hover:text-primary-400">
                                            <form action="{{ $each->action->delete }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-paragraph">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>


                </tbody>
            @empty
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center">
                            <h5 class="font-medium text-slate-900">No data found !!!</h5>
                        </td>
                    </tr>
                </tbody>
            @endforelse

        </table>

    </div>
</x-app-layout>