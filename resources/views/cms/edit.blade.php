@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <div class="all-content-big">
        <h1>nazwa</h1>
        <div id="sucess-info-area"></div>
        <div id="fail-info-area">
            <ul></ul>
        </div>
        <div id="cms-edit-container">
            <input type="hidden" value="{{$id}}" name="id" id="edit-elem-id" class="cms-edit-area">
            @foreach ($areas as $area)
                @if($area['editable'])
                    @include('cms.editAreas.' . $area['type'] ,['area' => $area, 'editItem' => $editItem])
                @endif
            @endforeach

            {!! $extraView !!}
            <div class="cms-save-areas-container save-all-areas-container-fixed">
                <button id="save-all-areas" class="standard-button standard-big-button-green">Zapisz</button>
            </div>
        </div>


    </div>

    <script>
        document.getElementById('save-all-areas').addEventListener("click", (event) => {
            event.preventDefault();
            saveDate();
        });

        bindImageRemoveButtons();

        function bindImageRemoveButtons() {
            const removeSingleButtons = document.querySelectorAll('.cms-remove-current-single-image');
            for (let i = 0; i < removeSingleButtons.length; i++) {
                removeSingleButtons[i].addEventListener('click', function() {
                    const imageArea = this.closest('.cms-image-area');
                    const removeInput = imageArea.querySelector('.cms-single-image-remove-input');

                    if (removeInput) {
                        removeInput.value = '1';
                    }

                    const imageCard = this.closest('[data-image-path]');
                    if (imageCard) {
                        imageCard.remove();
                    }
                });
            }

            const removeMultiButtons = document.querySelectorAll('.cms-remove-current-multi-image');
            for (let i = 0; i < removeMultiButtons.length; i++) {
                removeMultiButtons[i].addEventListener('click', function() {
                    const field = this.getAttribute('data-field');
                    const image = this.getAttribute('data-image');
                    const imageArea = this.closest('.cms-image-area');
                    const removedHolder = imageArea.querySelector('.cms-removed-images-holder');

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = field + '__removed[]';
                    hiddenInput.value = image;
                    hiddenInput.classList.add('cms-extra-area');

                    removedHolder.appendChild(hiddenInput);

                    const imageCard = this.closest('[data-image-path]');
                    if (imageCard) {
                        imageCard.remove();
                    }
                });
            }

            const fileInputs = document.querySelectorAll('.cms-edit-area-file');
            for (let i = 0; i < fileInputs.length; i++) {
                fileInputs[i].addEventListener('change', function() {
                    const imageArea = this.closest('.cms-image-area');
                    const removeInput = imageArea.querySelector('.cms-single-image-remove-input');

                    if (removeInput && this.files.length > 0) {
                        removeInput.value = '0';
                    }
                });
            }
        }

        async function saveDate() {
            let formData = await prepareFormData();
            sendSave(formData);
        }

        async function prepareFormData() {
            let formData = new FormData();

            let inputs = document.getElementById('cms-edit-container').querySelectorAll('.cms-edit-area');
            for (let i = 0; i < inputs.length; i++) {
                let fieldName = inputs[i].getAttribute('name');

                if (!fieldName) {
                    continue;
                }

                if (inputs[i].tagName === 'SELECT' && inputs[i].multiple) {
                    let selectedOptions = Array.from(inputs[i].selectedOptions);

                    for (let j = 0; j < selectedOptions.length; j++) {
                        formData.append(fieldName + '[]', selectedOptions[j].value);
                    }

                    continue;
                }

                formData.append(fieldName + '[area]', fieldName);
                formData.append(fieldName + '[value]', inputs[i].value);
            }

            let extraInputs = document.getElementById('cms-edit-container').querySelectorAll('.cms-extra-area');
            for (let i = 0; i < extraInputs.length; i++) {
                formData.append(extraInputs[i].name, extraInputs[i].value);
            }

            let fileInputs = document.getElementById('cms-edit-container').querySelectorAll('.cms-edit-area-file');
            for (let i = 0; i < fileInputs.length; i++) {
                let field = fileInputs[i].getAttribute('data-field');

                if (fileInputs[i].multiple) {
                    for (let j = 0; j < fileInputs[i].files.length; j++) {
                        formData.append('cms_files[' + field + '][]', fileInputs[i].files[j]);
                    }
                } else {
                    if (fileInputs[i].files.length > 0) {
                        formData.append('cms_files[' + field + ']', fileInputs[i].files[0]);
                    }
                }
            }

            if (typeof ownSaveFunction === 'function') {
                const result = ownSaveFunction();

                for (const key in result) {
                    if (Array.isArray(result[key])) {
                        for (let i = 0; i < result[key].length; i++) {
                            formData.append(key + '[]', result[key][i]);
                        }
                    } else {
                        formData.append(key, result[key]);
                    }
                }
            }

            return formData;
        }

        async function sendSave(formData) {
            fetch("/cms-universal-save/{{$objectName}}", {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                method: 'POST',
                body: formData
            })
                .then((response) => response.json())
                .then(res => {
                    let sucessArea = document.getElementById('sucess-info-area');
                    let failArea = document.getElementById('fail-info-area');

                    if (res.status) {
                        document.getElementById('edit-elem-id').value = res.editElemId;
                        failArea.style.display = 'none';
                        sucessArea.style.display = 'block';
                        sucessArea.innerHTML = res.sucessSaveInfoText;

                        sucessArea.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                            inline: 'center'
                        });
                    } else {
                        let failAreaUl = failArea.querySelector('ul');
                        sucessArea.innerHTML = '';
                        failAreaUl.innerHTML = '';
                        failArea.style.display = 'block';
                        sucessArea.style.display = 'none';

                        if (typeof res.errors != 'undefined') {
                            for (let i = 0; i < res.errors.length; i++) {
                                let li = document.createElement('li');
                                li.innerHTML = res.errors[i];
                                failAreaUl.append(li);
                            }
                        } else {
                            let li = document.createElement('li');
                            li.innerHTML = 'Wystąpił nieoczekiwany błąd podczas próby zapisu';
                            failAreaUl.append(li);
                        }

                        failArea.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                            inline: 'center'
                        });

                        if (res.userUnloged) {
                            window.location.replace("/login");
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endsection
