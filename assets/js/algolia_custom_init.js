(function(){if(!algoliasearch||!instantsearch)throw new Error("not found assets from the algolia.");const applicationID=algoliaShopify.config.app_id,searchAPIKey=algoliaShopify.config.search_api_key,indexName=algoliaShopify.config.index_prefix+"products",collectionIndexName=algoliaShopify.config.index_prefix+"collections",productPerPage=algoliaShopify.config.products_autocomplete_hits_per_page,collectionPerPage=algoliaShopify.config.collections_autocomplete_hits_per_page,algoliaClient=algoliasearch(applicationID,searchAPIKey),searchClient={...algoliaClient,search(requests){return requests.every(({params})=>!params.query)?Promise.resolve({results:requests.map(()=>({hits:[],nbHits:0,nbPages:0,page:0,processingTimeMS:0,hitsPerPage:0,exhaustiveNBHits:!1,query:"",params:""}))}):algoliaClient.search(requests)}},search=instantsearch({indexName,searchClient}),customSearchBoxWidget=instantsearch.connectors.connectSearchBox((renderOptions,isFirstRender)=>{const{indices,currentRefinement,refine,widgetParams}=renderOptions,desktopInput=document.querySelector(widgetParams.desktopContainer),mobileInput=document.querySelector(widgetParams.mobileContainer),result=document.querySelector(widgetParams.resultContainer),headerContainer=document.querySelector(".site-header"),searchContainer=document.querySelector(".site-header__search-container");if(!desktopInput||!mobileInput||!result||!searchContainer||!headerContainer)return;const handleInputEvent=event=>{const target=event.currentTarget,targetClass=target.getAttribute("class");result.dataset.algoliaResultShow=String(target.value.length>0),refine(target.value),/desktop/.test(targetClass)&&(mobileInput.value=target.value),/mobile/.test(targetClass)&&(desktopInput.value=target.value)},handleEnterKeypress=event=>{(event.keyCode||event.charCode||0)==13&&(window.location.href="/search?type=product&q="+desktopInput.value)};isFirstRender&&(mobileInput.addEventListener("input",handleInputEvent),desktopInput.addEventListener("input",handleInputEvent),desktopInput.addEventListener("keypress",handleEnterKeypress),new MutationObserver(records=>{result.dataset.algoliaResultShow=String(searchContainer.classList.contains("is-active")&&desktopInput.value.length>0&&mobileInput.value.length>0)}).observe(searchContainer,{attributes:!0}),new MutationObserver(records=>{const bool=headerContainer.classList.contains("site-header--opening");result.dataset.algoliaResultSticky=bool,result.style.top=bool?`${headerContainer.clientHeight}px`:"auto"}).observe(headerContainer,{attributes:!0}))});document.addEventListener("DOMContentLoaded",domReadyEvent=>{search.addWidgets([customSearchBoxWidget({desktopContainer:".algolia-input__desktop",mobileContainer:".algolia-input__mobile",resultContainer:".algolia-result"}),instantsearch.widgets.hits({container:".algolia-result__products",templates:{item:(hit,{html,components})=>html`
              <a class="algolia-result__product"
                href="/products/${hit.handle}">
                <div class="algolia-result__product-thumbnail"
                  style="background-image: url(${hit.image});"></div>
                <div class="algolia-result__product-content">
                  <h5>${hit.title}</h5>
                  ${hit.variant_title!="Default Title"&&html`<h6>${hit.variant_title}</h6>`}
                  <p>￥${hit.price.toLocaleString()}</p>
                </div>
              </a>
            `},transformItems:items=>items.filter(item=>!item.tags.includes("\u30AA\u30D7\u30B7\u30E7\u30F3")).splice(0,productPerPage)}),instantsearch.widgets.index({indexName:collectionIndexName}).addWidgets([instantsearch.widgets.hits({container:".algolia-result__collections",templates:{item:(hit,{html,components})=>{const brand=/piece/.test(hit.template_suffix)?"Piece of sign":/laosi/.test(hit.template_suffix)?"Laosi":"";return html`
                <a class="algolia-result__collection"
                  href="/collections/${hit.handle}">
                  <div class="algolia-result__collection-thumbnail"
                    style="background-image: url(${hit.image});"></div>
                  <div class="algolia-result__collection-content">
                    ${brand&&html`<h6>${brand}</h6>`}
                    <h5>${hit.title.replace(/<[^>]+>/g,"")}</h5>
                  </div>
                </a>
              `}},transformItems:items=>items.splice(0,collectionPerPage)})])]),search.start()})})();
//# sourceMappingURL=/cdn/shop/t/10/assets/algolia_custom_init.js.map?v=88155644588623171991687309676
