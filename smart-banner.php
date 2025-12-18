<div id="smartBanner"
     class="hidden fixed top-0 left-0 right-0 z-[9998]
            bg-[#0097D7] text-white
            px-4 py-3 flex items-center justify-between">

  <div class="flex items-center gap-3">
    <span class="text-xl">📱</span>
    <div>
      <div class="font-semibold leading-tight">Kav+ App</div>
      <div class="text-xs opacity-90">Open faster in the app</div>
    </div>
  </div>

  <div class="flex items-center gap-3">
    <button onclick="openAppFromBanner()"
            class="bg-white text-[#0097D7]
                   px-4 py-1.5 rounded-full text-sm font-semibold">
      Open
    </button>
    <button onclick="closeSmartBanner()" class="text-xl leading-none">
      ✕
    </button>
  </div>
</div>

<script>
(function(){
  const ua = navigator.userAgent.toLowerCase();
  const isMobile = /android|iphone|ipad/.test(ua);

  if (!isMobile) return;

  if (localStorage.getItem('hideSmartBanner')) return;

  document.getElementById('smartBanner').classList.remove('hidden');
})();

function closeSmartBanner(){
  document.getElementById('smartBanner').style.display='none';
  localStorage.setItem('hideSmartBanner','1');
}

/* OPEN APP OR FALLBACK */
function openAppFromBanner(){
  const ua = navigator.userAgent.toLowerCase();

  if(ua.includes('android')){
    window.location.href =
      "intent://booking#Intent;scheme=kavplus;package=com.kavplus.app;end";
  }else if(ua.includes('iphone') || ua.includes('ipad')){
    window.location.href = "https://kavplus.com/app/booking";
  }else{
    openAppModal();
  }
}
</script>
