@php
    $multiple = isset($area['multiple']) && $area['multiple'];
    $currentValue = null;
    $currentImages = [];

    if ($editItem != null && isset($editItem[0]->{$area['field']})) {
        $currentValue = $editItem[0]->{$area['field']};

        if ($currentValue != null && $currentValue != '') {
            if ($multiple) {
                $decoded = json_decode($currentValue, true);
                $currentImages = is_array($decoded) ? $decoded : [];
            } else {
                $currentImages = [$currentValue];
            }
        }
    }

    $currentImages = array_values(array_unique($currentImages));

    if (!$multiple && count($currentImages) > 1) {
        $currentImages = [reset($currentImages)];
    }
@endphp

<div class="edit-area-container cms-image-area" data-field="{{ $area['field'] }}">
    <label class="flex flex-col gap-1">
        <span>{{ $area['name'] }}</span>

        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
            <span class="text-xs text-gray-500">{{ $area['info'] }}</span>
        @endif
    </label>

    <div class="w-full max-w-5xl rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        @if(count($currentImages) > 0)
            <div class="{{ $multiple ? 'grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3' : 'grid grid-cols-1 max-w-sm gap-4' }}">
                @foreach($currentImages as $imagePath)
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 p-3" data-image-path="{{ $imagePath }}">
                        <div class="aspect-[16/10] overflow-hidden rounded-lg border border-gray-200 bg-white">
                            <img
                                src="{{ $imagePath }}"
                                alt=""
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <div class="mt-3 flex items-center justify-start">
                            @if($multiple)
                                <button
                                    type="button"
                                    class="cms-remove-current-multi-image rounded-md bg-red-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-600"
                                    data-field="{{ $area['field'] }}"
                                    data-image="{{ $imagePath }}"
                                >
                                    Usuń zdjęcie
                                </button>
                            @else
                                <button
                                    type="button"
                                    class="cms-remove-current-single-image rounded-md bg-red-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-600"
                                    data-field="{{ $area['field'] }}"
                                >
                                    Usuń zdjęcie
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="{{ count($currentImages) > 0 ? 'mt-4' : '' }}">
            <input
                type="file"
                name="{{ $area['field'] }}"
                class="cms-edit-area-file block w-full max-w-md rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200"
                data-field="{{ $area['field'] }}"
                @if($multiple) multiple @endif
                accept=".jpg,.jpeg,.png,.webp"
            >
        </div>
    </div>

    @if(!$multiple)
        <input
            type="hidden"
            name="{{ $area['field'] }}__remove"
            value="0"
            class="cms-extra-area cms-single-image-remove-input"
        >
    @endif

    <div class="cms-removed-images-holder"></div>
</div>
