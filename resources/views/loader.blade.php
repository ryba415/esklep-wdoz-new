<div id="loader-container" class="fixed bg-opacity-20 bg-black w-[200vw] h-[200vh] z-50 hidden opacity-0 top-0">
    <div class="w-[120px] h-[120px] inline-block absolute top-[calc(50vh-60px)] left-[calc(50vw-60px)]">
        <div class="bg-wdoz-primary inline-block w-[33.3333%] h-[33.3333%] top-0 left-[33.333%] absolute loader-square loader-square-1"></div>
        <div class="bg-wdoz-primary inline-block w-[33.3333%] h-[33.3333%] top-[33.3333%] left-[66.6666%] absolute loader-square loader-square-2"></div>
        <div class="bg-wdoz-primary inline-block w-[33.3333%] h-[33.3333%] top-[66.6666%] left-[33.3333%] absolute loader-square loader-square-3"></div>
        <div class="bg-wdoz-primary inline-block w-[33.3333%] h-[33.3333%] top-[33.3333%] left-[-3px] absolute loader-square loader-square-4"></div>
        <div class="bg-wdoz-primary inline-block w-[33.3333%] h-[33.3333%] top-[33.3333%] left-[33.3333%] absolute loader-square loader-square-5"></div>
    </div>
</div>

<script>
    window.showGlobalLoader = function showGlobalLoader(){
        let container = document.getElementById('loader-container');
        
        container.style.display = 'block';
        setTimeout(() => {
            container.style.opacity = "1";
        }, "100");
    }
    
    window.hideGlobalLoader = function hideGlobalLoader(){
        let container = document.getElementById('loader-container');
        container.style.opacity = "0";
        
        setTimeout(() => {
            container.style.display = 'none';
        }, "450");
    }
</script>