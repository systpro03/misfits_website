<div class="space-y-8" x-data="{ timeFrame: 'month' }">

  <!-- ==================== HEADER & QUICK METRICS ==================== -->
  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-display font-bold text-asphalt-900 tracking-tight">Dashboard Overview</h1>
      <p class="text-asphalt-700/60 text-xs mt-0.5">Welcome back, <?= htmlspecialchars($admin->name ?? 'Admin'); ?>. Here's what's happening with your ride club.</p>
    </div>

    <!-- Actions & Timeframe selector -->
    <div class="flex items-center gap-2">
      <div class="bg-asphalt-900/5 p-1 rounded-lg flex items-center gap-1 text-xs font-medium">
        <button type="button" @click="timeFrame = 'month'" :class="timeFrame === 'month' ? 'bg-white text-asphalt-900 shadow-xs' : 'text-asphalt-700/60 hover:text-asphalt-900'" class="px-3 py-1.5 rounded-md transition-all">30 Days</button>
        <button type="button" @click="timeFrame = 'year'" :class="timeFrame === 'year' ? 'bg-white text-asphalt-900 shadow-xs' : 'text-asphalt-700/60 hover:text-asphalt-900'" class="px-3 py-1.5 rounded-md transition-all">This Year</button>
      </div>

      <a href="<?= site_url('admin/rides/add'); ?>" class="px-4 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold rounded-lg transition-all shadow-xs hover:shadow active:scale-95 flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Ride
      </a>
    </div>
  </div>

  <!-- ==================== METRIC STAT CARDS ==================== -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    
    <!-- Upcoming Rides Card -->
    <div class="bg-white border border-asphalt-800/10 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-ember-500/30 transition-all duration-300">
      <div class="flex items-center justify-between">
        <span class="text-xs uppercase font-semibold text-asphalt-700/50 tracking-wider">Upcoming Rides</span>
        <span class="p-2 bg-ember-500/10 text-ember-600 rounded-xl group-hover:scale-110 transition-transform">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </span>
      </div>
      <div class="mt-4 flex items-baseline justify-between">
        <h3 class="text-3xl font-display font-bold text-asphalt-900"><?= (int) $upcoming_count; ?></h3>
        <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full flex items-center gap-0.5">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg> Scheduled
        </span>
      </div>
      <div class="mt-3 w-full bg-asphalt-900/5 rounded-full h-1.5 overflow-hidden">
        <div class="bg-ember-500 h-1.5 rounded-full" style="width: <?= min(100, max(15, ($upcoming_count * 10))); ?>%"></div>
      </div>
    </div>

    <!-- Rides Logged Card -->
    <div class="bg-white border border-asphalt-800/10 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-asphalt-800/30 transition-all duration-300">
      <div class="flex items-center justify-between">
        <span class="text-xs uppercase font-semibold text-asphalt-700/50 tracking-wider">Completed Rides</span>
        <span class="p-2 bg-asphalt-900/5 text-asphalt-800 rounded-xl group-hover:scale-110 transition-transform">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </span>
      </div>
      <div class="mt-4 flex items-baseline justify-between">
        <h3 class="text-3xl font-display font-bold text-asphalt-900"><?= (int) $past_count; ?></h3>
        <span class="text-[11px] font-medium text-asphalt-700/60">Total archived</span>
      </div>
      <div class="mt-3 w-full bg-asphalt-900/5 rounded-full h-1.5 overflow-hidden">
        <div class="bg-asphalt-800 h-1.5 rounded-full" style="width: 100%"></div>
      </div>
    </div>

    <!-- Active Members Card -->
    <div class="bg-white border border-asphalt-800/10 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-asphalt-800/30 transition-all duration-300">
      <div class="flex items-center justify-between">
        <span class="text-xs uppercase font-semibold text-asphalt-700/50 tracking-wider">Active Members</span>
        <span class="p-2 bg-asphalt-900/5 text-asphalt-800 rounded-xl group-hover:scale-110 transition-transform">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </span>
      </div>
      <div class="mt-4 flex items-baseline justify-between">
        <h3 class="text-3xl font-display font-bold text-asphalt-900"><?= (int) $member_count; ?></h3>
        <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Riders</span>
      </div>
      <div class="mt-3 w-full bg-asphalt-900/5 rounded-full h-1.5 overflow-hidden">
        <div class="bg-indigo-600 h-1.5 rounded-full" style="width: <?= min(100, max(20, $member_count)); ?>%"></div>
      </div>
    </div>

    <!-- Gallery Photos Card -->
    <div class="bg-white border border-asphalt-800/10 rounded-2xl p-5 shadow-xs relative overflow-hidden group hover:border-asphalt-800/30 transition-all duration-300">
      <div class="flex items-center justify-between">
        <span class="text-xs uppercase font-semibold text-asphalt-700/50 tracking-wider">Gallery Storage</span>
        <span class="p-2 bg-asphalt-900/5 text-asphalt-800 rounded-xl group-hover:scale-110 transition-transform">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </span>
      </div>
      <div class="mt-4 flex items-baseline justify-between">
        <h3 class="text-3xl font-display font-bold text-asphalt-900"><?= (int) $gallery_count; ?></h3>
        <span class="text-[11px] font-medium text-asphalt-700/60">Photos uploaded</span>
      </div>
      <div class="mt-3 w-full bg-asphalt-900/5 rounded-full h-1.5 overflow-hidden">
        <div class="bg-amber-500 h-1.5 rounded-full" style="width: <?= min(100, max(10, $gallery_count)); ?>%"></div>
      </div>
    </div>

  </div>

  <!-- ==================== ANALYTICS & ACTIVITY SECTION ==================== -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Ride Participation Analytics Chart -->
    <div class="lg:col-span-2 bg-white border border-asphalt-800/10 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="font-display font-semibold text-base text-asphalt-900">Ride Activity Overview</h2>
          <p class="text-xs text-asphalt-700/50">Rides hosted vs member participation trend</p>
        </div>
        <div class="flex items-center gap-3 text-xs font-medium">
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-ember-500"></span> Rides</span>
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-asphalt-800"></span> Member Signups</span>
        </div>
      </div>
      
      <!-- Chart Canvas Container -->
      <div class="relative w-full h-64">
        <canvas id="rideActivityChart"></canvas>
      </div>
    </div>

    <!-- Pending Photo Requests Panel -->
    <div class="bg-white border border-asphalt-800/10 rounded-2xl p-6 shadow-xs flex flex-col">
      <div class="flex items-center justify-between pb-4 mb-4 border-b border-asphalt-800/10">
        <div class="flex items-center gap-2">
          <h2 class="font-display font-semibold text-base text-asphalt-900">Pending Photos</h2>
          <?php if (!empty($pending_requests)): ?>
              <span class="px-2 py-0.5 text-[10px] font-bold bg-ember-500 text-white rounded-full"><?= count($pending_requests); ?></span>
          <?php endif; ?>
        </div>
        <a href="<?= site_url('admin/requests'); ?>" class="text-xs font-semibold text-ember-600 hover:text-ember-700 transition-colors flex items-center gap-1 group">
          Review all 
          <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>

      <?php if (empty($pending_requests)): ?>
          <div class="flex-1 flex flex-col items-center justify-center py-10 text-center">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-sm font-medium text-asphalt-900">Queue is Clear!</p>
            <p class="text-xs text-asphalt-700/50 mt-0.5">No community submissions waiting for review.</p>
          </div>
      <?php else: ?>
          <div class="space-y-3 flex-1 overflow-y-auto max-h-[280px] pr-1">
            <?php foreach (array_slice($pending_requests, 0, 5) as $req): ?>
                <div class="flex items-center gap-3 p-2.5 rounded-xl bg-asphalt-900/5 hover:bg-asphalt-900/10 transition-colors group">
                  <div class="w-12 h-12 rounded-lg overflow-hidden bg-asphalt-900 flex-shrink-0 border border-asphalt-800/10 relative">
                    <img src="<?= upload_url('requests', $req->image); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="">
                  </div>
                  <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-asphalt-900 truncate"><?= htmlspecialchars($req->submitter_name); ?></p>
                    <p class="text-[11px] text-asphalt-700/60 truncate mt-0.5"><?= htmlspecialchars($req->caption ?: 'No caption provided'); ?></p>
                  </div>
                  <a href="<?= site_url('admin/requests'); ?>" class="p-1.5 text-asphalt-700/40 hover:text-ember-600 rounded-lg hover:bg-white transition-colors" title="Review">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
                </div>
            <?php endforeach; ?>
          </div>
      <?php endif; ?>
    </div>

  </div>

  <!-- ==================== UPCOMING RIDES LIST ==================== -->
  <div class="bg-white border border-asphalt-800/10 rounded-2xl p-6 shadow-xs">
    <div class="flex items-center justify-between pb-4 mb-4 border-b border-asphalt-800/10">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-ember-500 animate-ping"></span>
        <h2 class="font-display font-semibold text-base text-asphalt-900">Next Scheduled Rides</h2>
      </div>
      <a href="<?= site_url('admin/rides'); ?>" class="text-xs font-semibold text-ember-600 hover:text-ember-700 transition-colors flex items-center gap-1 group">
        Manage Schedule 
        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <?php if (empty($next_rides)): ?>
        <div class="py-12 text-center border-2 border-dashed border-asphalt-800/10 rounded-xl">
          <svg class="w-10 h-10 text-asphalt-700/30 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          <p class="text-asphalt-700/60 text-sm font-medium">No upcoming rides scheduled.</p>
          <a href="<?= site_url('admin/rides/add'); ?>" class="inline-block mt-3 px-4 py-2 bg-ember-500 text-white text-xs font-semibold rounded-lg hover:bg-ember-600 transition-colors">+ Schedule a Ride</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach ($next_rides as $ride): ?>
              <div class="bg-asphalt-900/5 hover:bg-asphalt-900/10 border border-asphalt-800/5 rounded-xl p-4 transition-all duration-200 flex flex-col justify-between group">
            
                <div>
                  <div class="flex items-start justify-between gap-3 mb-3">
                    <!-- Date Badge -->
                    <div class="flex-shrink-0 w-12 h-12 bg-asphalt-900 text-white rounded-xl flex flex-col items-center justify-center text-center p-1 shadow-xs">
                      <span class="text-[10px] uppercase font-bold tracking-wider text-ember-400 leading-none"><?= date('M', strtotime($ride->ride_date)); ?></span>
                      <span class="text-lg font-bold leading-none mt-0.5"><?= date('d', strtotime($ride->ride_date)); ?></span>
                    </div>

                    <div class="flex-1 min-w-0">
                      <h4 class="font-semibold text-sm text-asphalt-900 truncate group-hover:text-ember-600 transition-colors"><?= htmlspecialchars($ride->title); ?></h4>
                      <p class="text-xs text-asphalt-700/60 flex items-center gap-1 mt-1 truncate">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 text-asphalt-700/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <?= !empty($ride->meeting_point) ? htmlspecialchars($ride->meeting_point) : 'Location TBD'; ?>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="pt-3 border-t border-asphalt-800/10 flex items-center justify-between mt-2">
                  <span class="text-[11px] font-medium text-asphalt-700/50">
                    <?= date('g:i A', strtotime($ride->ride_date)); ?>
                  </span>
                  <a href="<?= site_url('admin/rides/edit/' . $ride->id); ?>" class="px-3 py-1 bg-white hover:bg-asphalt-900 hover:text-white border border-asphalt-800/10 rounded-md text-xs font-semibold text-asphalt-800 transition-all shadow-2xs">
                    Edit Details
                  </a>
                </div>

              </div>
          <?php endforeach; ?>
        </div>
    <?php endif; ?>
  </div>

  <!-- ==================== QUICK ACTION TOOLBAR ==================== -->
  <div class="bg-asphalt-900 text-white rounded-2xl p-6 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h3 class="font-display font-semibold text-lg text-white">Manage Club Operations</h3>
      <p class="text-xs text-asphalt-400 mt-0.5">Quickly add content to the public platform</p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
      <a href="<?= site_url('admin/rides/add'); ?>" class="px-4 py-2.5 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95 flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Ride
      </a>

      <a href="<?= site_url('admin/routes/add'); ?>" class="px-4 py-2.5 bg-asphalt-800 hover:bg-asphalt-700 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all active:scale-95 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-asphalt-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
        New Route
      </a>

      <a href="<?= site_url('admin/members/add'); ?>" class="px-4 py-2.5 bg-asphalt-800 hover:bg-asphalt-700 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all active:scale-95 flex items-center gap-1.5">
        <svg class="w-4 h-4 text-asphalt-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Add Member
      </a>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
window.addEventListener('load', function () {
  if (typeof Chart === 'undefined') {
    console.error('Chart.js library failed to load.');
    return;
  }

  const ctx = document.getElementById('rideActivityChart').getContext('2d');
  
  const emberGradient = ctx.createLinearGradient(0, 0, 0, 300);
  emberGradient.addColorStop(0, 'rgba(249, 115, 22, 0.35)');
  emberGradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [
        {
          label: 'Rides Hosted',
          data: <?= $chart_rides; ?>,
          borderColor: '#f97316',
          backgroundColor: emberGradient,
          borderWidth: 2.5,
          fill: true,
          tension: 0.4,
          pointRadius: 3,
          pointHoverRadius: 6
        },
        {
        label: 'Member Signups',
        data: <?= $chart_members; ?>,
      borderColor: '#1e293b',
      borderDash: [5, 5],
      borderWidth: 2,
      fill: false,
      tension: 0.4,
      pointRadius: 0
        }
      ]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false }
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { font: { size: 11 }, color: '#94a3b8' }
      },
      y: {
        grid: { color: 'rgba(148, 163, 184, 0.1)' },
        ticks: { font: { size: 11 }, color: '#94a3b8' },
        beginAtZero: true
      }
    }
  }
  });
});
</script>