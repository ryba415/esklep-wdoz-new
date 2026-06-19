document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('refund-form-root');

    if (!root) {
        return;
    }

    const apiBase = root.dataset.orderApiBase;

    const orderInput = document.getElementById('order_identity');
    const findButton = document.getElementById('find_order_btn');
    const messageBox = document.getElementById('refund_message');

    const orderSummary = document.getElementById('order_summary');
    const productsContainer = document.getElementById('products_container');

    const summaryIdentity = document.getElementById('summary_identity');
    const summaryDate = document.getElementById('summary_date');
    const summaryValue = document.getElementById('summary_value');

    const orderIdInput = document.getElementById('order_id');
    const orderIdentityHidden = document.getElementById('order_identity_hidden');

    const customerFields = document.getElementById('customer_fields');
    const submitContainer = document.getElementById('submit_container');

    const moneyFormatter = new Intl.NumberFormat('pl-PL', {
        style: 'currency',
        currency: 'PLN',
    });

    const escapeHtml = (value) => {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    };

    const showMessage = (text, type = 'error') => {
        messageBox.classList.remove('hidden');
        messageBox.textContent = text;

        if (type === 'error') {
            messageBox.className = 'mt-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700';
        } else {
            messageBox.className = 'mt-4 rounded-lg bg-wdoz-primary-10 px-4 py-3 text-sm text-wdoz-primary-900';
        }
    };

    const hideMessage = () => {
        messageBox.classList.add('hidden');
        messageBox.textContent = '';
    };

    const setLoading = (isLoading) => {
        findButton.disabled = isLoading;
        findButton.textContent = isLoading ? 'Sprawdzam...' : 'Sprawdź';
    };

    const resetResult = () => {
        orderSummary.classList.add('hidden');
        productsContainer.classList.add('hidden');
        customerFields.classList.add('hidden');
        submitContainer.classList.add('hidden');

        productsContainer.innerHTML = '';

        orderIdInput.value = '';
        orderIdentityHidden.value = '';

        summaryIdentity.textContent = '';
        summaryDate.textContent = '';
        summaryValue.textContent = '';
    };

    const clampQuantityValue = (input) => {
        const max = Number(input.dataset.maxQuantity);
        let value = Number(input.value);

        if (!Number.isFinite(value) || value < 1) {
            value = 1;
        }

        if (value > max) {
            value = max;
        }

        input.value = value;
    };

    const bindQuantityValidation = () => {
        document.querySelectorAll('[data-refund-quantity]').forEach((input) => {
            input.addEventListener('change', () => {
                clampQuantityValue(input);
            });

            input.addEventListener('input', () => {
                const max = Number(input.dataset.maxQuantity);
                const value = Number(input.value);

                if (Number.isFinite(value) && value > max) {
                    input.value = max;
                }
            });
        });
    };

    const bindCheckboxQuantityState = () => {
        document.querySelectorAll('[data-refund-checkbox]').forEach((checkbox) => {
            const orderProductId = checkbox.dataset.orderProductId;
            const quantityInput = document.querySelector(`[data-refund-quantity="${orderProductId}"]`);

            if (!quantityInput) {
                return;
            }

            const syncState = () => {
                if (checkbox.disabled) {
                    quantityInput.disabled = true;
                    return;
                }

                quantityInput.disabled = !checkbox.checked;
            };

            checkbox.addEventListener('change', syncState);

            syncState();
        });
    };

    const renderProducts = (products) => {
        productsContainer.innerHTML = '';

        products.forEach((product) => {
            const productQuantity = Number(product.quantity) || 0;
            const productPriceGross = Number(product.price_gross) || 0;
            const productValueGross = Number(product.value_gross) || 0;

            const isReturnable = Boolean(product.can_return);

            const disabledClass = isReturnable
                ? ''
                : 'opacity-60 grayscale';

            const disabledAttributes = isReturnable
                ? ''
                : 'disabled';

            const checkedAttribute = isReturnable
                ? 'checked'
                : '';

            const reasons = Array.isArray(product.return_exclusion_reasons)
                ? product.return_exclusion_reasons
                : [];

            const exclusionText = reasons.length > 0
                ? reasons.join(' ')
                : 'Ten produkt nie podlega zwrotowi.';

            const exclusionHtml = !isReturnable
                ? `
                    <div class="mt-3 rounded-lg bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                        ${escapeHtml(exclusionText)}
                    </div>
                `
                : '';

            const imageHtml = product.image_url
                ? `
                    <img
                        src="${escapeHtml(product.image_url)}"
                        alt="${escapeHtml(product.name)}"
                        class="h-24 w-24 rounded-xl object-contain"
                    >
                `
                : `
                    <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-wdoz-primary-10 text-xs font-semibold text-wdoz-primary">
                        Brak zdjęcia
                    </div>
                `;

            const html = `
                <div class="rounded-2xl border border-wdoz-border bg-white p-5 shadow-sm ${disabledClass}">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center">
                        <div class="shrink-0">
                            ${imageHtml}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-semibold text-wdoz-text-gray">
                                ${escapeHtml(product.name)}
                            </h3>

                            <div class="mt-3 grid gap-2 text-sm text-wdoz-text-gray sm:grid-cols-3">
                                <div>
                                    <span class="block text-xs text-gray-400">Cena za sztukę</span>
                                    <strong>${moneyFormatter.format(productPriceGross)}</strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-400">Kupiona ilość</span>
                                    <strong>${productQuantity}</strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-400">Wartość pozycji</span>
                                    <strong>${moneyFormatter.format(productValueGross)}</strong>
                                </div>
                            </div>

                            ${exclusionHtml}
                        </div>

                        <div class="w-full shrink-0 md:w-52">
                            <label class="flex items-center gap-3 text-sm font-semibold text-wdoz-text-gray">
                                <input
                                    type="checkbox"
                                    name="products[${product.id}][selected]"
                                    value="1"
                                    data-refund-checkbox
                                    data-order-product-id="${product.id}"
                                    class="h-5 w-5 rounded border-wdoz-input-border text-wdoz-primary focus:ring-wdoz-primary"
                                    ${checkedAttribute}
                                    ${disabledAttributes}
                                >
                                Zwrócić produkt
                            </label>

                            <label class="mt-4 block text-sm font-semibold text-wdoz-text-gray">
                                Ilość do zwrotu
                            </label>

                            <input
                                type="number"
                                min="1"
                                max="${productQuantity}"
                                value="1"
                                data-refund-quantity="${product.id}"
                                data-max-quantity="${productQuantity}"
                                name="products[${product.id}][quantity]"
                                class="mt-2 h-11 w-full rounded-lg border border-wdoz-input-border px-3 text-sm text-wdoz-text-gray outline-none focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10 disabled:bg-gray-100 disabled:text-gray-400"
                                ${disabledAttributes}
                            >
                        </div>
                    </div>
                </div>
            `;

            productsContainer.insertAdjacentHTML('beforeend', html);
        });

        productsContainer.classList.remove('hidden');

        bindQuantityValidation();
        bindCheckboxQuantityState();
    };

    const renderOrder = (data) => {
        orderIdInput.value = data.order.id;
        orderIdentityHidden.value = data.order.identity;

        summaryIdentity.textContent = data.order.identity;

        summaryDate.textContent = data.order.order_date
            ? `Data zamówienia: ${data.order.order_date}`
            : '';

        summaryValue.textContent = moneyFormatter.format(Number(data.order.value_gross) || 0);

        orderSummary.classList.remove('hidden');
        customerFields.classList.remove('hidden');
        submitContainer.classList.remove('hidden');

        renderProducts(data.products);
    };

    const findOrder = async () => {
        const identity = orderInput.value.trim();

        hideMessage();
        resetResult();

        if (!identity) {
            showMessage('Wpisz numer zamówienia.');
            return;
        }

        setLoading(true);

        try {
            const response = await fetch(`${apiBase}/${encodeURIComponent(identity)}`, {
                headers: {
                    Accept: 'application/json',
                },
            });

            const data = await response.json();

            if (!response.ok) {
                showMessage(data.message || 'Nie udało się pobrać zamówienia.');
                return;
            }

            showMessage('Zamówienie zostało znalezione.', 'success');
            renderOrder(data);
        } catch (error) {
            showMessage('Wystąpił błąd podczas pobierania zamówienia.');
        } finally {
            setLoading(false);
        }
    };

    const hasSelectedRefundProducts = () => {
        return Array.from(document.querySelectorAll('[data-refund-checkbox]'))
            .some((checkbox) => checkbox.checked && !checkbox.disabled);
    };

    root.addEventListener('submit', (event) => {
        hideMessage();

        if (!orderIdInput.value || !orderIdentityHidden.value) {
            event.preventDefault();
            showMessage('Najpierw wyszukaj zamówienie.');
            return;
        }

        if (!hasSelectedRefundProducts()) {
            event.preventDefault();
            showMessage('Wybierz przynajmniej jeden produkt do zwrotu.');
            return;
        }

        document.querySelectorAll('[data-refund-quantity]').forEach((input) => {
            if (!input.disabled) {
                clampQuantityValue(input);
            }
        });
    });

    findButton.addEventListener('click', findOrder);

    orderInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            findOrder();
        }
    });
});
