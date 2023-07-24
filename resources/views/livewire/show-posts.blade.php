<div wire:init="loadPost">
    <div class="px-6 py-4 flex items-center">
        <div class="flex items-center">
            <span>Mostrar</span>

            <select 
                name="show-elements" 
                wire:model='amount'
                id="show-elements"
                class="mx-2 form-control rounded-md"
            >
                <option value="1">1</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>

            <span>entradas</span>
        </div>

        <input
            type="text"
            class="flex-1 mx-4 rounded-md"
            placeholder="Buscar..." 
            wire:model="search" 
        />

        <livewire:create-post />
    </div>

    {{-- Table --}}
    @if (count($posts))
        <table class="table-fixed min-w-full divide-y divide-red-700 border">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="w-24 cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        wire:click="order('id')"
                    >
                        ID <i class="fas fa-sort mt-1" style="float: right;"></i>
                    </th>

                    <th scope="col"
                        class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        wire:click="order('title')"
                    >
                        Titulo <i class="fas fa-sort mt-1" style="float: right;"></i>
                    </th>

                    <th scope="col"
                        class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        wire:click="order('content')"
                    >
                        Contenido <i class="fas fa-sort mt-1" style="float: right;"></i>
                    </th>

                    <th 
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($posts as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $item->id }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $item->title }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $item->content }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            {{-- <livewire:edit-post :post="$post" wire:key="{{ $post->id }}"/> // Componente de anidamiento --}}
                            <button 
                                class="font-bold text-white py-2 px-4 rounded cursor-pointer bg-green-600 hover:bg-green-500"
                                wire:click="edit({{ $item }})"
                            >
                        
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($posts->hasPages())
            <div class="px-6 py-3">
                {{ $posts->links() }}
            </div>
        @endif
    @else
        <div class="px-6 py-4">
            <h2>No hay ninguna coincidencia con la busqueda solicitada 😢</h2>
        </div>
    @endif

    {{-- Modal --}}
    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10 {{ $open ? '' : 'hidden' }}">
        <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-white">
            <div class="w-full">
                <div class="m-8 my-20 max-w-[400px] mx-auto">
                    <div class="mb-8 text-center">
                        <h1 class="mb-4 text-3xl font-extrabold">Editar el post ✍️</h1>
                    </div>

                    <div class="space-y-4">
                        <label 
                            for="title"
                            class="text-lg text-bold my-2"
                        >
                            Titulo
                        </label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            class="w-full rounded-md"
                            placeholder="Título del post"
                            wire:model="post.title"
                        />
                    
                    @error('title')
                        <span class="text-red-600 text-sm">
                            {{ $message }}
                        </span>
                    @enderror

                        <label 
                            for="content"
                            class="text-lg text-bold my-2"
                        >
                            Contenido
                        </label>
                        <textarea 
                            id="content"
                            name="content"
                            class="w-full rounded-md"
                            rows="6"
                            placeholder="Contenido del post"
                            wire:model="post.content"></textarea>
                    
                        @error('content')
                            <span class="text-red-600 text-sm">
                                {{ $message }}
                            </span>
                        @enderror

                        <div>
                            <input
                                id="upload_{{ $now }}"
                                type="file" 
                                wire:model='image' 
                            />
                            
                            @error('image')
                                <span class="text-red-600 text-sm">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="w-full mb-2 select-none rounded-l-lg border-l-4 border-yellow-400 bg-yellow-100 text-yellow-600 p-4 font-medium hover:border-yellow-500"
                            wire:loading
                            wire:target='image'
                        >
                            <span class="font-bold">¡Cargando imagen!</span>
                            Por favor espere...
                        </div>

                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="image">
                        @else
                            <img src="{{ Storage::url($post->image) }}" alt="image">
                        @endif

                        <button 
                            class="disabled:opacity-25 p-3 bg-black rounded-full text-white w-full font-semibold"
                            wire:click='update'
                            wire:loading.attr='disabled' 
                            wire:target='update'
                        >
                            Actualizar información
                        </button>
                        
                        <button 
                            class="p-3 bg-white border rounded-full w-full font-semibold"
                            wire:click="$set('open', false)"
                        >
                            Cerrar / Cancelar
                        </button>

                        <span wire:loading wire:target="save">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
