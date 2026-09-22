<!-- Custom Animation Styles & Alpine Cloak Fix -->
<style>
  [x-cloak] {
    display: none !important;
  }

  @keyframes float {

    0%,
    100% {
      transform: translateY(0px) rotate(0deg);
    }

    50% {
      transform: translateY(-12px) rotate(1deg);
    }
  }

  .animate-float {
    animation: float 6s ease-in-out infinite;
  }

  /* Announcement controls must stay above the other floating controls. */
  .announcement-overlay {
    z-index: 99999 !important;
  }

  .announcement-floating-button {
    position: fixed !important;
    right: 20px !important;
    bottom: 140px !important;
    z-index: 100000 !important;
    width: 54px !important;
    height: 54px !important;
    min-width: 54px !important;
    min-height: 54px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
  }

  .announcement-floating-button > span:first-child {
    width: 40px !important;
    height: 40px !important;
    flex: 0 0 40px !important;
    border-radius: 50% !important;
    background: #e8580c !important;
    color: #0e0f12 !important;
  }

  .announcement-floating-button .announcement-count {
    position: absolute !important;
    top: -7px !important;
    right: -7px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 20px !important;
    width: auto !important;
    height: 20px !important;
    padding: 0 5px !important;
    margin: 0 !important;
    border: 2px solid #17181c !important;
    border-radius: 999px !important;
    background: #e8580c !important;
    color: #fff !important;
    font-size: 9px !important;
    font-weight: 800 !important;
    line-height: 1 !important;
    z-index: 20 !important;
  }

  .announcement-floating-button .announcement-dot  {
    position: absolute;
    top: 0;
    right: 0;
    width: 9px;
    height: 9px;
    border: 2px solid #17181c;
    border-radius: 50%;
    background: #f2a165;
  }

  .announcement-floating-button > span > svg {
    width: 22px !important;
    height: 22px !important;
    stroke-width: 2 !important;
  }

  .announcement-overlay > .relative {
    max-height: 74vh !important;
  }

  .announcement-overlay .custom-scrollbar {
    flex: 1 1 auto !important;
    min-height: 0 !important;
    overflow-y: auto !important;
    overscroll-behavior: contain;
    -webkit-overflow-scrolling: touch;
  }

  @media (max-width: 640px) {
    .announcement-floating-button {
      right: 12px !important;
      bottom: 140px !important;
      width: 52px !important;
      height: 52px !important;
      min-width: 52px !important;
      min-height: 52px !important;
    }

    .announcement-overlay > .relative {
      max-height: 70vh !important;
    }
  }
</style>

<?php
// Format gallery items into a clean JS array for Alpine.js navigation
$gallery_items = [];
if (!empty($gallery)) {
  foreach (array_slice($gallery, 0, 12) as $g) {
    $gallery_items[] = [
      'src' => upload_url('gallery', $g->image),
      'caption' => $g->caption ?? ''
    ];
  }
}
?>

