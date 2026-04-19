<div class='edit-area-container'>
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
            <span class="area-info">{{ $area['info'] }}</span>
        @endif
    </label>

    <input
        class="cms-edit-area cms-seo-url-input"
        type="text"
        value="@if ($editItem != null){{ $editItem[0]->{$area['field']} }}@endif"
        name="{{ $area['field'] }}"
        data-source-field="title"
    >
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const idInput = document.getElementById('edit-elem-id');
        const seoInput = document.querySelector('.cms-seo-url-input');
        const titleInput = document.querySelector('.cms-edit-area[name="title"]');

        if (!seoInput || !titleInput || !idInput) {
            return;
        }

        const isNewRecord = !idInput.value || idInput.value === '';

        if (!isNewRecord) {
            return;
        }

        let autoSyncEnabled = seoInput.value.trim() === '';

        function replacePolishChars(value) {
            const map = {
                'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n',
                'ó': 'o', 'ś': 's', 'ż': 'z', 'ź': 'z',
                'Ą': 'a', 'Ć': 'c', 'Ę': 'e', 'Ł': 'l', 'Ń': 'n',
                'Ó': 'o', 'Ś': 's', 'Ż': 'z', 'Ź': 'z'
            };

            return value.split('').map(char => map[char] || char).join('');
        }

        function slugify(value) {
            return replacePolishChars(value)
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s\-_]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/_+/g, '_')
                .replace(/^[-_]+|[-_]+$/g, '');
        }

        titleInput.addEventListener('input', function () {
            if (!autoSyncEnabled) {
                return;
            }

            seoInput.value = slugify(titleInput.value);
        });

        seoInput.addEventListener('input', function () {
            const currentValue = seoInput.value.trim();
            const autoValueFromTitle = slugify(titleInput.value);

            if (currentValue === '') {
                autoSyncEnabled = true;
                return;
            }

            autoSyncEnabled = currentValue === autoValueFromTitle;
        });
    });
</script>
