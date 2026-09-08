@php
    use Carbon\Carbon;
    $notifications = Auth::user()->unreadNotifications;
@endphp
<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class=" overflow-hidden sm:rounded-lg">
                <div class="p-3">
                    <div class="flex flex-row justify-between">
                        <h1 class="text-2xl md:text-3xl mt-2 md:mt-0 font-extrabold text-abugelap">Request</h1>
                        <a href="{{ url('createrq') }}" class="btn bg-black text-white font-bold hover:bg-gray-700"><i class="fa-solid fa-plus"></i> Create Request</a>
                    </div>
                    <div class="grid md:grid-cols-4 grid-rows-1">
                        <div class="flex flex-col w-full">
                            <h1 class="font-bold text-abu mt-2 ml-2"><a href="/mrq/1" class="hover:border-abu hover:border-b-2">Urgent <i class="fa-solid fa-up-right-from-square"></i></a></h1>
                            @foreach ($urgent as $urgents)
                            <a href="/detailrequest/{{ $urgents->id }}" class="mx-2">
                                <div class="card bg-white rounded-xl mt-3 overflow-hidden">
                                    <div class="absolute right-0 m-3 flex items-center gap-1.5">
                                        <span class="text-xs font-bold text-gray-400 font-mono">#{{ $urgents->id }}</span>
                                        <div class="badge badge-error rounded-[2px] text-white">{{ $urgents->status->name }}</div>
                                    </div>
                                    <div class="card-body">
                                        <h1 class="card-title font-bold">
                                            {{ Str::limit($urgents->judul, 40, '...') }} 
                                        </h1>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-secondary mb-3">{{ $urgents->outlet->nm_out }}</div>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-primary mb-3 text-white">{{ $urgents->tag->name }}</div>
                                        <div class="badge badge-neutral mb-3 text-white">{{ $urgents->kategori->name }}</div>
                                    </div>
                                    <div class="justify-start pl-7">
                                        <div class="mb-3 text-xs"><i class="fa-solid fa-calendar"></i> Updated: {{ Carbon::create($urgents->updated_at)->toFormattedDayDateString() }} ({{ $urgents->updated_at->diffForHumans() }})</div>
                                    </div>
                                    @if ($urgents->approval_status == 'approved')
                                    <div class="bg-emerald-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-white text-sm"></i>
                                            <span>Approved by <b class="font-bold">{{ $urgents->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @elseif ($urgents->approval_status == 'rejected')
                                    <div class="bg-rose-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-xmark text-white text-sm"></i>
                                            <span>Rejected by <b class="font-bold">{{ $urgents->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="flex flex-col w-full">
                            <h1 class="font-bold text-abu mt-2 ml-2"><a href="/mrq/2" class="hover:border-abu hover:border-b-2">Open <i class="fa-solid fa-up-right-from-square"></i></a></h1>
                            @foreach ($open as $opens)
                            <a href="/detailrequest/{{ $opens->id }}" class="mx-2">
                                <div class="card bg-white rounded-xl mt-3 overflow-hidden">
                                    <div class="absolute right-0 m-3 flex items-center gap-1.5">
                                        <span class="text-xs font-bold text-gray-400 font-mono">#{{ $opens->id }}</span>
                                        <div class="badge badge-info rounded-[2px] text-white">{{ $opens->status->name }}</div>
                                    </div>
                                    <div class="card-body">
                                        <h1 class="card-title font-bold">
                                            {{ Str::limit($opens->judul, 40, '...') }}
                                        </h1>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-secondary mb-3">{{ $opens->outlet->nm_out }}</div>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-primary mb-3 text-white">{{ $opens->tag->name }}</div>
                                        <div class="badge badge-neutral mb-3 text-white">{{ $opens->kategori->name }}</div>
                                    </div>
                                    <div class="justify-start pl-7">
                                        <div class="mb-3 text-xs"><i class="fa-solid fa-calendar"></i> Updated: {{ Carbon::create($opens->updated_at)->toFormattedDayDateString() }} ({{ $opens->updated_at->diffForHumans() }})</div>
                                    </div>
                                    @if ($opens->approval_status == 'approved')
                                    <div class="bg-emerald-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-white text-sm"></i>
                                            <span>Approved by <b class="font-bold">{{ $opens->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @elseif ($opens->approval_status == 'rejected')
                                    <div class="bg-rose-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-xmark text-white text-sm"></i>
                                            <span>Rejected by <b class="font-bold">{{ $opens->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="flex flex-col w-full">
                            <h1 class="font-bold text-abu mt-2 ml-2"><a href="/mrq/3" class="hover:border-abu hover:border-b-2">Progress <i class="fa-solid fa-up-right-from-square"></i></a></h1>
                            @foreach ($progress as $prog)
                            <a href="/detailrequest/{{ $prog->id }}" class="mx-2">
                                <div class="card bg-white rounded-xl mt-3 overflow-hidden">
                                    <div class="absolute right-0 m-3 flex items-center gap-1.5">
                                        <span class="text-xs font-bold text-gray-400 font-mono">#{{ $prog->id }}</span>
                                        <div class="badge badge-warning rounded-[2px] text-white">{{ $prog->status->name }}</div>
                                    </div>
                                    <div class="card-body">
                                        <h1 class="card-title font-bold">
                                            {{ Str::limit($prog->judul, 40, '...') }} 
                                        </h1>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-secondary mb-3">{{ $prog->outlet->nm_out }}</div>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-primary mb-3 text-white">{{ $prog->tag->name }}</div>
                                        <div class="badge badge-neutral mb-3 text-white">{{ $prog->kategori->name }}</div>
                                    </div>
                                    <div class="justify-start pl-7">
                                        <div class="mb-3 text-xs"><i class="fa-solid fa-calendar"></i> Updated: {{ Carbon::create($prog->updated_at)->toFormattedDayDateString() }} ({{ $prog->updated_at->diffForHumans() }})</div>
                                    </div>
                                    @if ($prog->approval_status == 'approved')
                                    <div class="bg-emerald-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-white text-sm"></i>
                                            <span>Approved by <b class="font-bold">{{ $prog->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @elseif ($prog->approval_status == 'rejected')
                                    <div class="bg-rose-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-xmark text-white text-sm"></i>
                                            <span>Rejected by <b class="font-bold">{{ $prog->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="flex flex-col w-full">
                            <h1 class="font-bold text-abu mt-2 ml-2"><a href="/mrq/4" class="hover:border-abu hover:border-b-2">Closed <i class="fa-solid fa-up-right-from-square"></i></a></h1>
                            @foreach ($closed as $close)
                            <a href="/detailrequest/{{ $close->id }}" class="mx-2">
                                <div class="card bg-white rounded-xl mt-3 overflow-hidden">
                                    <div class="absolute right-0 m-3 flex items-center gap-1.5">
                                        <span class="text-xs font-bold text-gray-400 font-mono">#{{ $close->id }}</span>
                                        <div class="badge badge-success rounded-[2px] text-white">{{ $close->status->name }}</div>
                                    </div>
                                    <div class="card-body">
                                        <h1 class="card-title font-bold">
                                            {{ Str::limit($close->judul, 40, '...') }} 
                                        </h1>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-secondary mb-3">{{ $close->outlet->nm_out }}</div>
                                    </div>
                                    <div class="card-actions justify-start pl-7">
                                        <div class="badge badge-primary mb-3 text-white">{{ $close->tag->name }}</div>
                                        <div class="badge badge-neutral mb-3 text-white">{{ $close->kategori->name }}</div>
                                    </div>
                                    <div class="justify-start pl-7">
                                        <div class="mb-3 text-xs"><i class="fa-solid fa-calendar"></i> Updated: {{ Carbon::create($close->updated_at)->toFormattedDayDateString() }} ({{ $close->updated_at->diffForHumans() }})</div>
                                    </div>
                                    @if ($close->approval_status == 'approved')
                                    <div class="bg-emerald-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-white text-sm"></i>
                                            <span>Approved by <b class="font-bold">{{ $close->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @elseif ($close->approval_status == 'rejected')
                                    <div class="bg-rose-500 text-white px-5 py-2 flex items-center justify-between text-xs font-medium">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-xmark text-white text-sm"></i>
                                            <span>Rejected by <b class="font-bold">{{ $close->approver->name ?? 'Admin' }}</b></span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="divider">
                    <p class="font-bold text-abu">⇋</p>
                   </div>
                   <div class="flex flex-row justify-between">
                    <h1 class="text-2xl md:text-3xl mt-2 md:mt-0 font-extrabold text-abugelap">Update System</h1>
                    {{-- <a href="{{ url('createus') }}" class="btn bg-black text-white font-bold hover:bg-gray-700"><i class="fa-solid fa-plus"></i> Create Update System</a> --}}
                </div>
               <div class="flex flex-col">
                <h1 class="font-bold text-abu mt-2 ml-2"><a href="/mus" class="hover:border-abu hover:border-b-2">More Update System <i class="fa-solid fa-up-right-from-square"></i></a></h1>
                <div class="grid md:grid-cols-4 grid-rows-1">
                    @foreach ($us as $ius)
                    <a href="/detailus/{{ $ius->id }}" class="mx-2">
                        <div class="card bg-white rounded-xl mt-3">
                            <div class="card-body">
                                <h1 class="card-title font-bold">
                                    {{ Str::limit($ius->judul, 40, '...') }} 
                                </h1>
                            </div>
                            <div class="card-actions justify-start pl-7">
                                <div class="badge badge-secondary mb-3">{{ $ius->outlet->nm_out }}</div>
                            </div>
                            <div class="card-actions justify-start pl-7">
                                <div class="badge badge-neutral mb-3 text-white">{{ $ius->kategori->name }}</div>
                            </div>
                            <div class="justify-start pl-7">
                                <div class="mb-3 text-xs"><i class="fa-solid fa-calendar"></i> Posted: {{ $ius->created_at->toFormattedDayDateString() }} ({{ $ius->created_at->diffForHumans() }})</div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
               </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
