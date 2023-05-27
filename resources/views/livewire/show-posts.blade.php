<div>
    <div class="px-6 py-4">
        <input type="text" wire:model="search" placeholder="Buscar..." />
    </div>

    @if ($posts->count())
        <table class="table-fixed min-w-full divide-y divide-red-700 border">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>

                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                    </th>

                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Content
                    </th>

                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
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
                            <div class="text-sm text-gray-900">
                                Lorem ipsum dolor sit amet.
                            </div>
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
