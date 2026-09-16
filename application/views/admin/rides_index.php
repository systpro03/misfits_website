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
        <h1 class="text-lg font-display font-bold text-asphalt-900 tracking-tight">Rides Directory</h1>
        <p class="text-asphalt-700/60 text-xs">Manage all upcoming and archived club rides.</p>
      </div>
      <span
        class="px-2.5 py-1 text-xs font-semibold text-asphalt-800 bg-asphalt-900/5 rounded-full border border-asphalt-800/10">
        <?= count($rides); ?> Total
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
        <input type="text" x-model="search" placeholder="Search rides or locations..."
          class="w-full pl-9 pr-3 py-2 bg-asphalt-900/5 hover:bg-asphalt-900/10 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-transparent focus:border-ember-500/50 outline-none transition-all placeholder:text-asphalt-700/40">
      </div>

      <!-- New Ride Trigger -->
      <button type="button" @click="modal = 'add'"
        class="px-4 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs hover:shadow active:scale-95 flex items-center gap-1.5 flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Ride
      </button>
    </div>

  </div>

  <!-- ==================== TABLE CONTAINER ==================== -->
  <div class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs overflow-hidden">
    <?php if (empty($rides)): ?>

      <!-- Empty State Container -->
      <div class="py-16 text-center">
        <div
          class="w-12 h-12 rounded-full bg-asphalt-900/5 text-asphalt-700/40 flex items-center justify-center mx-auto mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <h3 class="text-sm font-semibold text-asphalt-900">No rides logged yet</h3>
        <p class="text-xs text-asphalt-700/50 mt-1 max-w-sm mx-auto">Get started by creating your first ride route and
          scheduling a date for your club members.</p>
        <button type="button" @click="modal = 'add'"
          class="mt-4 px-4 py-2 bg-ember-500 text-white text-xs font-semibold rounded-lg hover:bg-ember-600 transition-all">
          + Schedule First Ride
        </button>
      </div>

    <?php else: ?>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse app-datatable">
          <thead
            class="bg-asphalt-900/5 border-b border-asphalt-800/10 text-asphalt-700/60 uppercase font-semibold tracking-wider">
            <tr>
              <th class="px-6 py-3.5">Ride Details</th>
              <th class="px-6 py-3.5">Date & Time</th>
              <th class="px-6 py-3.5">Category</th>
              <th class="px-6 py-3.5">Meeting Point</th>
              <th class="px-6 py-3.5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-asphalt-800/10">
            <?php foreach ($rides as $ride): ?>
              <tr
                x-show="!search || '<?= addslashes(strtolower(htmlspecialchars($ride->title))); ?>'.includes(search.toLowerCase()) || '<?= addslashes(strtolower(htmlspecialchars($ride->meeting_point))); ?>'.includes(search.toLowerCase())"
                class="hover:bg-asphalt-900/5 transition-colors group">
                <!-- Title -->
                <td class="px-6 py-4 font-semibold text-asphalt-900">
                  <span class="group-hover:text-ember-600 transition-colors"><?= htmlspecialchars($ride->title); ?></span>
                </td>

                <!-- Date -->
                <td class="px-6 py-4 text-asphalt-700/80 font-medium">
                  <?= friendly_date($ride->ride_date); ?>
                </td>

                <!-- Type Badge -->
                <td class="px-6 py-4">
                  <?= ride_badge($ride->ride_type); ?>
                </td>

                <!-- Location -->
                <td class="px-6 py-4 text-asphalt-700/70 max-w-xs truncate">
                  <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0 text-asphalt-700/40" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span
                      class="truncate"><?= !empty($ride->meeting_point) ? htmlspecialchars($ride->meeting_point) : 'TBD'; ?></span>
                  </div>
                </td>

                <!-- Actions Bar -->
                <td class="px-6 py-4 text-right whitespace-nowrap">
                  <div class="flex items-center justify-end gap-1.5">

                    <!-- View Link -->
                    <a href="<?= site_url('rides/' . $ride->id); ?>" target="_blank"
                      class="p-1.5 text-asphalt-700/50 hover:text-asphalt-900 hover:bg-white rounded-lg transition-colors border border-transparent hover:border-asphalt-800/10"
                      title="View Public Page">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                      </svg>
                    </a>

                    <!-- Edit Button -->
                    <button type="button" @click="modal = 'edit-<?= $ride->id; ?>'"
                      class="p-1.5 text-ember-600 hover:text-ember-700 hover:bg-ember-500/10 rounded-lg transition-colors"
                      title="Edit Ride">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>

                    <!-- Delete Trigger Button -->
                    <button type="button"
                      @click="delUrl = '<?= site_url('admin/rides/delete/' . $ride->id); ?>'; delLabel = '<?= addslashes(htmlspecialchars($ride->title)); ?>'"
                      class="p-1.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors"
                      title="Delete Ride">
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

  <!-- ==================== ADD RIDE MODAL ==================== -->
  <div x-show="modal === 'add'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs"
    x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/60" @click="modal = null"></div>
    <div
      class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden border border-asphalt-800/10"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Modal Header -->
      <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10 bg-asphalt-900/5">
        <h2 class="font-display font-semibold text-base text-asphalt-900">Schedule New Ride</h2>
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
        <?php $ride = NULL;
        $action_url = site_url('admin/rides/add');
        $this->load->view('admin/_ride_fields', array('ride' => $ride, 'action_url' => $action_url)); ?>
      </div>
    </div>
  </div>

  <!-- ==================== EDIT RIDE MODALS ==================== -->
  <?php foreach ($rides as $ride): ?>
    <div x-show="modal === 'edit-<?= $ride->id; ?>'" x-cloak
      class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>
      <div class="absolute inset-0 bg-asphalt-950/60" @click="modal = null"></div>
      <div
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden border border-asphalt-800/10"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10 bg-asphalt-900/5">
          <h2 class="font-display font-semibold text-base text-asphalt-900">Update Ride Details</h2>
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
          <?php $action_url = site_url('admin/rides/edit/' . $ride->id);
          $this->load->view('admin/_ride_fields', array('ride' => $ride, 'action_url' => $action_url)); ?>
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

      <h2 class="font-display font-bold text-lg text-asphalt-900 mb-1">Delete this ride?</h2>
      <p class="text-xs text-asphalt-700/70 leading-relaxed mb-6">
        Are you sure you want to delete <span class="font-semibold text-asphalt-900" x-text="delLabel"></span>? This
        action is permanent and cannot be reversed.
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