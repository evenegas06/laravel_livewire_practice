<div>
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
                            wire:click='save'
                            wire:loading.attr='disabled' 
                            wire:target='save'
                        >
                        Guardar Post
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
