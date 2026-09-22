<!-- Hero Banner -->
<section class="bg-asphalt-950 text-white py-16 md:py-20 relative overflow-hidden border-b border-asphalt-800/20">
  <div class="absolute -top-24 right-0 w-96 h-96 bg-ember-500/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="max-w-4xl mx-auto px-5 relative z-10">
    <!-- Badge & Time Banner -->
    <div class="flex flex-wrap items-center gap-3 mb-4">
      <div><?= ride_badge($ride->ride_type); ?></div>
      <span class="text-asphalt-700">•</span>
      <p class="font-display text-ember-400 tracking-[0.2em] text-xs font-semibold uppercase">
        <?= strtoupper(date('l, F j, Y', strtotime($ride->ride_date))); ?><?= $ride->ride_time ? ' — ' . date('g:i A', strtotime($ride->ride_time)) : ''; ?>
      </p>
    </div>

    <h1 class="font-display font-semibold text-3xl sm:text-4xl md:text-5xl text-white leading-tight tracking-tight">
      <?= htmlspecialchars($ride->title); ?>
    </h1>

    <?php if (!empty($ride->meeting_point)): ?>
      <div
        class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-asphalt-900 border border-asphalt-800/60 text-xs md:text-sm text-asphalt-300">
        <svg class="w-4 h-4 text-ember-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Meeting point: <strong
            class="text-white font-medium"><?= htmlspecialchars($ride->meeting_point); ?></strong></span>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Cover Image Offset Frame -->
<?php if (!empty($ride->cover_image)): ?>
  <div class="max-w-4xl mx-auto px-5">
    <div
      class="w-full h-72 md:h-96 rounded-2xl overflow-hidden bg-asphalt-900 -mt-10 md:-mt-14 shadow-xl border border-white/10 relative z-20">
      <img src="<?= upload_url('rides', $ride->cover_image); ?>" alt="<?= htmlspecialchars($ride->title); ?>"
        class="w-full h-full object-cover">
    </div>
  </div>
<?php endif; ?>