<!-- Main Container with Alpine.js Lightbox & Route Suggestion state -->
<div x-data="{ 
      lightboxOpen: false, 
      currentIndex: 0,
      items: <?= htmlspecialchars(json_encode($gallery_items ?? []), ENT_QUOTES, 'UTF-8'); ?>,
      suggestModalOpen: false,
      submitPhotoModalOpen: false,
      submittingPhoto: false,
      announcementOpen: false,
      announcementStorageKey: 'misfits_announcements_last_opened',
      announcementInterval: 12 * 60 * 60 * 1000,
      activeRideId: null,
      activeRideTitle: '',
      init() {
        <?php if (!empty($announcements)): ?>
        try {
          const lastOpened = parseInt(localStorage.getItem(this.announcementStorageKey) || '0', 10);
          const shouldOpen = !lastOpened || (Date.now() - lastOpened >= this.announcementInterval);
          if (shouldOpen) {
            this.announcementOpen = true;
            localStorage.setItem(this.announcementStorageKey, String(Date.now()));
          }
        } catch (e) {
          // If localStorage is unavailable, keep the bulletin available on load.
          this.announcementOpen = true;
        }
        <?php endif; ?>
      },
      openAnnouncements() {
        this.announcementOpen = true;
        try {
          localStorage.setItem(this.announcementStorageKey, String(Date.now()));
        } catch (e) {}
      },
      closeAnnouncements() {
        this.announcementOpen = false;
        try {
          localStorage.setItem(this.announcementStorageKey, String(Date.now()));
        } catch (e) {}
      }
  }" class="relative">

  <!-- ================= HERO ================= -->
  <section class="home-hero relative bg-asphalt-950 text-chrome-200 overflow-hidden min-h-[85vh] flex items-center">
    <div class="absolute inset-y-0 right-[-10%] w-2/3 bg-ember-500/10 -skew-x-12 pointer-events-none blur-xl"></div>
    <div class="absolute inset-y-0 right-[-18%] w-1/3 bg-ember-500/5 -skew-x-12 pointer-events-none"></div>
    <div
      class="absolute top-1/2 right-[10%] -translate-y-1/2 w-96 h-96 bg-ember-500/15 rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="home-hero-inner relative max-w-6xl mx-auto px-5 py-20 md:py-28 w-full">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

        <div class="home-hero-copy lg:col-span-7">
          <p
            class="animate-rise font-display text-ember-500 tracking-[0.3em] text-xs md:text-sm mb-5 font-bold uppercase">
            <?= !empty($site->founded_year) ? 'RIDING TOGETHER SINCE ' . htmlspecialchars($site->founded_year) : 'A MOTORCYCLE RIDING GROUP'; ?>
          </p>
          <h1
            class="animate-rise font-display font-bold text-5xl sm:text-6xl md:text-7xl leading-[0.92] text-white tracking-tight"
            style="animation-delay:.08s">
            <?= htmlspecialchars($site->club_name); ?>
          </h1>
          <p class="animate-rise mt-6 text-lg md:text-xl text-chrome-200/80 max-w-xl leading-relaxed font-sans"
            style="animation-delay:.16s">
            <?= htmlspecialchars($site->tagline); ?>
          </p>

          <div class="animate-rise mt-9 flex flex-wrap gap-4" style="animation-delay:.24s">
            <a href="<?= base_url('rides/upcoming'); ?>"
              class="px-7 py-3.5 bg-ember-500 hover:bg-ember-600 text-asphalt-950 font-display font-bold text-sm tracking-wider uppercase rounded-xl transition-all shadow-lg shadow-ember-500/20 active:scale-95">
              See Upcoming Rides
            </a>
            <a href="<?= base_url('members'); ?>"
              class="px-7 py-3.5 border border-chrome-200/30 hover:border-ember-500 hover:text-ember-500 font-display font-bold text-sm tracking-wider uppercase rounded-xl transition-all active:scale-95">
              Meet the Team
            </a>
          </div>

          <div
            class="home-hero-stats animate-rise mt-16 grid grid-cols-3 max-w-lg gap-6 border-t border-asphalt-800/80 pt-8"
            style="animation-delay:.32s">
            <div>
              <p class="font-display text-3xl md:text-4xl font-bold text-ember-500"><?= (int) $member_count; ?></p>
              <p class="text-[11px] uppercase tracking-widest text-chrome-200/60 font-semibold mt-1">Riders</p>
            </div>
            <div>
              <p class="font-display text-3xl md:text-4xl font-bold text-ember-500"><?= (int) $upcoming_count; ?></p>
              <p class="text-[11px] uppercase tracking-widest text-chrome-200/60 font-semibold mt-1">Rides planned</p>
            </div>
            <div>
              <p class="font-display text-3xl md:text-4xl font-bold text-ember-500"><?= (int) $past_count; ?></p>
              <p class="text-[11px] uppercase tracking-widest text-chrome-200/60 font-semibold mt-1">Roads logged</p>
            </div>
          </div>
        </div>

        <div class="home-hero-logo lg:col-span-5 flex justify-center lg:justify-end">
          <div class="relative group animate-float">
            <div
              class="absolute inset-0 bg-ember-500/20 rounded-full blur-2xl scale-95 group-hover:scale-110 transition-transform duration-500">
            </div>
            <img src="<?= base_url('assets/img/logo/misfits-logo.png'); ?>"
              alt="<?= htmlspecialchars($site->club_name); ?> Emblem"
              class="relative z-10 w-72 sm:w-80 md:w-96 lg:w-[420px] h-auto object-contain drop-shadow-[0_20px_35px_rgba(0,0,0,0.8)]">
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= CLUB BULLETIN POPUP ================= -->
  <?php if (!empty($announcements)): ?>
    <div x-show="announcementOpen" x-cloak class="announcement-overlay fixed inset-0 flex items-center justify-center p-3 sm:p-5" role="dialog" aria-modal="true" aria-label="Club announcements">
      <div class="absolute inset-0 bg-asphalt-950/75 backdrop-blur-sm" @click="closeAnnouncements()"></div>

      <div class="relative w-full max-w-xl max-h-[70vh] sm:max-h-[74vh] bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden text-asphalt-900 flex flex-col">
        <div class="relative px-5 sm:px-7 py-5 border-b border-asphalt-800/10 flex-shrink-0">
          <div class="absolute top-0 left-0 right-0 h-1 bg-ember-500"></div>
          <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-3 min-w-0">
              <div class="w-10 h-10 rounded-xl bg-ember-500/10 text-ember-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-width="1.8" fill="none" d="M19 5H5a2 2 0 00-2 2v9a2 2 0 002 2h3l4 3 4-3h3a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h7"/>
                </svg>
              </div>
              <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-ember-600">Club Bulletin</p>
                <h2 class="mt-0.5 font-display text-xl sm:text-2xl font-bold text-asphalt-900">Rider Announcements</h2>
                <p class="mt-1 text-xs text-asphalt-700/55">Important updates, reminders and notices from the Misfits admin team.</p>
              </div>
            </div>
            <button type="button" @click="closeAnnouncements()" class="p-2 rounded-xl text-asphalt-700/40 hover:text-asphalt-900 hover:bg-asphalt-900/5 transition-colors flex-shrink-0" aria-label="Close announcements">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
          </div>
        </div>

        <div class="min-h-0 overflow-y-auto overscroll-contain px-4 sm:px-6 py-4 space-y-3 custom-scrollbar">
          <?php foreach ($announcements as $announcement):
            $bulletin_type = $announcement->type ?? 'announcement';
            $type_styles = array(
              'announcement' => array('label' => 'Announcement', 'icon' => 'M19 5H5a2 2 0 00-2 2v9a2 2 0 002 2h3l4 3 4-3h3a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h7', 'class' => 'bg-sky-50 text-sky-700 border-sky-200'),
              'reminder' => array('label' => 'Ride Reminder', 'icon' => 'M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'),
              'attention' => array('label' => 'Attention', 'icon' => 'M12 9v4m0 4h.01M10.3 3.6l-7 12.1A2 2 0 005 18.7h14a2 2 0 001.7-3l-7-12.1a2 2 0 00-3.4 0z', 'class' => 'bg-rose-50 text-rose-700 border-rose-200'),
              'suggestion' => array('label' => 'Ride Suggestion', 'icon' => 'M9.5 3a6.5 6.5 0 014.9 10.8c-.9 1-1.4 2-1.4 3.2h-2v-1.5c0-1.4-.6-2.5-1.4-3.5A6.5 6.5 0 019.5 3zM8 21h4M8 18h4', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200')
            );
            $style = isset($type_styles[$bulletin_type]) ? $type_styles[$bulletin_type] : $type_styles['announcement'];
          ?>
            <article class="rounded-xl border border-asphalt-800/10 bg-asphalt-900/[0.025] p-4 sm:p-5 hover:border-ember-500/25 transition-colors">
              <div class="flex items-start justify-between gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[9px] font-bold uppercase tracking-wider <?= $style['class']; ?>">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.8" d="<?= $style['icon']; ?>"/></svg>
                  <?= $style['label']; ?>
                </span>
                <?php if (($announcement->priority ?? 'normal') !== 'normal'): ?>
                  <span class="text-[9px] font-display font-bold uppercase tracking-wider <?= $announcement->priority === 'urgent' ? 'text-rose-600' : 'text-amber-600'; ?>">
                    <?= htmlspecialchars($announcement->priority); ?>
                  </span>
                <?php endif; ?>
              </div>
              <h3 class="mt-2.5 font-display text-base sm:text-lg font-bold text-asphalt-900"><?= htmlspecialchars($announcement->title); ?></h3>
              <p class="mt-1.5 text-sm text-asphalt-700/70 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($announcement->message); ?></p>
              <div class="mt-3 pt-3 border-t border-asphalt-800/10 flex items-center justify-between gap-2 text-[9px] uppercase tracking-wider font-semibold text-asphalt-700/40">
                <span>By <?= htmlspecialchars($announcement->admin_name ?: 'Club Admin'); ?></span>
                <span><?= date('M j, Y', strtotime($announcement->created_at)); ?></span>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <div class="px-5 sm:px-7 py-4 border-t border-asphalt-800/10 bg-asphalt-900/[0.025] flex items-center justify-between gap-3 flex-shrink-0">
          <span class="text-[10px] uppercase tracking-wider font-semibold text-asphalt-700/40">Please stay updated before your next ride.</span>
          <button type="button" @click="closeAnnouncements()" class="px-4 py-2.5 rounded-xl bg-ember-500 hover:bg-ember-600 text-asphalt-950 text-xs font-display font-bold uppercase tracking-wider transition-all active:scale-95">Got It</button>
        </div>
      </div>
    </div>

    <!-- Floating announcement button after closing the bulletin -->
    <button type="button" x-show="!announcementOpen" x-cloak @click="openAnnouncements()" class="announcement-floating-button fixed right-5 bottom-[140px] sm:right-5 sm:bottom-[140px] group flex items-center justify-center w-[54px] h-[54px] rounded-full bg-asphalt-950 border border-ember-500 shadow-2xl shadow-asphalt-950/25 hover:border-ember-500 hover:bg-asphalt-900 transition-all active:scale-95" aria-label="Open announcements" title="Open announcements">
      <span class="relative inline-flex items-center justify-center w-10 h-10 rounded-full bg-ember-500 text-asphalt-950">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" d="M19 5H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3l4 3 4-3h3a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zM7 9h10M7 13h7"/>
        </svg>
      </span>
      <span class="announcement-count">
        <?= count($announcements) > 99 ? '99+' : count($announcements); ?>
      </span>
    </button>
  <?php endif; ?>

  <!-- ================= VISION / MISSION ================= -->
  <section class="max-w-6xl mx-auto px-5 py-24 grid grid-cols-1 md:grid-cols-2 gap-12">
    <div
      class="bg-white p-8 rounded-2xl border border-asphalt-800/10 shadow-xs hover:border-ember-500/30 transition-colors">
      <h2 class="font-display text-xs font-bold tracking-[0.25em] text-ember-600 uppercase mb-4">Our Vision</h2>
      <p class="text-xl md:text-2xl font-display leading-snug text-asphalt-900">
        <?= nl2br(htmlspecialchars($site->vision_text)); ?>
      </p>
    </div>
    <div
      class="bg-white p-8 rounded-2xl border border-asphalt-800/10 shadow-xs hover:border-ember-500/30 transition-colors">
      <h2 class="font-display text-xs font-bold tracking-[0.25em] text-ember-600 uppercase mb-4">Our Mission</h2>
      <p class="text-xl md:text-2xl font-display leading-snug text-asphalt-900">
        <?= nl2br(htmlspecialchars($site->mission_text)); ?>
      </p>
    </div>
  </section>

  <!-- ================= UPCOMING RIDES ================= -->
  <!-- ================= UPCOMING RIDES ================= -->
  <section class="bg-asphalt-900 text-chrome-200 py-24 border-y border-asphalt-800/80">
    <div class="max-w-6xl mx-auto px-5">
      <div class="flex items-end justify-between mb-12">
        <div>
          <h2 class="font-display text-xs font-bold tracking-[0.25em] text-ember-500 uppercase mb-2">Kickstands Up</h2>
          <p class="font-display text-3xl md:text-4xl font-bold text-white">Upcoming Group Rides</p>
        </div>
        <a href="<?= base_url('rides/upcoming'); ?>"
          class="hidden sm:inline-flex items-center gap-2 text-sm font-display tracking-wide text-ember-500 hover:text-ember-400 font-semibold">
          <span>View all</span> &rarr;
        </a>
      </div>

      <?php if (empty($upcoming_rides)): ?>
        <p class="text-chrome-200/60 bg-asphalt-950 p-8 rounded-xl border border-asphalt-800 text-center">No rides
          scheduled yet — check back soon.</p>
      <?php else: ?>
        <div class="space-y-8">
          <?php foreach ($upcoming_rides as $ride): ?>
            <?php
            $CI =& get_instance();
            // Check if there is already an approved route for this ride
            $approved_route = $CI->db->where('ride_id', $ride->id)
              ->where('status', 'approved')
              ->get('routes')
              ->row();
            $has_approved = !empty($approved_route);
            ?>
            <div
              class="bg-asphalt-950 rounded-2xl p-6 md:p-8 border border-asphalt-800 hover:border-ember-500/40 transition-all shadow-xl">

              <!-- Main Ride Details Top Bar -->
              <div
                class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-asphalt-800/80">
                <div class="space-y-2 max-w-2xl">
                  <p class="font-display text-ember-500 text-xs tracking-widest font-bold uppercase">
                    <?= strtoupper(date('l, F j, Y', strtotime($ride->ride_date))); ?>
                  </p>
                  <a href="<?= base_url('rides/' . $ride->id); ?>"
                    class="block font-display text-3xl md:text-4xl font-bold text-white hover:text-ember-500 transition-colors">
                    <?= htmlspecialchars($ride->title); ?>
                  </a>
                  <p class="text-sm md:text-base text-chrome-200/70 leading-relaxed">
                    <?= htmlspecialchars(mb_strimwidth(strip_tags($ride->description), 0, 180, '...')); ?>
                  </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 flex-shrink-0">
                  <?php if (!empty($ride->meeting_point)): ?>
                    <div
                      class="flex items-center gap-2 px-4 py-2.5 bg-asphalt-900 rounded-xl border border-asphalt-800 text-xs text-chrome-200/80">
                      <svg class="w-4 h-4 text-ember-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <span>Meet at <strong><?= htmlspecialchars($ride->meeting_point); ?></strong></span>
                    </div>
                  <?php endif; ?>

                  <!-- Only allow route suggestions if NO route is approved yet -->
                  <?php if (!$has_approved): ?>
                    <button
                      @click="activeRideId = <?= $ride->id; ?>; activeRideTitle = '<?= htmlspecialchars(addslashes($ride->title)); ?>'; suggestModalOpen = true"
                      class="px-4 py-2.5 bg-ember-500/10 hover:bg-ember-500 hover:text-asphalt-950 text-ember-500 border border-ember-500/30 font-display font-bold text-xs uppercase tracking-wider rounded-xl transition-all active:scale-95">
                      + Suggest Route
                    </button>
                  <?php else: ?>
                    <span
                      class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-ember-500/10 text-ember-500 border border-ember-500/30 font-display font-bold text-xs uppercase tracking-wider rounded-xl">
                      <span class="relative flex h-2 w-2">
                        <span
                          class="animate-ping absolute inline-flex h-full w-full rounded-full bg-ember-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-ember-500"></span>
                      </span>
                      Official Route Set
                    </span>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Route Suggestions & Voting Cards Section -->
              <div class="mt-6">
                <div class="flex items-center justify-between mb-4">
                  <span
                    class="text-xs font-display font-bold uppercase tracking-widest text-ember-500 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5-4V4l5 4 5-4 5 4v12l-5-4-5 4z" />
                    </svg>
                    <?= $has_approved ? 'Official Approved Route' : 'Route Options & Team Voting'; ?>
                  </span>
                </div>

                <?php if ($has_approved): ?>
                  <?php
                  $map_link = !empty($approved_route->map_embed_url) ? $approved_route->map_embed_url : (!empty($approved_route->map_url) ? $approved_route->map_url : null);
                  ?>
                  <!-- ================= REFINED OFFICIAL APPROVED ROUTE CARD ================= -->
                  <div
                    class="relative overflow-hidden bg-gradient-to-br from-asphalt-900 via-asphalt-900/95 to-ember-950/20 border-2 border-ember-500/40 rounded-2xl p-6 shadow-2xl backdrop-blur-md transition-all duration-300">

                    <!-- Subtle Ambient Top-Right Accent Glow -->
                    <div
                      class="absolute -right-12 -top-12 w-48 h-48 bg-ember-500/10 rounded-full blur-3xl pointer-events-none">
                    </div>

                    <!-- Header & Status Row -->
                    <div
                      class="flex flex-wrap items-center justify-between gap-3 pb-4 mb-5 border-b border-asphalt-800/80 relative z-10">
                      <div class="flex items-center gap-3">
                        <span
                          class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-ember-500/15 text-ember-500 font-display font-bold text-xs uppercase tracking-wider rounded-xl border border-ember-500/30 shadow-xs">
                          <span class="relative flex h-2 w-2">
                            <span
                              class="animate-ping absolute inline-flex h-full w-full rounded-full bg-ember-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-ember-500"></span>
                          </span>
                          Official Ride Route
                        </span>
                        <span class="text-xs text-chrome-200/50 font-mono tracking-tight hidden sm:inline-block">
                          Locked by Organizer
                        </span>
                      </div>

                      <!-- Metric Badges -->
                      <div class="flex items-center gap-2 flex-wrap">
                        <?php if (!empty($approved_route->distance_km)): ?>
                          <div
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-asphalt-950/90 border border-asphalt-800 rounded-lg text-xs font-mono text-chrome-200">
                            <svg class="w-3.5 h-3.5 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span><strong><?= htmlspecialchars($approved_route->distance_km); ?></strong> km</span>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($approved_route->estimated_duration)): ?>
                          <div
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-asphalt-950/90 border border-asphalt-800 rounded-lg text-xs font-mono text-chrome-200">
                            <svg class="w-3.5 h-3.5 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><?= htmlspecialchars($approved_route->estimated_duration); ?></span>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <!-- Route Details & Map Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start relative z-10">

                      <!-- Left Column: Primary Route Metadata (7 cols) -->
                      <div class="lg:col-span-7 space-y-4">
                        <div>
                          <h4 class="font-display font-bold text-2xl md:text-3xl text-white tracking-wide leading-snug">
                            <?= htmlspecialchars($approved_route->route_name); ?>
                          </h4>
                        </div>

                        <!-- Waypoint Indicators -->
                        <?php if (!empty($approved_route->start_point) || !empty($approved_route->end_point)): ?>
                          <div
                            class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 p-3.5 bg-asphalt-950/80 rounded-xl border border-asphalt-800">
                            <div class="flex items-center gap-2 min-w-0">
                              <span class="w-2 h-2 rounded-full bg-ember-400 shrink-0"></span>
                              <span class="text-xs font-mono text-chrome-200/50 uppercase">Start</span>
                              <span
                                class="text-xs font-semibold text-white truncate"><?= htmlspecialchars($approved_route->start_point ?? 'N/A'); ?></span>
                            </div>

                            <svg class="w-4 h-4 text-ember-500 shrink-0 rotate-90 sm:rotate-0 self-center" fill="none"
                              stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>

                            <div class="flex items-center gap-2 min-w-0">
                              <span class="w-2 h-2 rounded-full bg-ember-500 shrink-0"></span>
                              <span class="text-xs font-mono text-chrome-200/50 uppercase">End</span>
                              <span
                                class="text-xs font-semibold text-white truncate"><?= htmlspecialchars($approved_route->end_point ?? 'N/A'); ?></span>
                            </div>
                          </div>
                        <?php endif; ?>

                        <!-- Description / Route Notes -->
                        <?php if (!empty($approved_route->route_details)): ?>
                          <p
                            class="text-xs md:text-sm text-chrome-200/80 leading-relaxed bg-asphalt-900/40 p-4 rounded-xl border border-asphalt-800/60">
                            <?= htmlspecialchars($approved_route->route_details); ?>
                          </p>
                        <?php endif; ?>
                      </div>

                      <!-- Right Column: Map Embed & Navigation CTA (5 cols) -->
                      <div class="lg:col-span-5 w-full space-y-3">
                        <?php
                        $map_link = !empty($approved_route->map_embed_url) ? $approved_route->map_embed_url : (!empty($approved_route->map_url) ? $approved_route->map_url : null);
                        ?>

                        <?php if (!empty($map_link)): ?>
                          <?php if (strpos($map_link, 'pb=') !== false || strpos($map_link, '/embed') !== false): ?>
                            <div
                              class="w-full h-44 rounded-xl overflow-hidden border border-ember-500/30 bg-asphalt-950 shadow-inner group relative">
                              <iframe src="<?= htmlspecialchars($map_link); ?>"
                                class="w-full h-full border-0 grayscale hover:grayscale-0 transition-all duration-300"
                                allowfullscreen="" loading="lazy"></iframe>
                            </div>
                          <?php endif; ?>

                          <a href="<?= htmlspecialchars($map_link); ?>" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2.5 w-full px-5 py-3.5 bg-ember-500 hover:bg-ember-400 text-asphalt-950 font-display font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-200 shadow-lg shadow-ember-500/20 hover:shadow-ember-500/30 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5-4V4l5 4 line5-4 5 4v12l-5-4-5 4z" />
                            </svg>
                            <span>Open Live Directions</span>
                            <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                          </a>
                        <?php else: ?>
                          <div
                            class="flex items-center justify-center h-32 bg-asphalt-950 rounded-xl border border-asphalt-800 text-xs text-chrome-200/40 italic text-center p-4">
                            No external map link attached for this route.
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <!-- Locked Footer Info Bar -->
                    <div
                      class="mt-6 pt-4 border-t border-ember-500/20 flex items-center justify-between text-xs text-ember-500/90 font-medium relative z-10">
                      <div class="flex items-center gap-2">
                        <div class="p-1 bg-ember-500/10 rounded-md">
                          <svg class="w-3.5 h-3.5 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                          </svg>
                        </div>
                        <span>Voting for this ride is complete. Route confirmed.</span>
                      </div>

                      <?php if (!empty($approved_route->vote_count)): ?>
                        <span class="text-chrome-200/50 font-mono text-[11px]">
                          Selected with <?= (int) $approved_route->vote_count; ?> votes
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>

                <?php else: ?>
                  <!-- ================= PENDING ROUTE SUGGESTIONS & VOTING ================= -->
                  <?php
                  $routes = $CI->db->where('ride_id', $ride->id)
                    ->where('status', 'pending')
                    ->order_by('id', 'asc')
                    ->get('routes')
                    ->result();
                  ?>

                  <?php if (empty($routes)): ?>
                    <div class="bg-asphalt-900/50 p-6 rounded-xl border border-asphalt-800/60 text-center">
                      <p class="text-sm text-chrome-200/50 italic">No route suggestions submitted yet.</p>
                      <button
                        @click="activeRideId = <?= $ride->id; ?>; activeRideTitle = '<?= htmlspecialchars(addslashes($ride->title)); ?>'; suggestModalOpen = true"
                        class="mt-3 text-xs font-display text-ember-500 hover:underline">
                        Be the first to suggest a route for this ride &rarr;
                      </button>
                    </div>
                  <?php else: ?>
                    <!-- Ride Scope Alpine State: Manages vote switching per ride -->
                    <div x-data="{
                      rideId: <?= (int) $ride->id; ?>,
                        votedRouteId: null,

                        init() {
                          this.loadVotedRoute();
                        },

                        getVoteCookie() {
                          const name = 'rideVote_' + this.rideId + '=';
                          const cookies = document.cookie ? document.cookie.split(';') : [];

                          for (let i = 0; i < cookies.length; i++) {
                            const cookie = cookies[i].trim();

                            if (cookie.indexOf(name) === 0) {
                              return decodeURIComponent(cookie.substring(name.length));
                            }
                          }

                          return null;
                        },

                        loadVotedRoute() {
                          const savedRouteId = this.getVoteCookie();
                          this.votedRouteId = savedRouteId ? Number(savedRouteId) : null;
                        },

                        refreshVotedRoute() {
                          this.loadVotedRoute();
                        },

                        setVotedRoute(routeId) {
                          this.votedRouteId = Number(routeId);

                          document.cookie =
                            'rideVote_' + this.rideId + '=' +
                            encodeURIComponent(routeId) +
                            '; path=/; max-age=31536000; SameSite=Lax';
                        },
                      syncVoteState(detail) {
                        if (!detail || Number(detail.rideId) !== Number(this.rideId)) return;
                        this.votedRouteId = detail.newRouteId ? Number(detail.newRouteId) : null;
                      }
                    }" @route-vote-sync.window="syncVoteState($event.detail)" @focus.window="refreshVotedRoute()"
                      @pageshow.window="refreshVotedRoute()" @storage.window="
                      if ($event.key === 'rideVoteSync' && $event.newValue) {
                        try {
                          const sync = JSON.parse($event.newValue);
                          syncVoteState(sync);
                        } catch (e) {}
                      }
                    " class="grid grid-cols-1 md:grid-cols-2 gap-4">

                      <?php foreach ($routes as $route): ?>
                        <?php
                        $route_map_target = !empty($route->map_embed_url) ? $route->map_embed_url : (!empty($route->map_url) ? $route->map_url : null);
                        ?>
                        <div x-data="{ 
                          routeId: <?= (int) $route->id; ?>,
                          voteCount: <?= (int) $route->vote_count; ?>,
                          get isVoted() {
                            return Number(votedRouteId) === Number(this.routeId);
                          }
                        }"
                          class="flex flex-col justify-between bg-asphalt-900 p-5 rounded-xl border border-asphalt-800/90 hover:border-asphalt-700 transition-all shadow-md">

                          <div class="space-y-3 mb-4">
                            <div class="flex items-start justify-between gap-3">
                              <h4 class="font-display font-bold text-lg text-white leading-snug">
                                <?= htmlspecialchars($route->route_name); ?>
                              </h4>

                              <!-- Map Link Button -->
                              <?php if (!empty($route_map_target)): ?>
                                <a href="<?= htmlspecialchars($route_map_target); ?>" target="_blank" rel="noopener noreferrer"
                                  class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-asphalt-950 border border-asphalt-800 hover:border-ember-500/50 text-xs font-medium text-ember-500 rounded-lg transition-colors flex-shrink-0 shadow-xs">
                                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                  </svg>
                                  <span>View Map</span>
                                  <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                  </svg>
                                </a>
                              <?php endif; ?>
                            </div>

                            <!-- Route Map Embed Preview (If Embed URL Available) -->
                            <?php if (!empty($route->map_embed_url) && (strpos($route->map_embed_url, 'pb=') !== false || strpos($route->map_embed_url, '/embed') !== false)): ?>
                              <div class="w-full h-32 rounded-lg overflow-hidden border border-asphalt-800 bg-asphalt-950">
                                <iframe src="<?= htmlspecialchars($route->map_embed_url); ?>" class="w-full h-full border-0"
                                  allowfullscreen="" loading="lazy"></iframe>
                              </div>
                            <?php endif; ?>

                            <!-- Waypoints/Details -->
                            <?php if (!empty($route->start_point) && !empty($route->end_point)): ?>
                              <div class="text-xs text-chrome-200/70 flex items-center gap-1.5">
                                <span class="text-white font-medium"><?= htmlspecialchars($route->start_point); ?></span>
                                <span class="text-ember-500">&rarr;</span>
                                <span class="text-white font-medium"><?= htmlspecialchars($route->end_point); ?></span>
                              </div>
                            <?php endif; ?>

                            <?php if (!empty($route->route_details)): ?>
                              <p class="text-xs text-chrome-200/70 leading-relaxed">
                                <?= htmlspecialchars($route->route_details); ?>
                              </p>
                            <?php endif; ?>
                          </div>

                          <!-- Vote Action Footer -->
                          <div class="pt-3 border-t border-asphalt-800/60 flex items-center justify-between">
                            <span class="text-xs text-chrome-200/50 font-display">
                              Team Interest
                            </span>

                            <button @click="
                            if (!isVoted) {
                              const previousVotedId = votedRouteId;
                              fetch('<?= base_url('admin/vote_route/' . $route->id); ?>?previous_route_id=' + (previousVotedId || ''))
                                .then(res => {
                                  if (!res.ok) throw new Error('Network error');
                                  return res.json();
                                })
                                .then(data => {
                                  if (data.success) {
                                    voteCount = data.vote_count;
                                    setVotedRoute(routeId);

                                    // Synchronize the selected route and vote indicator across
                                    // Home and Ride Detail, including other open tabs.
                                    const syncData = {
                                      rideId: rideId,
                                      newRouteId: routeId,
                                      newVoteCount: data.vote_count,
                                      previousRouteId: previousVotedId || null,
                                      previousVoteCount: data.previous_vote_count
                                    };
                                    localStorage.setItem('rideVoteSync', JSON.stringify({
                                      rideId: syncData.rideId,
                                      newRouteId: syncData.newRouteId,
                                      newVoteCount: syncData.newVoteCount,
                                      previousRouteId: syncData.previousRouteId,
                                      previousVoteCount: syncData.previousVoteCount,
                                      timestamp: Date.now()
                                    }));
                                    $dispatch('route-vote-sync', syncData);
                                  }
                                })
                                .catch(err => console.error('Vote failed:', err));
                            }" @route-vote-changed.window="
                              if (Number($event.detail.rideId) === Number(rideId) && Number($event.detail.previousRouteId) === Number(routeId)) {
                                voteCount = $event.detail.previousVoteCount !== null && $event.detail.previousVoteCount !== undefined
                                  ? $event.detail.previousVoteCount
                                  : Math.max(0, voteCount - 1);
                              }
                            " @route-vote-sync.window="
                              if (Number($event.detail.rideId) === Number(rideId)) {
                                if (Number($event.detail.newRouteId) === Number(routeId)) {
                                  voteCount = $event.detail.newVoteCount;
                                } else if (Number($event.detail.previousRouteId) === Number(routeId) && $event.detail.previousVoteCount !== null && $event.detail.previousVoteCount !== undefined) {
                                  voteCount = $event.detail.previousVoteCount;
                                }
                              }
                            " @storage.window="
                              if ($event.key === 'rideVoteSync' && $event.newValue) {
                                try {
                                  const sync = JSON.parse($event.newValue);
                                  if (sync.rideId === rideId) {
                                    if (sync.newRouteId === routeId) voteCount = sync.newVoteCount;
                                    if (sync.previousRouteId === routeId && sync.previousVoteCount !== null && sync.previousVoteCount !== undefined) voteCount = sync.previousVoteCount;
                                  }
                                } catch (e) {}
                              }
                            "
                              :class="isVoted 
                              ? 'bg-ember-500 text-asphalt-950 border-ember-500 shadow-lg shadow-ember-500/20 cursor-default' 
                              : 'bg-asphalt-950 hover:bg-ember-500/10 hover:border-ember-500/50 text-chrome-200 hover:text-ember-500 border-asphalt-800 active:scale-95'"
                              class="flex items-center gap-2 px-4 py-2 rounded-xl border transition-all font-display font-bold text-sm">

                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
                              </svg>

                              <span x-text="isVoted ? 'VOTED' : 'VOTE'"></span>
                              <span class="ml-1 px-2 py-0.5 rounded-md bg-asphalt-900/60 text-xs" x-text="voteCount"></span>
                            </button>
                          </div>

                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>

            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ================= LATEST RIDES ================= -->
  <section class="max-w-6xl mx-auto px-5 py-24">
    <div class="flex items-end justify-between mb-12">
      <div>
        <h2 class="font-display text-xs font-bold tracking-[0.25em] text-ember-600 uppercase mb-2">On the Logbook</h2>
        <p class="font-display text-3xl md:text-4xl font-bold text-asphalt-900">Latest Rides</p>
      </div>
      <a href="<?= base_url('rides/past'); ?>"
        class="hidden sm:inline-flex items-center gap-2 text-sm font-display tracking-wide text-ember-600 hover:text-ember-700 font-semibold">
        <span>View all</span> &rarr;
      </a>
    </div>

    <?php if (empty($past_rides)): ?>
      <p class="text-asphalt-700/60">No rides logged yet.</p>
    <?php else: ?>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($past_rides as $ride): ?>
          <a href="<?= base_url('rides/' . $ride->id); ?>"
            class="block bg-white rounded-2xl overflow-hidden border border-asphalt-800/10 hover:border-ember-500/50 transition-all shadow-xs hover:shadow-lg group">
            <div class="h-48 bg-asphalt-900 relative overflow-hidden">
              <img src="<?= upload_url('rides', $ride->cover_image); ?>" alt="<?= htmlspecialchars($ride->title); ?>"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">

              <div
                class="hidden absolute inset-0 flex flex-col items-center justify-center bg-asphalt-900 text-chrome-200/40">
                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-xs font-display tracking-wider">NO IMAGE LOGGED</span>
              </div>
            </div>
            <div class="p-6">
              <p class="font-display text-ember-600 text-xs font-bold tracking-widest uppercase mb-2">
                <?= strtoupper(date('M j, Y', strtotime($ride->ride_date))); ?>
              </p>
              <h3 class="font-display text-xl font-bold text-asphalt-900 group-hover:text-ember-600 transition-colors">
                <?= htmlspecialchars($ride->title); ?>
              </h3>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- ================= TEAM PREVIEW ================= -->
  <section class="bg-paper-50 border-t border-asphalt-800/10 py-24">
    <div class="max-w-6xl mx-auto px-5">
      <div class="flex items-end justify-between mb-12">
        <div>
          <h2 class="font-display text-xs font-bold tracking-[0.25em] text-ember-600 uppercase mb-2">Who Rides With Us
          </h2>
          <p class="font-display text-3xl md:text-4xl font-bold text-asphalt-900">The Team</p>
        </div>
        <a href="<?= base_url('members'); ?>"
          class="hidden sm:inline-flex items-center gap-2 text-sm font-display tracking-wide text-ember-600 hover:text-ember-700 font-semibold">
          <span>Full roster</span> &rarr;
        </a>
      </div>

      <div class="team-preview-grid grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-6">
        <?php
        $shown = array_slice($members, 0, 18);
        foreach ($shown as $m):
          ?>
          <div class="text-center group min-w-0">
            <div
              class="relative w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-full overflow-hidden bg-asphalt-900 mb-3 border-2 border-asphalt-800/10 group-hover:border-ember-500 transition-colors shadow-md">
              <img src="<?= upload_url('members', $m->image); ?>" alt="<?= htmlspecialchars($m->full_name); ?>"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">

              <div
                class="hidden absolute inset-0 flex items-center justify-center bg-asphalt-900 text-ember-500 font-display font-bold text-xl">
                <?= strtoupper(substr($m->road_name ?: $m->full_name, 0, 2)); ?>
              </div>
            </div>

            <p
              class="font-display font-bold text-sm text-asphalt-900 group-hover:text-ember-600 transition-colors truncate">
              <?= htmlspecialchars($m->road_name ?: $m->full_name); ?>
            </p>

            <p class="text-[10px] text-asphalt-700/60 uppercase font-semibold tracking-wider mt-0.5 truncate">
              <?= htmlspecialchars($m->position); ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>


    </div>
  </section>

  <!-- ================= GALLERY PREVIEW ================= -->
  <?php
    $gallery_items_per_page = 12;
    $gallery_total_items = count($gallery ?? []);
    $gallery_total_pages = max(1, (int) ceil($gallery_total_items / $gallery_items_per_page));
    $gallery_current_page = isset($_GET['gallery_page']) ? (int) $_GET['gallery_page'] : 1;
    $gallery_current_page = max(1, min($gallery_current_page, $gallery_total_pages));
    $gallery_query = $_GET;
    unset($gallery_query['gallery_page']);
    $gallery_query_string = http_build_query($gallery_query);
    $gallery_offset = ($gallery_current_page - 1) * $gallery_items_per_page;
    $home_gallery = array_slice($gallery ?? [], $gallery_offset, $gallery_items_per_page);
  ?>
  <?php if (!empty($gallery)): ?>
    <section id="ride-gallery" class="max-w-6xl mx-auto px-5 py-24 scroll-mt-24">
      <div class="flex items-end justify-between mb-12">
        <div>
          <h2 class="font-display text-xs font-bold tracking-[0.25em] text-ember-600 uppercase mb-2">From the Road</h2>
          <p class="font-display text-3xl md:text-4xl font-bold text-asphalt-900">Ride Gallery</p>
        </div>
        <a href="<?= base_url('gallery'); ?>"
          class="hidden sm:inline-flex items-center gap-2 text-sm font-display tracking-wide text-ember-600 hover:text-ember-700 font-semibold transition-colors duration-200">
          <span>View gallery</span> &rarr;
        </a>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
        <?php foreach ($home_gallery as $index => $g): ?>
          <?php $img_url = upload_url('gallery', $g->image); ?>
          <div
            class="group relative aspect-square rounded-xl overflow-hidden bg-asphalt-900 cursor-pointer border border-asphalt-800/20 shadow-xs hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
            @click="currentIndex = <?= $index; ?>; lightboxOpen = true">

            <img src="<?= $img_url; ?>" alt="<?= htmlspecialchars($g->caption ?? ''); ?>"
              class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-110"
              onerror="this.parentElement.style.display='none'">

            <div
              class="absolute inset-0 bg-asphalt-950/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center p-2 text-center">
              <div
                class="w-8 h-8 rounded-full bg-ember-500/90 text-asphalt-950 flex items-center justify-center transform scale-50 group-hover:scale-100 transition-all duration-300 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                </svg>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if ($gallery_total_pages > 1): ?>
        <div class="mt-10 flex items-center justify-center gap-1.5">
          <?php if ($gallery_current_page > 1): ?>
            <a href="?<?= $gallery_query_string ? $gallery_query_string . '&' : ''; ?>gallery_page=<?= $gallery_current_page - 1; ?>#ride-gallery"
              class="px-3 py-2 rounded-lg border border-asphalt-800/10 bg-white text-asphalt-900 font-display text-[10px] font-bold uppercase hover:border-ember-500 hover:text-ember-600 transition-all shadow-2xs">
              &larr; Prev
            </a>
          <?php endif; ?>
          <div class="flex items-center gap-1">
            <?php for ($gp = 1; $gp <= $gallery_total_pages; $gp++): ?>
              <?php if ($gp === $gallery_current_page): ?>
                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-ember-500 text-asphalt-950 font-display font-bold text-[10px]">
                  <?= $gp; ?>
                </span>
              <?php else: ?>
                <a href="?<?= $gallery_query_string ? $gallery_query_string . '&' : ''; ?>gallery_page=<?= $gp; ?>#ride-gallery"
                  class="w-8 h-8 flex items-center justify-center rounded-lg border border-asphalt-800/10 bg-white text-asphalt-900 font-display font-bold text-[10px] hover:border-ember-500 hover:text-ember-600 transition-all">
                  <?= $gp; ?>
                </a>
              <?php endif; ?>
            <?php endfor; ?>
          </div>
          <?php if ($gallery_current_page < $gallery_total_pages): ?>
            <a href="?<?= $gallery_query_string ? $gallery_query_string . '&' : ''; ?>gallery_page=<?= $gallery_current_page + 1; ?>#ride-gallery"
              class="px-3 py-2 rounded-lg border border-asphalt-800/10 bg-white text-asphalt-900 font-display text-[10px] font-bold uppercase hover:border-ember-500 hover:text-ember-600 transition-all shadow-2xs">
              Next &rarr;
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <!-- ================= CTA: SUBMIT PHOTO ================= -->
  <section class="bg-asphalt-950 text-chrome-200 py-16 border-t border-asphalt-800">
    <div class="max-w-6xl mx-auto px-5 flex flex-col md:flex-row items-center justify-between gap-6">
      <div>
        <p class="font-display text-2xl font-bold text-white">Got a shot from a ride?</p>
        <p class="text-chrome-200/60 mt-1 text-sm">Send it in — approved photos get featured in the main gallery.</p>
      </div>
      <button type="button" @click="submitPhotoModalOpen = true"
        class="px-7 py-3.5 bg-ember-500 hover:bg-ember-600 text-asphalt-950 font-display font-bold text-sm tracking-wider uppercase rounded-xl transition-all shadow-md active:scale-95 whitespace-nowrap">
        Submit a Photo
      </button>
    </div>
  </section>

  <!-- ================= SUBMIT PHOTO MODAL ================= -->
  <div x-cloak x-show="submitPhotoModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition.opacity @keydown.escape.window="submitPhotoModalOpen = false">
    <div class="absolute inset-0 bg-asphalt-950/70 backdrop-blur-sm" @click="submitPhotoModalOpen = false"></div>
    <div class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-2xl bg-white text-asphalt-900 shadow-2xl" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="flex items-center justify-between border-b border-asphalt-800/10 px-6 py-4">
        <div><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ember-600">Share a Moment</p><h2 class="font-display text-xl font-bold">Submit Photos</h2></div>
        <button type="button" @click="submitPhotoModalOpen = false" class="rounded-lg p-2 text-asphalt-700/50 hover:bg-asphalt-900/10 hover:text-asphalt-900" aria-label="Close modal">&times;</button>
      </div>
      <form action="<?= base_url('gallery/submit'); ?>" method="post" enctype="multipart/form-data" class="space-y-4 p-6" x-data="{ files: [], previews: [], select(e) { this.files = Array.from(e.target.files); this.previews = this.files.map(f => URL.createObjectURL(f)); }, remove(i) { URL.revokeObjectURL(this.previews[i]); this.files.splice(i,1); this.previews.splice(i,1); const dt = new DataTransfer(); this.files.forEach(f => dt.items.add(f)); this.$refs.input.files = dt.files; } }">
        <div><label for="home_submitter_name" class="mb-1 block text-xs font-bold">Your Name *</label><input id="home_submitter_name" type="text" name="submitter_name" required maxlength="120" class="w-full rounded-lg border border-asphalt-800/20 px-3 py-2 text-sm outline-none focus:border-ember-500"></div>
        <div><label for="home_submitter_email" class="mb-1 block text-xs font-bold">Email (optional)</label><input id="home_submitter_email" type="email" name="submitter_email" maxlength="150" class="w-full rounded-lg border border-asphalt-800/20 px-3 py-2 text-sm outline-none focus:border-ember-500"></div>
        <div><label for="home_caption" class="mb-1 block text-xs font-bold">Caption / Note (optional)</label><input id="home_caption" type="text" name="caption" maxlength="255" placeholder="Where were these photos taken?" class="w-full rounded-lg border border-asphalt-800/20 px-3 py-2 text-sm outline-none focus:border-ember-500"></div>
        <div><label for="home_images" class="mb-1 block text-xs font-bold">Photos *</label><input id="home_images" x-ref="input" @change="select($event)" type="file" name="images[]" accept="image/png,image/jpeg,image/webp" multiple required class="w-full rounded-lg border border-asphalt-800/20 p-2 text-xs"><p class="mt-1 text-[10px] text-asphalt-700/60">JPG, PNG or WEBP up to 5MB each.</p></div>
        <div x-show="previews.length" class="grid grid-cols-4 gap-2 rounded-lg bg-paper-50 p-2"><template x-for="(src,i) in previews" :key="i"><div class="relative aspect-square overflow-hidden rounded-md"><img :src="src" class="h-full w-full object-cover"><button type="button" @click="remove(i)" class="absolute right-1 top-1 rounded-full bg-black/70 px-1.5 text-white">&times;</button></div></template></div>
        <button type="submit" @click="submittingPhoto = true" :disabled="submittingPhoto" class="w-full rounded-lg bg-ember-500 py-3 text-xs font-bold uppercase tracking-wider text-asphalt-950 hover:bg-ember-600 disabled:opacity-70 disabled:cursor-not-allowed transition-all">
          <span x-show="!submittingPhoto">Submit Photos for Review</span>
          <span x-show="submittingPhoto" class="inline-flex items-center justify-center gap-2">
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path></svg>
            Submitting Photo...
          </span>
        </button>
      </form>
    </div>
  </div>

  <!-- ================= SUGGEST ROUTE MODAL ================= -->
  <div x-cloak x-show="suggestModalOpen"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>

    <div class="absolute inset-0 bg-asphalt-950/60" @click="suggestModalOpen = false"></div>

    <div
      class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden border border-asphalt-800/10 text-asphalt-900"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Modal Header -->
      <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10 bg-asphalt-900/5">
        <div>
          <h3 class="font-display font-semibold text-base text-asphalt-900">Suggest a Route</h3>
          <p class="text-xs text-asphalt-700/60"
            x-text="activeRideTitle ? `For ride: ${activeRideTitle}` : 'Team Route Suggestion'"></p>
        </div>
        <button type="button" @click="suggestModalOpen = false"
          class="p-1 text-asphalt-700/40 hover:text-asphalt-900 hover:bg-asphalt-900/10 rounded-lg transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Form Body -->
      <div class="p-6 overflow-y-auto">
        <form action="<?= base_url('suggest_route'); ?>" method="post" enctype="multipart/form-data" class="space-y-4">

          <!-- Attached Ride Binding -->
          <input type="hidden" name="ride_id" :value="activeRideId">

          <!-- Route Name -->
          <div>
            <label class="block text-xs font-medium text-asphalt-900 mb-1">Route name *</label>
            <input type="text" name="route_name" required maxlength="180" placeholder="e.g. Highway-Coastal Loop"
              class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors">
          </div>

          <!-- Start & End Waypoints -->
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-medium text-asphalt-900 mb-1">Start point *</label>
              <input type="text" name="start_point" required maxlength="200" placeholder="e.g. City Plaza"
                class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors">
            </div>
            <div>
              <label class="block text-xs font-medium text-asphalt-900 mb-1">End point *</label>
              <input type="text" name="end_point" required maxlength="200" placeholder="e.g. Mountain Summit"
                class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors">
            </div>
          </div>

          <!-- Waypoints / Stops -->
          <div>
            <label class="block text-xs font-medium text-asphalt-900 mb-1">Waypoints / stops (one per line)</label>
            <textarea name="waypoints" rows="2" placeholder="Pitstop 1: Vista Point&#10;Pitstop 2: Gas Station"
              class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors"></textarea>
          </div>

          <!-- Distance, Duration, Difficulty -->
          <div class="grid grid-cols-3 gap-3">
            <div>
              <label class="block text-xs font-medium text-asphalt-900 mb-1">Distance (km)</label>
              <input type="number" step="0.01" name="distance_km" placeholder="45.5"
                class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors">
            </div>
            <div>
              <label class="block text-xs font-medium text-asphalt-900 mb-1">Est. duration</label>
              <input type="text" name="estimated_duration" placeholder="e.g. 2h 30m"
                class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors">
            </div>
            <div>
              <label class="block text-xs font-medium text-asphalt-900 mb-1">Difficulty *</label>
              <select name="difficulty" required
                class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors bg-white">
                <option value="easy">Easy</option>
                <option value="moderate" selected>Moderate</option>
                <option value="hard">Hard</option>
              </select>
            </div>
          </div>

          <!-- Google Maps URL -->
          <div>
            <label class="block text-xs font-medium text-asphalt-900 mb-1">Google Maps embed / share URL</label>
            <input type="url" name="map_embed_url" placeholder="https://maps.google.com/..."
              class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors">
          </div>

          <!-- Image Upload -->
          <div>
            <label class="block text-xs font-medium text-asphalt-900 mb-1">Route map image (optional)</label>
            <input type="file" name="route_image" accept="image/png,image/jpeg,image/webp"
              class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-1.5 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-asphalt-900/10 file:text-asphalt-900 file:font-semibold hover:file:bg-asphalt-900/20 transition-all">
          </div>

          <!-- Rider Notes -->
          <div>
            <label class="block text-xs font-medium text-asphalt-900 mb-1">Notes for riders</label>
            <textarea name="notes" rows="2" placeholder="Mention road conditions, scenic spots, or hazards..."
              class="w-full text-xs border border-asphalt-800/20 rounded-xl px-3 py-2 focus:border-ember-500 outline-none transition-colors"></textarea>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center justify-end gap-3 pt-3 border-t border-asphalt-800/10 mt-2">
            <button type="button" @click="suggestModalOpen = false"
              class="px-4 py-2 text-xs font-semibold text-asphalt-700 hover:text-asphalt-900 bg-asphalt-900/5 hover:bg-asphalt-900/10 rounded-xl transition-colors">
              Cancel
            </button>
            <button type="submit"
              class="px-5 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95">
              Submit Route Suggestion
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

  <!-- ================= LIGHTBOX PREVIEW MODAL ================= -->
  <div x-cloak x-show="lightboxOpen" x-data="{
      zoom: 1,
      panX: 0,
      panY: 0,
      isDragging: false,
      startX: 0,
      startY: 0,
      resetZoom() {
        this.zoom = 1;
        this.panX = 0;
        this.panY = 0;
      },
      toggleZoom(e) {
        if (this.zoom > 1) {
          this.resetZoom();
        } else {
          this.zoom = 2.5;
          const rect = e.currentTarget.getBoundingClientRect();
          this.panX = (rect.width / 2 - (e.clientX - rect.left)) * 1.5;
          this.panY = (rect.height / 2 - (e.clientY - rect.top)) * 1.5;
        }
      },
      startDrag(e) {
        if (this.zoom <= 1) return;
        this.isDragging = true;
        this.startX = e.clientX - this.panX;
        this.startY = e.clientY - this.panY;
      },
      drag(e) {
        if (!this.isDragging) return;
        this.panX = e.clientX - this.startX;
        this.panY = e.clientY - this.startY;
      },
      stopDrag() {
        this.isDragging = false;
      }
    }" x-effect="if(currentIndex !== null || !lightboxOpen) resetZoom()"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none"
    x-transition:enter-end="opacity-100 backdrop-blur-md" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 backdrop-blur-md" x-transition:leave-end="opacity-0 backdrop-blur-none"
    @keydown.escape.window="lightboxOpen = false; resetZoom();"
    @keydown.arrow-right.window="if(lightboxOpen && items.length) { currentIndex = (currentIndex + 1) % items.length; resetZoom(); }"
    @keydown.arrow-left.window="if(lightboxOpen && items.length) { currentIndex = (currentIndex - 1 + items.length) % items.length; resetZoom(); }"
    class="fixed inset-0 z-50 flex items-center justify-center bg-asphalt-950/80 p-4 select-none">

    <div @click.away="lightboxOpen = false; resetZoom();" x-show="lightboxOpen"
      x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-2"
      x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100 translate-y-0"
      x-transition:leave-end="opacity-0 scale-95 translate-y-2"
      class="max-w-4xl w-full flex flex-col items-center relative">

      <div
        class="relative max-h-[80vh] rounded-2xl overflow-hidden border border-asphalt-800/80 shadow-2xl bg-asphalt-900 group">

        <div
          class="absolute top-3 left-3 flex items-center gap-1 z-30 bg-asphalt-950/70 p-1 rounded-lg border border-asphalt-800/80 backdrop-blur-xs">
          <button @click.stop="zoom = Math.min(zoom + 0.5, 4)"
            class="p-1.5 text-chrome-200 hover:text-white transition-colors" title="Zoom In">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
          </button>
          <button @click.stop="zoom = Math.max(zoom - 0.5, 1); if(zoom === 1) resetZoom();"
            class="p-1.5 text-chrome-200 hover:text-white transition-colors" title="Zoom Out">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
          </button>
          <button @click.stop="resetZoom()"
            class="p-1.5 text-chrome-200 hover:text-white text-[10px] font-display font-bold uppercase px-1.5 transition-colors"
            title="Reset Zoom">
            Reset
          </button>
        </div>

        <button @click.stop="lightboxOpen = false; resetZoom();"
          class="absolute top-3 right-3 p-2.5 text-chrome-200 hover:text-white bg-asphalt-950/70 hover:bg-asphalt-900 rounded-full border border-asphalt-800/80 transition-all duration-200 z-30 shadow-md active:scale-90"
          aria-label="Close preview">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <button @click.stop="currentIndex = (currentIndex - 1 + items.length) % items.length; resetZoom();"
          class="absolute left-3 top-1/2 -translate-y-1/2 p-2.5 text-chrome-200 hover:text-white bg-asphalt-950/70 hover:bg-asphalt-900 rounded-full border border-asphalt-800/80 transition-all duration-200 z-30 shadow-md active:scale-90 opacity-80 hover:opacity-100"
          aria-label="Previous image">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>

        <button @click.stop="currentIndex = (currentIndex + 1) % items.length; resetZoom();"
          class="absolute right-3 top-1/2 -translate-y-1/2 p-2.5 text-chrome-200 hover:text-white bg-asphalt-950/70 hover:bg-asphalt-900 rounded-full border border-asphalt-800/80 transition-all duration-200 z-30 shadow-md active:scale-90 opacity-80 hover:opacity-100"
          aria-label="Next image">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>

        <div class="overflow-hidden cursor-grab active:cursor-grabbing" @dblclick="toggleZoom($event)"
          @mousedown="startDrag($event)" @mousemove.window="drag($event)" @mouseup.window="stopDrag()"
          @wheel.prevent="if($event.deltaY < 0) { zoom = Math.min(zoom + 0.2, 4); } else { zoom = Math.max(zoom - 0.2, 1); if(zoom === 1) resetZoom(); }">
          <template x-if="items.length > 0">
            <img :src="items[currentIndex].src" :alt="items[currentIndex].caption"
              :style="`transform: scale(${zoom}) translate(${panX / zoom}px, ${panY / zoom}px); transition: ${isDragging ? 'none' : 'transform 0.2s ease-out'};`"
              class="max-h-[80vh] w-auto object-contain block mx-auto pointer-events-none select-none">
          </template>
        </div>
      </div>

      <div class="mt-4 flex flex-col items-center gap-1 text-center">
        <p x-text="items[currentIndex] ? items[currentIndex].caption : ''"
          class="font-display text-sm tracking-wide text-chrome-200/90 max-w-xl min-h-[1.25rem]"></p>
        <span x-text="`${currentIndex + 1} / ${items.length}`"
          class="text-[11px] font-display font-semibold uppercase tracking-widest text-chrome-200/50"></span>
      </div>

    </div>
  </div>
</div>