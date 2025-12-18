<?php
// admin-header.php
?>
<aside class="fixed top-0 left-0 h-screen w-64 bg-[#0B1220] text-gray-200 flex flex-col">

  <!-- LOGO -->
  <div class="h-16 flex items-center px-6 border-b border-white/10">
    <span class="text-xl font-bold text-sky-400">KAV+</span>
    <span class="ml-1 text-white font-semibold">Admin</span>
  </div>

  <!-- MENU -->
  <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

    <a href="admin-dashboard.php"
       class="flex items-center gap-3 px-4 py-3 rounded-xl bg-sky-500/10 text-sky-400">
      📊 Dashboard
    </a>

    <a href="admin-users.php"
       class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5">
      👤 Users
    </a>

    <a href="admin-bookings.php"
       class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5">
      ✈️ Bookings
    </a>

    <a href="admin-settings.php"
       class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5">
      ⚙️ Settings
    </a>

  </nav>

  <!-- FOOTER -->
  <div class="p-4 border-t border-white/10">
    <a href="logout.php"
       class="block text-center px-4 py-2 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500/20">
      Logout
    </a>
  </div>

</aside>
