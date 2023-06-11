<div>
    <div class="px-6 py-4 flex">
        <input
            type="text"
            class="flex-1 mx-4 rounded-md"
            placeholder="Buscar..." 
            wire:model="search" 
        />

        <livewire:create-post />
    </div>

    @if ($posts->count())
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
                @foreach ($posts as $post)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $post->id }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $post->title }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $post->content }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <livewire:edit-post :post="$post" wire:key="{{ $post->id }}"/>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="px-6 py-4">
            <h2>No hay ninguna coincidencia con la busqueda solicitada 😢</h2>
        </div>
    @endif
</div>
