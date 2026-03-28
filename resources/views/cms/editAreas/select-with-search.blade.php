
<div class='edit-area-container edit-area-select-with-search-container' >
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
        <span class="area-info">{{$area['info']}}</span>
        @endif
    </label>

    <div class='search-container'>
    <input type="text" 
           autocomplete="off"
           class="cms-filter-input" 
           placeholder="wyszukaj..." >

    <select class="cms-edit-area" 
            name="{{ $area['field'] }}" 
            size="8" 
            autocomplete="off" >
        @foreach ($area['options'] as $key => $option)
            <option value="{{$key}}" style="padding: 4px;" @if ($editItem != null && $editItem[0]->{$area['field']} == $key ) selected @endif>{{$option}}</option>
        @endforeach
    </select>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterInputs = document.querySelectorAll('.cms-filter-input');

    filterInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const select = this.parentElement.querySelector('.cms-edit-area');
            const options = Array.from(select.options);

            options.forEach(option => {
                const optionText = option.text.toLowerCase();
                const isMatch = optionText.includes(searchText);
                
                // Używamy atrybutu hidden oraz stylu display, aby zapewnić kompatybilność
                option.hidden = !isMatch;
                option.style.display = isMatch ? '' : 'none';
            });

            // Opcjonalnie: Jeśli po filtrowaniu nic nie pasuje, możesz dodać wizualną informację
            const visibleOptions = options.filter(opt => !opt.hidden);
            if (visibleOptions.length === 0) {
                // Tu można dodać logikę "Brak wyników"
            }
        });

        // Dodatek: kliknięcie opcji może czyścić filtr lub robić coś innego
        const select = input.parentElement.querySelector('.cms-edit-area');
        select.addEventListener('change', function() {
            console.log('Wybrano: ' + this.value);
        });
    });
});
</script>