<?php if (session_status()===PHP_SESSION_NONE) session_start(); ?>
<div id="appModal"
     class="fixed inset-0 bg-black/60 hidden z-[9999]
            flex items-center justify-center">

  <div class="bg-white dark:bg-gray-900 rounded-3xl
              w-[90%] max-w-md p-6 relative">

    <!-- CLOSE -->
    <button onclick="closeAppModal()"
            class="absolute top-4 right-4 text-xl">✕</button>

    <h2 class="text-xl font-bold mb-2 text-center">
      Get the Kav+ App
    </h2>

    <p class="text-sm text-gray-500 text-center mb-6">
      Faster bookings • Exclusive deals • Offline access
    </p>

    <!-- ANDROID -->
    <div id="androidBlock" class="text-center mb-6 hidden">
      <img class="mx-auto mb-3 rounded-xl border"
           src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=https://play.google.com/store/apps/details?id=com.kavplus.app">
      <a onclick="trackInstall('android')"
         href="https://play.google.com/store/apps/details?id=com.kavplus.app"
         target="_blank"
         class="block bg-[#0097D7] text-white py-3 rounded-xl font-semibold">
        Download for Android
      </a>
    </div>

    <!-- IOS -->
    <div id="iosBlock" class="text-center mb-6 hidden">
      <img class="mx-auto mb-3 rounded-xl border"
           src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=https://apps.apple.com/app/id000000">
      <a onclick="trackInstall('ios')"
         href="https://apps.apple.com/app/id000000"
         target="_blank"
         class="block bg-[#0097D7] text-white py-3 rounded-xl font-semibold">
        Download for iPhone
      </a>
    </div>

    <!-- DESKTOP -->
    <div id="desktopBlock" class="text-center hidden">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <p class="font-semibold mb-2">Android</p>
          <img class="mx-auto rounded-xl border"
               src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://play.google.com/store/apps/details?id=com.kavplus.app">
        </div>
        <div>
          <p class="font-semibold mb-2">iPhone</p>
          <img class="mx-auto rounded-xl border"
               src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://apps.apple.com/app/id000000">
        </div>
      </div>
    </div>

  </div>
</div>

<script>
function openAppModal(){
  document.getElementById('appModal').classList.remove('hidden');
  detectDevice();
}
function closeAppModal(){
  document.getElementById('appModal').classList.add('hidden');
}

/* DEVICE DETECTION */
function detectDevice(){
  const ua = navigator.userAgent.toLowerCase();
  document.getElementById('androidBlock').classList.add('hidden');
  document.getElementById('iosBlock').classList.add('hidden');
  document.getElementById('desktopBlock').classList.add('hidden');

  if(ua.includes('android')){
    document.getElementById('androidBlock').classList.remove('hidden');
  }else if(ua.includes('iphone') || ua.includes('ipad')){
    document.getElementById('iosBlock').classList.remove('hidden');
  }else{
    document.getElementById('desktopBlock').classList.remove('hidden');
  }
}

/* TRACK INSTALL */
function trackInstall(type){
  fetch("app-track.php",{
    method:"POST",
    headers:{'Content-Type':'application/json'},
    body:JSON.stringify({ platform:type })
  });
}
</script>
