document.addEventListener("DOMContentLoaded",()=>{const l=document.getElementById("refund-form-root");if(!l)return;const g=l.dataset.orderApiBase,m=document.getElementById("order_identity"),o=document.getElementById("find_order_btn"),s=document.getElementById("refund_message"),c=document.getElementById("order_summary"),r=document.getElementById("products_container"),b=document.getElementById("summary_identity"),p=document.getElementById("summary_date"),f=document.getElementById("summary_value"),i=new Intl.NumberFormat("pl-PL",{style:"currency",currency:"PLN"}),a=e=>String(e??"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;").replaceAll("'","&#039;"),d=(e,t="error")=>{s.classList.remove("hidden"),s.textContent=e,t==="error"?s.className="mt-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700":s.className="mt-4 rounded-lg bg-wdoz-primary-10 px-4 py-3 text-sm text-wdoz-primary-900"},v=()=>{s.classList.add("hidden"),s.textContent=""},u=e=>{o.disabled=e,o.textContent=e?"Sprawdzam...":"Sprawdź"},w=()=>{c.classList.add("hidden"),r.classList.add("hidden"),r.innerHTML=""},z=()=>{document.querySelectorAll("[data-refund-quantity]").forEach(e=>{e.addEventListener("change",()=>{const t=Number(e.dataset.maxQuantity);let n=Number(e.value);(!Number.isFinite(n)||n<1)&&(n=1),n>t&&(n=t),e.value=n}),e.addEventListener("input",()=>{const t=Number(e.dataset.maxQuantity),n=Number(e.value);Number.isFinite(n)&&n>t&&(e.value=t)})})},h=e=>{r.innerHTML="",e.forEach(t=>{const n=t.can_return?"":"opacity-60 grayscale",x=t.can_return?"":"disabled",$=t.can_return?"":`
                    <div class="mt-3 rounded-lg bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                        ${a(t.return_exclusion_reasons.join(" "))}
                    </div>
                `,E=t.image_url?`<img src="${a(t.image_url)}" alt="${a(t.name)}" class="h-24 w-24 rounded-xl object-contain">`:`
                    <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-wdoz-primary-10 text-xs font-semibold text-wdoz-primary">
                        Brak zdjęcia
                    </div>
                `,L=`
                <div class="rounded-2xl border border-wdoz-border bg-white p-5 shadow-sm ${n}">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center">
                        <div class="shrink-0">
                            ${E}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-semibold text-wdoz-text-gray">
                                ${a(t.name)}
                            </h3>

                            <div class="mt-3 grid gap-2 text-sm text-wdoz-text-gray sm:grid-cols-3">
                                <div>
                                    <span class="block text-xs text-gray-400">Cena za sztukę</span>
                                    <strong>${i.format(t.price_gross)}</strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-400">Kupiona ilość</span>
                                    <strong>${t.quantity}</strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-400">Wartość pozycji</span>
                                    <strong>${i.format(t.value_gross)}</strong>
                                </div>
                            </div>

                            ${$}
                        </div>

                        <div class="w-full shrink-0 md:w-52">
                            <label class="flex items-center gap-3 text-sm font-semibold text-wdoz-text-gray">
                                <input
                                    type="checkbox"
                                    name="products[${t.id}][selected]"
                                    value="1"
                                    class="h-5 w-5 rounded border-wdoz-input-border text-wdoz-primary focus:ring-wdoz-primary"
                                    ${x}
                                >
                                Zwrócić produkt
                            </label>

                            <label class="mt-4 block text-sm font-semibold text-wdoz-text-gray">
                                Ilość do zwrotu
                            </label>

                            <input
                                type="number"
                                min="1"
                                max="${t.quantity}"
                                value="1"
                                data-refund-quantity
                                data-max-quantity="${t.quantity}"
                                name="products[${t.id}][quantity]"
                                class="mt-2 h-11 w-full rounded-lg border border-wdoz-input-border px-3 text-sm text-wdoz-text-gray outline-none focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10"
                                ${x}
                            >
                        </div>
                    </div>
                </div>
            `;r.insertAdjacentHTML("beforeend",L)}),r.classList.remove("hidden"),z()},_=e=>{b.textContent=e.order.identity,p.textContent=e.order.order_date?`Data zamówienia: ${e.order.order_date}`:"",f.textContent=i.format(e.order.value_gross),c.classList.remove("hidden"),h(e.products)},y=async()=>{const e=m.value.trim();if(v(),w(),!e){d("Wpisz numer zamówienia.");return}u(!0);try{const t=await fetch(`${g}/${encodeURIComponent(e)}`,{headers:{Accept:"application/json"}}),n=await t.json();if(!t.ok){d(n.message||"Nie udało się pobrać zamówienia.");return}d("Zamówienie zostało znalezione.","success"),_(n)}catch{d("Wystąpił błąd podczas pobierania zamówienia.")}finally{u(!1)}};o.addEventListener("click",y),m.addEventListener("keydown",e=>{e.key==="Enter"&&(e.preventDefault(),y())})});
