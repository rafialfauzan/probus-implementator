<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:px-40">
                        <div class="card bg-base-100 shadow-lg mb-10">
                            <figure class="h-40">
                              <img
                                src="https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp"
                                alt="City" class="w-full"/>
                            </figure>
                            <div class="avatar w-36 md:ml-10 md:mt-12 md:absolute mx-auto">
                                <div class="rounded-full border-4 border-white">
                                  <img src="/img/material/user1.png" />
                                </div>
                            </div>
                            <div class="card-body flex md:flex-row flex-col justify-between items-center md:items-start pt-6">
                              <div class="px-4 flex-1 md:text-left text-center mb-4 md:mb-0">
                                <h2 class="card-title text-2xl font-bold justify-center md:justify-start">{{ Auth::user()->name }}</h2>
                                <p class="my-2 flex items-center justify-center md:justify-start gap-2 text-gray-600"><i class="fa-solid fa-envelope text-gray-400"></i> {{ Auth::user()->email }}</p>
                                <div class="flex flex-wrap gap-2 justify-center md:justify-start mt-3">
                                    <a href="/editprofile/{{ Auth::user()->id }}"><button class="btn btn-sm btn-neutral rounded-2xl text-white">edit profile <i class="fa-solid fa-pen-to-square"></i></button></a>
                                    <a href="/editpassacc"><button class="btn btn-sm btn-neutral rounded-2xl text-white">change password <i class="fa-solid fa-key"></i></button></a>
                                </div>
                              </div>
                              <div class="px-4 shrink-0 flex flex-col md:items-end items-center justify-center gap-3 mt-4 md:mt-0">
                                <div class="flex items-center gap-2.5">
                                  <span class="text-sm font-medium text-gray-600 flex items-center gap-1.5">
                                    User Tag <i class="fa-solid fa-user-tag text-primary"></i>
                                  </span>
                                  <div class="badge badge-outline badge-accent font-semibold px-3 py-2">
                                    {{ Auth::user()->tag ? Auth::user()->tag->name : '-' }}
                                  </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                  <span class="text-sm font-medium text-gray-600 flex items-center gap-1.5">
                                    User Type <i class="fa-regular fa-address-card text-primary"></i>
                                  </span>
                                  <div class="badge badge-outline badge-accent font-semibold px-3 py-2 capitalize">
                                    {{ Auth::user()->usertype }}
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="justify-between flex flex-row">
                                    <p class="text-center text-3xl font-bold">Request List</p>
                                </div>
                                <div class="mt-5 mb-10">
                                    <a href="{{ route('createrq') }}" class="bg-black font-bold text-white px-2 py-2 rounded-md border-black border-solid border-2 hover:bg-white hover:text-black transition delay-50 duration-300"><i class="fa-solid fa-plus"></i> Create new request</a>
                                </div>
                                <div class="mt-5">
                                    <table class="table-fixed w-full">
                                        <thead class="bg-gray-300 text-black">
                                            <tr>
                                                <th class="p-3 text-sm font-bold tracking-wide text-left rounded-tl-xl w-7/12">Title</th>
                                                <th class="p-3 text-sm font-bold tracking-wide text-left w-3/12">Status</th>
                                                <th class="p-3 text-sm font-bold tracking-wide text-center rounded-tr-xl w-2/12">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($req as $rq)
                                            @php
                                                if ($rq->status_id == 1) {
                                                    $bg = "badge-error";
                                                } elseif ($rq->status_id == 2) {
                                                    $bg = "badge-info";
                                                } elseif ($rq->status_id == 3) {
                                                    $bg = "badge-warning";
                                                } else {
                                                    $bg = "badge-success";
                                                }
                                            @endphp
                                            <tr>
                                                <td class="p-3 text-lg text-abugelap truncate"><a href="/detailrequest/{{ $rq->id }}" class="hover:underline" title="{{ $rq->judul }}">{{ Str::limit($rq->judul, 60, '...') }}</a></td>
                                                <td class="p-3 text-sm text-abugelap"><div class="badge {{ $bg }} badge-lg rounded text-white">{{ $rq->status->name }}</div></td>
                                                <td class="p-3 text-xl text-abugelap text-center whitespace-nowrap">
                                                    <a class="hover:text-black mx-2" href="/editrq/{{ $rq->id }}"><i class="fa-solid fa-pen"></i></a>
                                                    <a data-confirm-delete="true" class="hover:text-black mx-2" href="/deletereq/{{ $rq->id }}"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h1 class="font-bold text-abu mt-2 ml-2 "><a href="/myrequest" class="hover:border-abu hover:border-b-2 transition delay-50 duration-300">View all Request <i class="fa-solid fa-up-right-from-square"></i></a></h1>
                                </div>
                                <div class="divider"></div>
                                <div class="justify-between flex flex-row">
                                    <p class="text-center text-3xl font-bold">Update System List</p>
                                </div>
                                <div class="mt-5">
                                    <table class="table-fixed w-full">
                                        <thead class="bg-gray-300 text-black">
                                            <tr>
                                                <th class="p-3 text-sm font-bold tracking-wide text-left rounded-tl-xl w-6/12">Title</th>
                                                <th class="p-3 text-sm font-bold tracking-wide text-left w-4/12">from Request</th>
                                                <th class="p-3 text-sm font-bold tracking-wide text-center rounded-tr-xl w-2/12">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($updt as $up)
                                                <tr>
                                                    <td class="p-3 text-lg text-abugelap truncate"><a href="/detailus/{{ $up->id }}" class="hover:underline" title="{{ $up->judul }}">{{ Str::limit($up->judul, 50, '...') }}</a></td>
                                                    <td class="p-3 text-lg text-abugelap truncate"><a href="/detailrequest/{{ $up->request_id }}" class="hover:underline" title="{{ $up->request ? $up->request->judul : '' }}">{{ $up->request ? Str::limit($up->request->judul, 40, '...') : '-' }}</a></td>
                                                    <td class="p-3 text-xl text-abugelap text-center whitespace-nowrap">
                                                        <a class="hover:text-black mx-2" href="/editus/{{ $up->id }}"><i class="fa-solid fa-pen"></i></a>
                                                        <a data-confirm-delete="true" class="hover:text-black mx-2" href="/deleteus/{{ $up->id }}"><i class="fa-solid fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h1 class="font-bold text-abu mt-2 ml-2"><a href="/myupdatesystem" class="hover:border-abu hover:border-b-2 transition delay-50 duration-300">View all Update System <i class="fa-solid fa-up-right-from-square"></i></a></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>