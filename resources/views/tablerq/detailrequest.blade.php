@php
    use Carbon\Carbon;
    Carbon::setLocale('en');
    $rentang = Carbon::parse($datarq->start_date)->diffInDays(Carbon::parse($datarq->end_date));
    $rqid = $datarq->user_id;
    $aid = Auth::user()->id;
    $ait = Auth::user()->tag_id;
    $stid = $datarq->status_id;
    $ust = Auth::user()->usertype;

    if ($stid == 1) {
        $bg = "badge-error";
    } elseif ($stid == 2) {
        $bg = "badge-info";
    } elseif ($stid == 3) {
        $bg = "badge-warning";
    } else {
        $bg = "badge-success";
    }
    
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:px-40">
                        <div class="mb-5 flex flex-row justify-between">
                            @if ($rqid == $aid || $ust == 'admin' || $ust == 'supervisor')
                            <a href="/editrq/{{ $datarq->id }}" class="btn btn-neutral mt-3 bg-black rounded-[28px]"><i class="fa-solid fa-pen"></i> Edit Request</a> 
                            @endif
                            <a href="/" class="text-5xl text-black mt-2 hover:text-gray-700"><i class="fa-solid fa-house"></i></a>
                        </div>
                        <div class="bg-white rounded-[28px] shadow-md card overflow-hidden">
                            {{-- Action Buttons: Admin Approve/Reject & Change Status --}}
                            <div class="absolute right-0 {{ $datarq->approval_status ? 'bottom-14' : 'bottom-0' }} m-3 flex items-center gap-2 z-10">
                                @if (Auth::user()->usertype === 'admin' && in_array($datarq->status_id, [1, 2]))
                                    @if ($datarq->approval_status != 'approved' && $datarq->approval_status != 'rejected')
                                        <button type="button" onclick="approve_modal.showModal()" class="btn btn-sm btn-success text-white rounded-xl shadow">
                                            <i class="fa-solid fa-check"></i> Approve
                                        </button>
                                    @endif

                                    @if ($datarq->approval_status != 'rejected')
                                        <button type="button" onclick="reject_modal.showModal()" class="btn btn-sm btn-error text-white rounded-xl shadow">
                                            <i class="fa-solid fa-xmark"></i> Reject
                                        </button>
                                    @endif
                                @endif

                                @if ($stid != 4)
                                @if ($ait == $datarq->tag_id)
                                <div class="dropdown dropdown-top rounded-[16px]">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">Change Status</div>
                                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-40 p-2 shadow">
                                        @if ($datarq->status_id == 1 || $datarq->status_id == 2)
                                        <li><a href="/updatestatus/{{ $datarq->id }}/3" class="btn btn-warning text-white my-1 {{ $datarq->status_id == 3 ? 'hidden' : '' }}">Progress</a></li> 
                                        @else
                                        <li><a href="/updatestatus/{{ $datarq->id }}/4" class="btn btn-success text-white my-1 {{ $datarq->status_id == 4 ? 'hidden' : '' }}">Closed</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                                @endif
                            </div>
                            <div class="absolute right-0 md:m-5 m-3 flex items-center gap-2">
                                <span class="text-sm md:text-base font-bold text-gray-400 font-mono">#{{ $datarq->id }}</span>
                                <div class="badge {{ $bg }} badge-lg rounded text-white">{{ $datarq->status->name }} 
                                    @if ($datarq->status_id == 3 || $datarq->status_id == 4)
                                        
                                    @if ($reqlog != null)
                                    by {{ $reqlog->user->name }}
                                    @endif
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title text-2xl font-bold">{{ $datarq->judul }}</h1>
                                <article>
                                    {!! $datarq->deskripsi !!}
                                </article>
                                <div class="mb-5 flex flex-wrap rounded-md image-container">
                                    @foreach ($dataimg as $img)
                                    <div class="h-[200px] w-1/2 md:w-1/3 border shadow-sm overflow-hidden cursor-pointer rounded-xl image" onclick="my_modal_3.showModal()">
                                        <img src="/img/{{ $img->image }}" alt="" class="rounded-xl h-full w-full object-cover hover:w-[120%] hover:h-[120%] ease-in-out duration-300">
                                    </div>
                                    @endforeach
                                </div>
                                <dialog id="my_modal_3" class="modal">
                                    <div class="modal-box w-11/12 max-w-5xl">
                                        <form method="dialog">
                                            <button class="btn btn-sm btn-circle btn-error absolute right-2 top-2 text-white">✕</button>
                                        </form>
                                        <img src="{{ asset('img/tes5.jpg') }}" alt="" class="w-full">
                                    </div>
                                </dialog>
                                @if (Auth::user()->usertype === 'admin' && in_array($datarq->status_id, [1, 2]))
                                {{-- Modal Approve Confirmation --}}
                                <dialog id="approve_modal" class="modal">
                                    <div class="modal-box rounded-2xl max-w-md">
                                        <form method="dialog">
                                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                        </form>
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                                <i class="fa-solid fa-circle-check text-xl"></i>
                                            </div>
                                            <h3 class="font-bold text-lg text-gray-800">Setujui Request</h3>
                                        </div>
                                        <p class="py-2 text-sm text-gray-500">Apakah Anda yakin ingin menyetujui (Approve) request ini?</p>
                                        <div class="modal-action">
                                            <button type="button" onclick="approve_modal.close()" class="btn btn-ghost">Batal</button>
                                            <form action="/request/{{ $datarq->id }}/approve" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success text-white font-bold">Ya, Setujui</button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>
                                {{-- Modal Reject Reason --}}
                                <dialog id="reject_modal" class="modal">
                                    <div class="modal-box rounded-2xl max-w-md">
                                        <form method="dialog">
                                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                        </form>
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600">
                                                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                                            </div>
                                            <h3 class="font-bold text-lg text-gray-800">Tolak Request</h3>
                                        </div>
                                        <p class="py-1 text-sm text-gray-500">Silakan masukkan alasan penolakan untuk request ini:</p>
                                        <form action="/request/{{ $datarq->id }}/reject" method="POST">
                                            @csrf
                                            <textarea name="reason" rows="3" class="textarea textarea-bordered w-full rounded-xl focus:outline-none mt-2" placeholder="Tuliskan alasan penolakan..." required></textarea>
                                            <div class="modal-action">
                                                <button type="button" onclick="reject_modal.close()" class="btn btn-ghost">Batal</button>
                                                <button type="submit" class="btn btn-error text-white font-bold">Tolak Request</button>
                                            </div>
                                        </form>
                                    </div>
                                </dialog>
                                @endif
                                <div class="card-actions justify-start">
                                    <div class="badge badge-secondary badge-lg text-white">{{ $datarq->outlet->nm_out }}</div>
                                </div>
                                <div class="card-actions justify-start">
                                    <div class="badge badge-primary badge-lg text-white">{{ $datarq->tag->name }}</div>
                                    <div class="badge badge-neutral badge-lg text-white">{{ $datarq->kategori->name }}</div>
                                </div>
                                <div>
                                    <p class="text-sm font-bold"><i class="fa-solid fa-hourglass-start"></i> Deadline: {{ Carbon::parse($datarq->start_date)->translatedFormat('l, d-m-Y') }} - {{ Carbon::parse($datarq->end_date)->translatedFormat('l, d-m-Y') }} 
                                    @if ($rentang == 1)
                                        ({{ $rentang }} day)
                                    @else
                                        ({{ $rentang }} days) 
                                    @endif</p>
                                </div>
                                <div>
                                    <p class="text-sm font-bold"><i class="fa-solid fa-calendar"></i> Posted: {{ Carbon::parse($datarq->created_at)->translatedFormat('l, d-m-Y') }} ({{ $datarq->created_at->diffForHumans() }})</p>
                                </div>
                                <div>
                                    <p class="text-sm font-bold">
                                        <i class="fa-solid fa-file-pen"></i> Updated: {{ Carbon::parse($datarq->updated_at)->translatedFormat('l, d-m-Y') }} ({{ $datarq->updated_at->diffForHumans() }})
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-bold"><i class="fa-solid fa-user-pen"></i> {{ $datarq->user->name }}</p>
                                </div>
                            </div>
                            {{-- Bottom Approval / Rejection Bar --}}
                            @if ($datarq->approval_status == 'approved')
                            <div class="bg-emerald-500 text-white px-6 py-3 flex flex-col md:flex-row items-start md:items-center justify-between gap-2 text-xs md:text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-white text-base"></i>
                                    <span>Approved by <b class="font-bold">{{ $datarq->approver->name ?? 'Admin' }}</b></span>
                                </div>
                                <div class="flex items-center gap-2 text-white">
                                    <i class="fa-solid fa-clock text-xs"></i>
                                    <span>{{ $datarq->approval_date ? Carbon::parse($datarq->approval_date)->translatedFormat('l, d-m-Y') . ' (' . Carbon::parse($datarq->approval_date)->diffForHumans() . ')' : '' }}</span>
                                </div>
                            </div>
                            @elseif ($datarq->approval_status == 'rejected')
                            <div class="bg-rose-500 text-white px-6 py-3 flex flex-col md:flex-row items-start md:items-center justify-between gap-2 text-xs md:text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-xmark text-white text-base"></i>
                                    <span>Rejected by <b class="font-bold">{{ $datarq->approver->name ?? 'Admin' }}</b></span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-white">
                                    @if ($datarq->approval_note)
                                    <div class="bg-rose-600/80 px-2.5 py-1 rounded-md text-xs">
                                        <span>Alasan: <span class="italic font-normal">{{ $datarq->approval_note }}</span></span>
                                    </div>
                                    @endif
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <i class="fa-solid fa-clock"></i>
                                        <span>{{ $datarq->approval_date ? Carbon::parse($datarq->approval_date)->translatedFormat('l, d-m-Y') . ' (' . Carbon::parse($datarq->approval_date)->diffForHumans() . ')' : '' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if ($stid == 3)
                            
                        @if ($datarq->user_id != $aid && $ait == $datarq->tag_id)
                        <div>
                            <a href="/createus/{{ $datarq->id }}"><button type="button" class="btn btn-neutral bg-black mt-3 w-full text-white rounded-3xl"><i class="fa-solid fa-plus"></i> Create Update System</button></a>
                        </div> 
                        @endif
                        @endif
                        {{-- <details class="collapse bg-white mt-5 shadow-lg">
                            <summary class="collapse-title text-xl font-medium">Status Log</summary>
                            <div class="collapse-content">
                              <p>content</p>
                              <p>content</p>
                              <p>content</p>
                              <p>content</p>
                              <p>content</p>
                              <p>content</p>
                              <p>content</p>
                            </div>
                        </details> --}}
                        @if (count($dataus) >= 1)
                        <details class="collapse bg-white mt-5 shadow-lg">
                            <summary class="collapse-title text-xl font-bold"><b>Update System</b> <i>(click to expand)</i></summary>
                            <div class="collapse-content">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                      
                                      <tbody>
                                        <!-- row 1 -->
                                        @foreach ($dataus as $us)
                                        <tr>
                                          <th><div class="badge badge-accent badge-outline mx-1">{{ $us->user->name }}</div></th>
                                          <td><a href="/detailus/{{ $us->id }}" class="hover:underline font-bold text-base">{{ $us->judul }} <i class="fa-solid fa-up-right-from-square"></i></a></td>
                                          <td>{{ $us->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                
                                  {{-- <p class="my-1"> </p> --}}
                            </div>
                        </details>
                        @endif
                        <div class="divider font-bold text-abu">
                            COMMENT
                        </div>
                        <div>
                            @if (count($komentar) >= 1)
                            @foreach ($komentar as $komen)
                            <div class="chat {{ $komen->user_id == $aid ? 'chat-end' : 'chat-start' }}">
                                <div class="chat-header">
                                  {{ $komen->user->name }}
                                  <time class="text-xs opacity-50">{{ $komen->created_at->diffForHumans() }}</time>
                                </div>
                                <div class="chat-bubble bg-white text-black shadow-lg border">
                                    {!! $komen->body !!}
                                </div>
                                @if ($komen->user_id == $aid)
                                <div class="chat-footer opacity-50"><a data-confirm-delete="true" href="/deletekomen/{{ $komen->id }}" class="hover:underline">Delete Comment</a></div>
                                @endif
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="my-5 bg-white shadow-lg rounded-xl p-2">
                            <form action="/komentar/{{ $datarq->id }}" method="POST">
                                @csrf
                                <input type="hidden" id="comment" name="comment" value="{{ old('comment') }}">
                                <trix-editor trix-attachment-remove input="comment"></trix-editor>
                                <button type="submit" class="btn btn-neutral bg-black mt-3 w-full text-white">Comment <i class="fa-solid fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.image-container img').forEach(image =>{
            image.onclick = () =>{
                document.querySelector('.modal-box img').src = image.getAttribute('src');
            }
        });
    </script>
</x-app-layout>