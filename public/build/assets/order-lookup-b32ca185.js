document.addEventListener("DOMContentLoaded",()=>{const l=document.getElementById("refund-form-root");if(!l)return;const $=l.dataset.orderApiBase,x=document.getElementById("order_identity"),c=document.getElementById("find_order_btn"),r=document.getElementById("refund_message"),b=document.getElementById("order_summary"),s=document.getElementById("products_container"),g=document.getElementById("summary_identity"),f=document.getElementById("summary_date"),p=document.getElementById("summary_value"),u=document.getElementById("order_id"),m=document.getElementById("order_identity_hidden"),v=document.getElementById("customer_fields"),w=document.getElementById("submit_container"),y=new Intl.NumberFormat("pl-PL",{style:"currency",currency:"PLN"}),a=e=>String(e??"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;").replaceAll("'","&#039;"),d=(e,t="error")=>{r.classList.remove("hidden"),r.textContent=e,t==="error"?r.className="mt-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700":r.className="mt-4 rounded-lg bg-wdoz-primary-10 px-4 py-3 text-sm text-wdoz-primary-900"},h=()=>{r.classList.add("hidden"),r.textContent=""},z=e=>{c.disabled=e,c.textContent=e?"Sprawdzam...":"Sprawdź"},k=()=>{b.classList.add("hidden"),s.classList.add("hidden"),v.classList.add("hidden"),w.classList.add("hidden"),s.innerHTML="",u.value="",m.value="",g.textContent="",f.textContent="",p.textContent=""},_=e=>{const t=Number(e.dataset.maxQuantity);let n=Number(e.value);(!Number.isFinite(n)||n<1)&&(n=1),n>t&&(n=t),e.value=n},B=()=>{document.querySelectorAll("[data-refund-quantity]").forEach(e=>{e.addEventListener("change",()=>{_(e)}),e.addEventListener("input",()=>{const t=Number(e.dataset.maxQuantity),n=Number(e.value);Number.isFinite(n)&&n>t&&(e.value=t)})})},A=()=>{document.querySelectorAll("[data-refund-checkbox]").forEach(e=>{const t=e.dataset.orderProductId,n=document.querySelector(`[data-refund-quantity="${t}"]`);if(!n)return;const o=()=>{if(e.disabled){n.disabled=!0;return}n.disabled=!e.checked};e.addEventListener("change",o),o()})},C=e=>{s.innerHTML="",e.forEach(t=>{const n=Number(t.quantity)||0,o=Number(t.price_gross)||0,j=Number(t.value_gross)||0,i=!!t.can_return,S=i?"":"opacity-60 grayscale",I=i?"":"disabled",H=i?"checked":"",L=Array.isArray(t.return_exclusion_reasons)?t.return_exclusion_reasons:[],P=L.length>0?L.join(" "):"Ten produkt nie podlega zwrotowi.",D=i?"":`
                    <div class="mt-3 rounded-lg bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                        ${a(P)}
                    </div>
                `,M=t.image_url?`
                    <img
                        src="${a(t.image_url)}"
                        alt="${a(t.name)}"
                        class="h-24 w-24 rounded-xl object-contain"
                    >
                `:`
                    <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-wdoz-primary-10 text-xs font-semibold text-wdoz-primary">
                        Brak zdjęcia
                    </div>
                `,Q=`
                <div class="rounded-2xl border border-wdoz-border bg-white p-5 shadow-sm ${S}">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center">
                        <div class="shrink-0">
                            ${M}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-semibold text-wdoz-text-gray">
                                ${a(t.name)}
                            </h3>

                            <div class="mt-3 grid gap-2 text-sm text-wdoz-text-gray sm:grid-cols-3">
                                <div>
                                    <span class="block text-xs text-gray-400">Cena za sztukę</span>
                                    <strong>${y.format(o)}</strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-400">Kupiona ilość</span>
                                    <strong>${n}</strong>
                                </div>

                                <div>
                                    <span class="block text-xs text-gray-400">Wartość pozycji</span>
                                    <strong>${y.format(j)}</strong>
                                </div>
                            </div>

                            ${D}
                        </div>

                        <div class="w-full shrink-0 md:w-52">
                            <label class="flex items-center gap-3 text-sm font-semibold text-wdoz-text-gray">
                                <input
                                    type="checkbox"
                                    name="products[${t.id}][selected]"
                                    value="1"
                                    data-refund-checkbox
                                    data-order-product-id="${t.id}"
                                    class="h-5 w-5 rounded border-wdoz-input-border text-wdoz-primary focus:ring-wdoz-primary"
                                    ${H}
                                    ${I}
                                >
                                Zwrócić produkt
                            </label>

                            <label class="mt-4 block text-sm font-semibold text-wdoz-text-gray">
                                Ilość do zwrotu
                            </label>

                            <input
                                type="number"
                                min="1"
                                max="${n}"
                                value="1"
                                data-refund-quantity="${t.id}"
                                data-max-quantity="${n}"
                                name="products[${t.id}][quantity]"
                                class="mt-2 h-11 w-full rounded-lg border border-wdoz-input-border px-3 text-sm text-wdoz-text-gray outline-none focus:border-wdoz-primary focus:ring-2 focus:ring-wdoz-primary-10 disabled:bg-gray-100 disabled:text-gray-400"
                                ${I}
                            >
                        </div>
                    </div>
                </div>
            `;s.insertAdjacentHTML("beforeend",Q)}),s.classList.remove("hidden"),B(),A()},N=e=>{u.value=e.order.id,m.value=e.order.identity,g.textContent=e.order.identity,f.textContent=e.order.order_date?`Data zamówienia: ${e.order.order_date}`:"",p.textContent=y.format(Number(e.order.value_gross)||0),b.classList.remove("hidden"),v.classList.remove("hidden"),w.classList.remove("hidden"),C(e.products)},E=async()=>{const e=x.value.trim();if(h(),k(),!e){d("Wpisz numer zamówienia.");return}z(!0);try{const t=await fetch(`${$}/${encodeURIComponent(e)}`,{headers:{Accept:"application/json"}}),n=await t.json();if(!t.ok){d(n.message||"Nie udało się pobrać zamówienia.");return}d("Zamówienie zostało znalezione.","success"),N(n)}catch{d("Wystąpił błąd podczas pobierania zamówienia.")}finally{z(!1)}},q=()=>Array.from(document.querySelectorAll("[data-refund-checkbox]")).some(e=>e.checked&&!e.disabled);l.addEventListener("submit",e=>{if(h(),!u.value||!m.value){e.preventDefault(),d("Najpierw wyszukaj zamówienie.");return}if(!q()){e.preventDefault(),d("Wybierz przynajmniej jeden produkt do zwrotu.");return}document.querySelectorAll("[data-refund-quantity]").forEach(t=>{t.disabled||_(t)})}),c.addEventListener("click",E),x.addEventListener("keydown",e=>{e.key==="Enter"&&(e.preventDefault(),E())})});
