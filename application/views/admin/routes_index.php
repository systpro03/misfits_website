<div x-data="{ 
  modal: <?= htmlspecialchars(json_encode($open_modal), ENT_QUOTES); ?>, 
  delUrl: '', 
  delLabel: '',
  search: ''
}" x-cloak class="space-y-6">

  <!-- ==================== TOP ACTION & FILTER BAR ==================== -->
  <div
    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-asphalt-800/10 p-4 rounded-2xl shadow-xs">

    <!-- Title & Total Counter -->
    <div class="flex items-center gap-3">
      <div>
        <h1 class="text-lg font-display font-bold text-asphalt-900 tracking-tight">Routes Directory</h1>
        <p class="text-asphalt-700/60 text-xs">Manage planned routes, approve community suggestions, and track ride
          linkages.</p>
      </div>
      <span
        class="px-2.5 py-1 text-xs font-semibold text-asphalt-800 bg-asphalt-900/5 rounded-full border border-asphalt-800/10">
        <?= count($routes); ?> Total
      </span>
    </div>

    <!-- Right Controls: Search & Add Button -->
    <div class="flex items-center gap-3">
      <!-- Live Filter Search -->
      <div class="relative min-w-[200px] sm:min-w-[240px]">
        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-asphalt-700/40" fill="none"
          stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" x-model="search" placeholder="Search routes or waypoints..."
          class="w-full pl-9 pr-3 py-2 bg-asphalt-900/5 hover:bg-asphalt-900/10 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-transparent focus:border-ember-500/50 outline-none transition-all placeholder:text-asphalt-700/40">
      </div>

      <!-- New Route Trigger -->
      <button type="button" @click="modal = 'add'"
        class="px-4 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs hover:shadow active:scale-95 flex items-center gap-1.5 flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Route
      </button>
    </div>

  </div>

  <!-- ==================== TABLE CONTAINER ==================== -->
  <div class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs overflow-hidden">
    <?php if (empty($routes)): ?>

      <!-- Empty State Container -->
      <div class="py-16 text-center">
        <div
          class="w-12 h-12 rounded-full bg-asphalt-900/5 text-asphalt-700/40 flex items-center justify-center mx-auto mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
          </svg>
        </div>
        <h3 class="text-sm font-semibold text-asphalt-900">No routes mapped yet</h3>
        <p class="text-xs text-asphalt-700/50 mt-1 max-w-sm mx-auto">Create routes with start and end waypoints to attach
          them to upcoming ride events.</p>
        <button type="button" @click="modal = 'add'"
          class="mt-4 px-4 py-2 bg-ember-500 text-white text-xs font-semibold rounded-lg hover:bg-ember-600 transition-all">
          + Create First Route
        </button>
      </div>

    <?php else: ?>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse app-datatable">
          <thead
            class="bg-asphalt-900/5 border-b border-asphalt-800/10 text-asphalt-700/60 uppercase font-semibold tracking-wider">
            <tr>
              <th class="px-6 py-3.5">Route</th>
              <th class="px-6 py-3.5">Start &rarr; End Waypoints</th>
              <th class="px-6 py-3.5">Distance</th>
              <th class="px-6 py-3.5">Attached Ride</th>
              <th class="px-6 py-3.5">Status</th>
              <th class="px-6 py-3.5">Votes</th>
              <th class="px-6 py-3.5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-asphalt-800/10">
            <?php foreach ($routes as $route): ?>
              <?php
              $status = strtolower($route->status ?? 'approved');
              ?>
              <tr
                x-show="!search || '<?= addslashes(strtolower(htmlspecialchars($route->route_name))); ?>'.includes(search.toLowerCase()) || '<?= addslashes(strtolower(htmlspecialchars($route->start_point))); ?>'.includes(search.toLowerCase()) || '<?= addslashes(strtolower(htmlspecialchars($route->end_point))); ?>'.includes(search.toLowerCase())"
                class="hover:bg-asphalt-900/5 transition-colors group">

                <!-- Route Name -->
                <td class="px-6 py-4 font-semibold text-asphalt-900">
                  <span
                    class="group-hover:text-ember-600 transition-colors"><?= htmlspecialchars($route->route_name); ?></span>
                </td>

                <!-- Start -> End Path -->
                <td class="px-6 py-4 text-asphalt-700/80">
                  <div class="flex items-center gap-1.5 font-medium">
                    <span class="truncate max-w-[140px]"><?= htmlspecialchars($route->start_point); ?></span>
                    <svg class="w-3.5 h-3.5 text-ember-500 flex-shrink-0" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                    <span class="truncate max-w-[140px]"><?= htmlspecialchars($route->end_point); ?></span>
                  </div>
                </td>

                <!-- Distance Badge -->
                <td class="px-6 py-4">
                  <?php if (!empty($route->distance_km)): ?>
                    <span
                      class="inline-flex items-center gap-1 px-2.5 py-1 bg-asphalt-900/5 text-asphalt-800 font-semibold rounded-md border border-asphalt-800/10">
                      <svg class="w-3 h-3 text-asphalt-700/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 10V3L4 14h7v7l9-11h-7z" />
                      </svg>
                      <?= htmlspecialchars($route->distance_km); ?> km
                    </span>
                  <?php else: ?>
                    <span class="text-asphalt-700/40">—</span>
                  <?php endif; ?>
                </td>

                <!-- Attached Ride Status -->
                <td class="px-6 py-4">
                  <?php if (!empty($route->ride_title)): ?>
                    <span
                      class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-1 rounded-lg font-medium truncate max-w-[180px]">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                      <span class="truncate"><?= htmlspecialchars($route->ride_title); ?></span>
                    </span>
                  <?php else: ?>
                    <span
                      class="inline-flex items-center gap-1.5 text-asphalt-700/40 bg-asphalt-900/5 px-2.5 py-1 rounded-lg font-medium">
                      Unattached
                    </span>
                  <?php endif; ?>
                </td>

                <!-- Route Status Badge -->
                <td class="px-6 py-4">
                  <?php if ($status === 'approved'): ?>
                    <span
                      class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Approved
                    </span>
                  <?php elseif ($status === 'rejected'): ?>
                    <span
                      class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800 border border-rose-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> Rejected
                    </span>
                  <?php else: ?>
                    <span
                      class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                      <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Pending Review
                    </span>
                  <?php endif; ?>
                </td>

                <!-- Vote Counter -->
                <td class="px-6 py-4 font-medium text-asphalt-800">
                  <span
                    class="inline-flex items-center gap-1 px-2 py-0.5 bg-asphalt-900/5 rounded border border-asphalt-800/10 text-xs">
                    👍 <?= (int) ($route->vote_count ?? 0); ?>
                  </span>
                </td>

                <!-- Actions Bar -->
                <td class="px-6 py-4 text-right whitespace-nowrap">
                  <div class="flex items-center justify-end gap-1.5">

                    <!-- Approve / Reject Direct Actions for Suggestions -->
                    <?php if ($status === 'pending'): ?>
                      <a href="<?= site_url('admin/routes/approve/' . $route->id); ?>"
                        class="p-1.5 text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition-colors"
                        title="Approve Route">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                      </a>
                      <a href="<?= site_url('admin/routes/reject/' . $route->id); ?>"
                        class="p-1.5 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-colors"
                        title="Reject Route">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </a>
                    <?php endif; ?>

                    <?php if ($status === 'approved' || $status === 'rejected'): ?>
                    <a href="<?= site_url('admin/routes/undo/' . $route->id); ?>"
                        class="p-1.5 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-colors"
                        title="Reject Route">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                      </a>
                      <?php endif; ?>
                    <!-- Edit Button -->
                    <button type="button" @click="modal = 'edit-<?= $route->id; ?>'"
                      class="p-1.5 text-ember-600 hover:text-ember-700 hover:bg-ember-500/10 rounded-lg transition-colors"
                      title="Edit Route">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>

                    <!-- Delete Trigger Button -->
                    <button type="button"
                      @click="delUrl = '<?= site_url('admin/routes/delete/' . $route->id); ?>'; delLabel = '<?= addslashes(htmlspecialchars($route->route_name)); ?>'"
                      class="p-1.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors"
                      title="Delete Route">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>

                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <?php endif; ?>
  </div>

  <!-- ==================== ADD ROUTE MODAL ==================== -->
  <div x-show="modal === 'add'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs"
    x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/60" @click="modal = null"></div>
    <div
      class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden border border-asphalt-800/10"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Modal Header -->
      <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10 bg-asphalt-900/5">
        <h2 class="font-display font-semibold text-base text-asphalt-900">Create New Route</h2>
        <button type="button" @click="modal = null"
          class="p-1 text-asphalt-700/40 hover:text-asphalt-900 hover:bg-asphalt-900/10 rounded-lg transition-colors"
          aria-label="Close">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Form Body -->
      <div class="p-6 overflow-y-auto">
        <?php $route = NULL;
        $action_url = site_url('admin/routes/add');
        $this->load->view('admin/_route_fields', array('route' => $route, 'rides' => $rides, 'action_url' => $action_url)); ?>
      </div>
    </div>
  </div>

  <!-- ==================== EDIT ROUTE MODALS ==================== -->
  <?php foreach ($routes as $route): ?>
    <div x-show="modal === 'edit-<?= $route->id; ?>'" x-cloak
      class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>
      <div class="absolute inset-0 bg-asphalt-950/60" @click="modal = null"></div>
      <div
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden border border-asphalt-800/10"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10 bg-asphalt-900/5">
          <h2 class="font-display font-semibold text-base text-asphalt-900">Update Route Information</h2>
          <button type="button" @click="modal = null"
            class="p-1 text-asphalt-700/40 hover:text-asphalt-900 hover:bg-asphalt-900/10 rounded-lg transition-colors"
            aria-label="Close">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Form Body -->
        <div class="p-6 overflow-y-auto">
          <?php $action_url = site_url('admin/routes/edit/' . $route->id);
          $this->load->view('admin/_route_fields', array('route' => $route, 'rides' => $rides, 'action_url' => $action_url)); ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- ==================== CONFIRM DELETE MODAL ==================== -->
  <div x-show="delUrl !== ''" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs"
    x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/60" @click="delUrl = ''"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 border border-asphalt-800/10"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Warning Icon Header -->
      <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>

      <h2 class="font-display font-bold text-lg text-asphalt-900 mb-1">Delete this route?</h2>
      <p class="text-xs text-asphalt-700/70 leading-relaxed mb-6">
        Are you sure you want to delete <span class="font-semibold text-asphalt-900" x-text="delLabel"></span>? It will
        be permanently removed and unlinked from any associated ride.
      </p>

      <div class="flex items-center justify-end gap-3 pt-2">
        <button type="button" @click="delUrl = ''"
          class="px-4 py-2 text-xs font-semibold text-asphalt-700 hover:text-asphalt-900 bg-asphalt-900/5 hover:bg-asphalt-900/10 rounded-xl transition-colors">
          Cancel
        </button>
        <a :href="delUrl"
          class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95">
          Confirm Delete
        </a>
      </div>

    </div>
  </div>

</div>