<!-- Ride Details & Route Section -->
<section class="max-w-4xl mx-auto px-5 pb-16 <?= empty($ride->cover_image) ? 'pt-12' : 'pt-10'; ?>">
  <!-- Route Overview (Requires approved status) -->
  <?php if (!empty($ride->route_name) && isset($ride->route_status) && strtolower($ride->route_status) === 'approved'): ?>
    <div class="border-t border-asphalt-800/10 pt-10">
      <div class="flex items-center gap-3 mb-2">
        <span class="w-8 h-0.5 bg-ember-500"></span>
        <p class="font-display text-xs font-semibold tracking-[0.25em] uppercase text-ember-600">The Route</p>
      </div>
      <h2 class="font-display text-2xl md:text-3xl font-semibold text-asphalt-900 mb-6">
        <?= htmlspecialchars($ride->route_name); ?>
      </h2>

      <!-- Metrics Card -->
      <div class="bg-white border border-asphalt-800/10 rounded-2xl p-6 shadow-xs mb-8">

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pb-6 border-b border-asphalt-800/10">

          <!-- Start Point -->
          <div class="flex items-start gap-3">
            <div class="p-2 rounded-lg bg-asphalt-100/70 text-asphalt-800 shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              </svg>
            </div>
            <div>
              <p class="text-[10px] font-semibold uppercase tracking-wider text-asphalt-700/60">Start Point</p>
              <p class="text-sm font-semibold text-asphalt-900 mt-0.5 leading-snug">
                <?= htmlspecialchars($ride->start_point); ?>
              </p>
            </div>
          </div>

          <!-- End Point -->
          <div class="flex items-start gap-3">
            <div class="p-2 rounded-lg bg-asphalt-100/70 text-asphalt-800 shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-asphalt-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div>
              <p class="text-[10px] font-semibold uppercase tracking-wider text-asphalt-700/60">End Point</p>
              <p class="text-sm font-semibold text-asphalt-900 mt-0.5 leading-snug">
                <?= htmlspecialchars($ride->end_point); ?>
              </p>
            </div>
          </div>

          <!-- Distance -->
          <?php if (!empty($ride->distance_km)): ?>
            <div class="flex items-start gap-3">
              <div class="p-2 rounded-lg bg-asphalt-100/70 text-asphalt-800 shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
              </div>
              <div>
                <p class="text-[10px] font-semibold uppercase tracking-wider text-asphalt-700/60">Distance</p>
                <p class="text-sm font-semibold text-asphalt-900 mt-0.5 leading-snug">
                  <?= htmlspecialchars($ride->distance_km); ?> km
                </p>
              </div>
            </div>
          <?php endif; ?>

          <!-- Duration -->
          <?php if (!empty($ride->estimated_duration)): ?>
            <div class="flex items-start gap-3">
              <div class="p-2 rounded-lg bg-asphalt-100/70 text-asphalt-800 shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-asphalt-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <p class="text-[10px] font-semibold uppercase tracking-wider text-asphalt-700/60">Est. Duration</p>
                <p class="text-sm font-semibold text-asphalt-900 mt-0.5 leading-snug">
                  <?= htmlspecialchars($ride->estimated_duration); ?>
                </p>
              </div>
            </div>
          <?php endif; ?>

        </div>

        <!-- Waypoints List -->
        <?php if (!empty($ride->waypoints)): ?>
          <div class="pt-5">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-asphalt-700/60 mb-3">Stops Along the Way</p>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <?php foreach (explode("\n", $ride->waypoints) as $wp):
                if (trim($wp) === '')
                  continue; ?>
                <li class="flex items-center gap-2.5 text-xs text-asphalt-800 font-medium">
                  <span class="w-2 h-2 rounded-full bg-ember-500 shrink-0"></span>
                  <span><?= htmlspecialchars(trim($wp)); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <!-- Difficulty Pill -->
        <?php if (!empty($ride->difficulty)): ?>
          <div class="mt-5 pt-4 border-t border-asphalt-800/10 flex items-center justify-between">
            <span class="text-xs text-asphalt-700/60 font-medium">Ride Intensity</span>
            <span
              class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-ember-50 text-ember-700 border border-ember-200">
              <?= htmlspecialchars($ride->difficulty); ?> Difficulty
            </span>
          </div>
        <?php endif; ?>

      </div>

      <!-- Route Graphic/Image -->
      <?php if (!empty($ride->route_image)): ?>
        <div class="rounded-xl overflow-hidden border border-asphalt-800/10 bg-asphalt-950 mb-6 shadow-xs">
          <img src="<?= upload_url('routes', $ride->route_image); ?>"
            alt="Route map for <?= htmlspecialchars($ride->route_name); ?>" class="w-full h-auto">
        </div>
      <?php endif; ?>

      <!-- Redirect Map Button -->
      <?php if (!empty($ride->map_embed_url)): ?>
        <a href="<?= htmlspecialchars($ride->map_embed_url); ?>" target="_blank" rel="noopener noreferrer"
          class="group flex items-center justify-between p-5 rounded-xl border border-asphalt-800/20 bg-asphalt-950 text-white hover:border-ember-500/80 hover:bg-asphalt-900 transition-all shadow-md">
          <div class="flex items-center gap-4">
            <div
              class="p-3 rounded-lg bg-ember-500/10 text-ember-500 group-hover:bg-ember-500 group-hover:text-white transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
              </svg>
            </div>
            <div>
              <h4 class="font-display font-semibold text-base text-white group-hover:text-ember-400 transition-colors">View
                Live Navigation Map</h4>
              <p class="text-xs text-asphalt-400">Open route in Google Maps / Navigation app</p>
            </div>
          </div>

          <div
            class="flex items-center gap-2 text-xs font-display uppercase tracking-wider font-semibold text-ember-400 group-hover:translate-x-1 transition-transform">
            <span>Open Map</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </div>
        </a>
      <?php endif; ?>

    </div>
  <?php else: ?>
    <!-- Pending Route Suggestions & Voting -->
    <div class="border-t border-asphalt-800/10 pt-10">
      <div class="flex items-center gap-3 mb-2">
        <span class="w-8 h-0.5 bg-ember-500"></span>
        <p class="font-display text-xs font-semibold tracking-[0.25em] uppercase text-ember-600">Route Voting</p>
      </div>
      <h2 class="font-display text-2xl md:text-3xl font-semibold text-asphalt-900 mb-2">Choose the Ride Route</h2>
      <p class="text-sm text-asphalt-700/70 mb-6">Vote for the route you want the team to take. You can vote for one route per ride on this browser.</p>

      <?php if (!empty($pending_routes)): ?>
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

            this.votedRouteId =
              detail.newRouteId ? Number(detail.newRouteId) : null;
          }
        }"
        class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <?php foreach ($pending_routes as $route): ?>
            <?php $route_map_target = !empty($route->map_embed_url) ? $route->map_embed_url : (!empty($route->map_url) ? $route->map_url : null); ?>
            <div x-data="{
              routeId: <?= (int) $route->id; ?>,
              voteCount: <?= (int) $route->vote_count; ?>,
              voting: false,
              get isVoted() { return Number(votedRouteId) === Number(this.routeId); }
            }"
              class="flex flex-col justify-between bg-asphalt-900 p-5 rounded-xl border border-asphalt-800/90 hover:border-asphalt-700 transition-all shadow-md">

              <div class="space-y-3 mb-4">
                <div class="flex items-start justify-between gap-3">
                  <h4 class="font-display font-bold text-lg text-white leading-snug"><?= htmlspecialchars($route->route_name); ?></h4>
                  <?php if (!empty($route_map_target)): ?>
                    <a href="<?= htmlspecialchars($route_map_target); ?>" target="_blank" rel="noopener noreferrer"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-asphalt-950 border border-asphalt-800 hover:border-ember-500/50 text-xs font-medium text-ember-500 rounded-lg transition-colors flex-shrink-0">
                      <span>View Map</span>
                      <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                  <?php endif; ?>
                </div>

                <?php if (!empty($route->map_embed_url) && (strpos($route->map_embed_url, 'pb=') !== false || strpos($route->map_embed_url, '/embed') !== false)): ?>
                  <div class="w-full h-32 rounded-lg overflow-hidden border border-asphalt-800 bg-asphalt-950">
                    <iframe src="<?= htmlspecialchars($route->map_embed_url); ?>" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                  </div>
                <?php endif; ?>

                <?php if (!empty($route->start_point) && !empty($route->end_point)): ?>
                  <div class="text-xs text-chrome-200/70 flex items-center gap-1.5">
                    <span class="text-white font-medium"><?= htmlspecialchars($route->start_point); ?></span>
                    <span class="text-ember-500">&rarr;</span>
                    <span class="text-white font-medium"><?= htmlspecialchars($route->end_point); ?></span>
                  </div>
                <?php endif; ?>

                <?php if (!empty($route->route_details)): ?>
                  <p class="text-xs text-chrome-200/70 leading-relaxed"><?= htmlspecialchars($route->route_details); ?></p>
                <?php endif; ?>
              </div>

              <div class="pt-3 border-t border-asphalt-800/60 flex items-center justify-between">
                <span class="text-xs text-chrome-200/50 font-display">Team Interest</span>
                <button type="button"
                  @click="
                    if (!isVoted && !voting) {
                      voting = true;
                      const previousVotedId = votedRouteId;
                      fetch('<?= base_url('admin/vote_route/' . $route->id); ?>?previous_route_id=' + (previousVotedId || ''))
                        .then(res => { if (!res.ok) throw new Error('Network error'); return res.json(); })
                        .then(data => {
                          if (data.success) {
                            voteCount = data.vote_count;
                            setVotedRoute(routeId);

                            // Synchronize the selected route, vote count and VOTED
                            // indicator with Home and any other open Ride Detail tab.
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
                        .catch(err => console.error('Vote failed:', err))
                        .finally(() => voting = false);
                    }
                  "
                  @route-vote-changed.window="
                    if (Number($event.detail.rideId) === Number(rideId) && Number($event.detail.previousRouteId) === Number(routeId)) {
                      voteCount = $event.detail.previousVoteCount !== null && $event.detail.previousVoteCount !== undefined ? $event.detail.previousVoteCount : Math.max(0, voteCount - 1);
                    }
                  "
                  @route-vote-sync.window="
                    if (Number($event.detail.rideId) === Number(rideId)) {
                      if (Number($event.detail.newRouteId) === Number(routeId)) {
                        voteCount = $event.detail.newVoteCount;
                      } else if (Number($event.detail.previousRouteId) === Number(routeId) && $event.detail.previousVoteCount !== null && $event.detail.previousVoteCount !== undefined) {
                        voteCount = $event.detail.previousVoteCount;
                      }
                    }
                  "
                  @storage.window="
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
                  :disabled="isVoted || voting"
                  :class="isVoted ? 'bg-ember-500 text-asphalt-950 border-ember-500 shadow-lg shadow-ember-500/20 cursor-default' : 'bg-asphalt-950 hover:bg-ember-500/10 hover:border-ember-500/50 text-chrome-200 hover:text-ember-500 border-asphalt-800 active:scale-95'"
                  class="flex items-center gap-2 px-4 py-2 rounded-xl border transition-all font-display font-bold text-sm disabled:cursor-default">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" /></svg>
                  <span x-text="voting ? 'VOTING...' : (isVoted ? 'VOTED' : 'VOTE')"></span>
                  <span class="ml-1 px-2 py-0.5 rounded-md bg-asphalt-900/60 text-xs" x-text="voteCount"></span>
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Route Pending Approval — keep this notice visible regardless of voting options -->
      <div class="mt-8 relative overflow-hidden bg-gradient-to-r from-amber-950/40 via-asphalt-950 to-asphalt-950 border-2 border-amber-500/40 rounded-2xl p-6 md:p-8 shadow-lg shadow-amber-500/5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">

        <!-- Accent Warning Glow -->
        <div class="absolute -top-12 -left-12 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-start sm:items-center gap-4 relative z-10">
          <!-- Animated Pulsing Warning Icon -->
          <div class="relative shrink-0">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-xl bg-amber-400 opacity-20"></span>
            <div class="relative p-3.5 rounded-xl bg-ember-500 text-amber-400 border border-ember-500 shadow-inner">
              <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
          </div>

          <div>
            <div class="flex items-center gap-2 mb-1">
              <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
              <h3 class="font-display font-bold text-lg text-dark tracking-wide">Route Pending Approval</h3>
            </div>
            <p class="text-xs md:text-sm text-asphalt-300 leading-relaxed">
              The official route map and details for this ride are currently under review. Official waypoints and
              navigation links will be unlocked once approved.
            </p>
          </div>
        </div>

        <!-- Glowing Alert Badge -->
        <div class="relative z-10 self-start sm:self-center shrink-0">
          <span
            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-display font-bold uppercase tracking-widest bg-amber-500 text-amber-300 border border-amber-400/50 shadow-sm shadow-amber-500/20 whitespace-nowrap">
            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Pending Approval
          </span>
        </div>

        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Back Link Footer -->
  <div class="mt-12 pt-6 border-t border-asphalt-800/10">
    <a href="<?= base_url('rides'); ?>"
      class="inline-flex items-center gap-2 text-xs font-display font-semibold uppercase tracking-wider text-ember-600 hover:text-ember-700 transition-colors">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      <span>Back to all rides</span>
    </a>
  </div>
</section>