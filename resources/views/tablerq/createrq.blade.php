<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-end text-5xl mb-5">
                <a href="/" class="text-5xl text-black mt-2 hover:text-gray-700"><i class="fa-solid fa-house"></i></a>
            </div>
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="bg-white rounded-[28px] shadow-md card w-full">
                <div class="card-body">
                                <h1 class="card-title text-3xl font-extrabold mb-4">Create Request</h1>
                                <form method="POST" action="/createrq" enctype="multipart/form-data">
                                    @csrf
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Left Column -->
                                        <div class="flex flex-col space-y-4">
                                            <!-- Title -->
                                            <div>
                                                <p class="font-bold">Title</p>
                                                <input type="text" class="input rounded-xl input-bordered w-full" name="title" value="{{ old('title') }}" placeholder="Enter request title...">
                                            </div>

                                            <!-- Row: Outlet & Tag -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <!-- Outlet -->
                                                <div x-data="{
                                                    selectedId: {{ json_encode(old('outlet', '')) }},
                                                    searchQuery: {{ json_encode(old('outl', '')) }},
                                                    open: false,
                                                    loading: false,
                                                    results: [],
                                                    searchOutlets() {
                                                        if (!this.searchQuery || this.searchQuery.trim().length === 0) {
                                                            this.results = [];
                                                            this.open = false;
                                                            this.selectedId = '';
                                                            return;
                                                        }
                                                        this.loading = true;
                                                        fetch('/getOutlet/' + encodeURIComponent(this.searchQuery.trim()))
                                                            .then(res => res.json())
                                                            .then(res => {
                                                                this.results = res.data || [];
                                                                this.open = true;
                                                            })
                                                            .catch(err => {
                                                                console.error('Error fetching outlets:', err);
                                                            })
                                                            .finally(() => {
                                                                this.loading = false;
                                                            });
                                                    },
                                                    selectOutlet(item) {
                                                        this.selectedId = item.id;
                                                        this.searchQuery = item.nm_out;
                                                        this.open = false;
                                                    }
                                                }">
                                                    <p class="font-bold">Outlet</p>
                                                    <input type="hidden" name="outlet" :value="selectedId" required>
                                                    <div class="relative" @click.outside="open = false">
                                                        <div class="relative flex items-center">
                                                            <input 
                                                                type="text" 
                                                                class="input rounded-xl input-bordered w-full pr-10" 
                                                                name="outl" 
                                                                placeholder="Search outlet..."
                                                                x-model="searchQuery" 
                                                                @input.debounce.300ms="searchOutlets()"
                                                                @focus="if(searchQuery && searchQuery.trim().length > 0) open = true"
                                                                autocomplete="off"
                                                                required
                                                            >
                                                            <div class="absolute right-3 text-gray-400 pointer-events-none">
                                                                <i x-show="!loading" class="fa-solid fa-magnifying-glass"></i>
                                                                <i x-show="loading" class="fa-solid fa-spinner fa-spin text-primary" style="display: none;"></i>
                                                            </div>
                                                        </div>

                                                        <!-- Dropdown Results -->
                                                        <div 
                                                            x-show="open && results.length > 0" 
                                                            x-transition
                                                            class="absolute left-0 right-0 z-50 mt-1 max-h-56 overflow-y-auto bg-white border border-gray-200 rounded-xl shadow-lg"
                                                            style="display: none;"
                                                        >
                                                            <ul class="py-1 divide-y divide-gray-100">
                                                                <template x-for="item in results" :key="item.id">
                                                                    <li 
                                                                        @click="selectOutlet(item)"
                                                                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex justify-between items-center transition duration-150"
                                                                    >
                                                                        <div>
                                                                            <span class="font-semibold text-gray-800 text-sm" x-text="item.nm_out"></span>
                                                                            <template x-if="item.lokasi">
                                                                                <span class="text-xs text-gray-500 block" x-text="item.lokasi"></span>
                                                                            </template>
                                                                        </div>
                                                                        <i class="fa-solid fa-check text-success" x-show="selectedId == item.id"></i>
                                                                    </li>
                                                                </template>
                                                            </ul>
                                                        </div>

                                                        <!-- No results message -->
                                                        <div 
                                                            x-show="open && results.length === 0 && searchQuery && searchQuery.trim().length > 0 && !loading"
                                                            x-transition
                                                            class="absolute left-0 right-0 z-50 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg p-3 text-sm text-gray-500 text-center"
                                                            style="display: none;"
                                                        >
                                                            No outlet found.
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tag -->
                                                <div>
                                                    <p class="font-bold">Tag</p>
                                                    <select name="tag" id="tag" class="select select-bordered w-full rounded-xl">
                                                        @foreach ($tag as $tagitem)
                                                        <option value="{{ $tagitem->id }}" {{ old('tag') == $tagitem->id ? 'selected' : '' }}>{{ $tagitem->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Row: Category & Status -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <!-- Category -->
                                                <div>
                                                    <p class="font-bold">Category</p>
                                                    <select name="category" id="category" class="select select-bordered w-full rounded-xl">
                                                        @foreach ($kategori as $kategoriitem)
                                                        <option value="{{ $kategoriitem->id }}" {{ old('category') == $kategoriitem->id ? 'selected' : '' }}>{{ $kategoriitem->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Status -->
                                                <div>
                                                    <p class="font-bold">Status</p>
                                                    <select name="status" id="status" class="select select-bordered w-full rounded-xl">
                                                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Open</option>
                                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Urgent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Period -->
                                            <div>
                                                <p class="font-bold">Period</p>
                                                <div class="flex items-center gap-2">
                                                    <input type="date" class="input input-bordered rounded-xl w-full border-gray-300" name="startdate" value="{{ old('startdate') }}" required>
                                                    <span class="font-bold text-gray-500 px-1">TO</span>
                                                    <input type="date" class="input input-bordered rounded-xl w-full border-gray-300" name="enddate" value="{{ old('enddate') }}" required>
                                                </div>
                                            </div>

                                            <!-- Image -->
                                            <div>
                                                <p class="font-bold">Image</p>
                                                <input type="file" multiple class="file-input file-input-bordered w-full rounded-xl" name="images[]">
                                                <div class="label pb-0">
                                                    <span class="label-text text-xs text-gray-500">MAX FILES: 6 IMAGES | MAX SIZE: 200KB/IMAGE</span>
                                                </div>
                                                <div class="text-xs text-gray-400 mt-1">
                                                    <span>For multiple files: </span>
                                                    <kbd class="kbd kbd-xs">ctrl</kbd>
                                                    +
                                                    <kbd class="kbd kbd-xs"><i class="fa-solid fa-arrow-pointer"></i> click</kbd>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column: Description -->
                                        <div class="flex flex-col">
                                            <div class="sticky top-0 z-20 bg-white pt-2 pb-2 mb-2 border-b border-gray-100 shadow-sm rounded-t-xl">
                                                <p class="font-bold text-base mb-1">Description</p>
                                                <trix-toolbar id="trix-toolbar-create"></trix-toolbar>
                                            </div>
                                            <input type="hidden" id="body" name="body" value="{{ old('body') }}">
                                            <div class="flex-1 flex flex-col">
                                                <trix-editor toolbar="trix-toolbar-create" trix-attachment-remove input="body" class="bg-white rounded-xl border border-gray-300 p-3 min-h-[380px] flex-1 focus:outline-none"></trix-editor>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-6">
                                        <button type="submit" class="btn btn-neutral bg-black w-full rounded-xl text-white hover:bg-gray-800">SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    <script>
        document.addEventListener('trix-file-accept', function(e){
            e.preventDefault();
        });
    </script>
</x-app-layout>