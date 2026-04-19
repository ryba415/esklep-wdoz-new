@php
    $selectedOptions = $area['selectedOptions'] ?? [];
    $selectedOptions = is_array($selectedOptions) ? $selectedOptions : [];
    $containerId = 'multi-select-' . $area['field'] . '-' . uniqid();
@endphp

<div class='edit-area-container edit-area-select-with-search-container' id="{{ $containerId }}">
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
            <span class="area-info">{{ $area['info'] }}</span>
        @endif
    </label>

    <div class='search-container'>
        <input
            type="text"
            autocomplete="off"
            class="cms-filter-input-multiple"
            placeholder="wyszukaj..."
        >

        <select
            class="cms-edit-area"
            name="{{ $area['field'] }}"
            size="12"
            multiple
            autocomplete="off"
            style="min-height: 260px;"
        >
            @foreach ($area['options'] as $key => $option)
                <option
                    value="{{ $key }}"
                    style="padding: 4px;"
                    @if(in_array((int)$key, array_map('intval', $selectedOptions), true)) selected @endif
                >
                    {{ $option }}
                </option>
            @endforeach
        </select>
    </div>

    <small style="display:block; margin-top:8px; color:#666;">
        Możesz zaznaczyć wiele produktów. Przytrzymaj CTRL lub CMD podczas klikania.
    </small>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById(@json($containerId));
        if (!container) {
            return;
        }

        const input = container.querySelector('.cms-filter-input-multiple');
        const select = container.querySelector('select');

        if (!input || !select) {
            return;
        }

        input.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();
            const options = Array.from(select.options);

            options.forEach(option => {
                const optionText = option.text.toLowerCase();
                const isMatch = optionText.includes(searchText);

                option.hidden = !isMatch;
                option.style.display = isMatch ? '' : 'none';
            });
        });
    });
</script>
