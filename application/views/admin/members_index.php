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
        <h1 class="text-lg font-display font-bold text-asphalt-900 tracking-tight">Team Roster</h1>
        <p class="text-asphalt-700/60 text-xs">Manage active and inactive public team members.</p>
      </div>
      <span
        class="px-2.5 py-1 text-xs font-semibold text-asphalt-800 bg-asphalt-900/5 rounded-full border border-asphalt-800/10">
        <?= count($members); ?> Members
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
        <input type="text" x-model="search" placeholder="Search riders, positions..."
          class="w-full pl-9 pr-3 py-2 bg-asphalt-900/5 hover:bg-asphalt-900/10 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-transparent focus:border-ember-500/50 outline-none transition-all placeholder:text-asphalt-700/40">
      </div>

      <!-- New Member Trigger -->
      <button type="button" @click="modal = 'add'"
        class="px-4 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs hover:shadow active:scale-95 flex items-center gap-1.5 flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Member
      </button>
    </div>

  </div>

  <!-- ==================== TABLE CONTAINER ==================== -->
  <div class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs overflow-hidden">
    <?php if (empty($members)): ?>

      <!-- Empty State Container -->
      <div class="py-16 text-center">
        <div
          class="w-12 h-12 rounded-full bg-asphalt-900/5 text-asphalt-700/40 flex items-center justify-center mx-auto mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <h3 class="text-sm font-semibold text-asphalt-900">No riders on the roster</h3>
        <p class="text-xs text-asphalt-700/50 mt-1 max-w-sm mx-auto">Start populating your public team directory by
          onboarding your first rider.</p>
        <button type="button" @click="modal = 'add'"
          class="mt-4 px-4 py-2 bg-ember-500 text-white text-xs font-semibold rounded-lg hover:bg-ember-600 transition-all">
          + Add First Member
        </button>
      </div>

    <?php else: ?>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse app-datatable">
          <thead
            class="bg-asphalt-900/5 border-b border-asphalt-800/10 text-asphalt-700/60 uppercase font-semibold tracking-wider">
            <tr>
              <th class="px-6 py-3.5">Rider</th>
              <th class="px-6 py-3.5">Position</th>
              <th class="px-6 py-3.5">Bike Model</th>
              <th class="px-6 py-3.5">Status</th>
              <th class="px-6 py-3.5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-asphalt-800/10">
            <?php foreach ($members as $m): ?>
              <tr
                x-show="!search || '<?= addslashes(strtolower(htmlspecialchars($m->road_name ?: $m->full_name))); ?>'.includes(search.toLowerCase()) || '<?= addslashes(strtolower(htmlspecialchars($m->position))); ?>'.includes(search.toLowerCase()) || '<?= addslashes(strtolower(htmlspecialchars($m->bike_model))); ?>'.includes(search.toLowerCase())"
                class="hover:bg-asphalt-900/5 transition-colors group">
                <!-- Rider Avatar & Name -->
                <td class="px-6 py-3.5">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-10 h-10 rounded-full overflow-hidden bg-asphalt-900/10 flex-shrink-0 ring-2 ring-white shadow-xs">
                      <img src="<?= upload_url('members', $m->image); ?>" class="w-full h-full object-cover" alt=""
                        onerror="this.style.visibility='hidden'">
                    </div>
                    <div>
                      <p class="font-bold text-asphalt-900 group-hover:text-ember-600 transition-colors">
                        <?= htmlspecialchars($m->road_name ?: $m->full_name); ?></p>
                      <?php if ($m->road_name): ?>
                        <p class="text-[11px] text-asphalt-700/50 leading-tight"><?= htmlspecialchars($m->full_name); ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>

                <!-- Position -->
                <td class="px-6 py-3.5 text-asphalt-700/80 font-medium">
                  <?= !empty($m->position) ? htmlspecialchars($m->position) : '<span class="text-asphalt-700/40">—</span>'; ?>
                </td>

                <!-- Bike Model -->
                <td class="px-6 py-3.5 text-asphalt-700/80 font-medium">
                  <?= !empty($m->bike_model) ? htmlspecialchars($m->bike_model) : '<span class="text-asphalt-700/40">—</span>'; ?>
                </td>

                <!-- Status Badge -->
                <td class="px-6 py-3.5">
                  <span
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold <?= $m->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-asphalt-900/5 text-asphalt-700/60 border border-asphalt-800/10'; ?>">
                    <span
                      class="w-1.5 h-1.5 rounded-full <?= $m->status === 'active' ? 'bg-emerald-500' : 'bg-asphalt-700/40'; ?>"></span>
                    <?= ucfirst($m->status); ?>
                  </span>
                </td>

                <!-- Actions Bar -->
                <td class="px-6 py-3.5 text-right whitespace-nowrap">
                  <div class="flex items-center justify-end gap-1.5">

                    <!-- Edit Button -->
                    <button type="button" @click="modal = 'edit-<?= $m->id; ?>'"
                      class="p-1.5 text-ember-600 hover:text-ember-700 hover:bg-ember-500/10 rounded-lg transition-colors"
                      title="Edit Member">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>

                    <!-- Delete Trigger Button -->
                    <button type="button"
                      @click="delUrl = '<?= base_url('admin/members/delete/' . $m->id); ?>'; delLabel = '<?= addslashes(htmlspecialchars($m->road_name ?: $m->full_name)); ?>'"
                      class="p-1.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors"
                      title="Delete Member">
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

  <!-- ==================== ADD MEMBER MODAL ==================== -->
  <div x-show="modal === 'add'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs"
    x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/60" @click="modal = null"></div>
    <div
      class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden border border-asphalt-800/10"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Modal Header -->
      <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10 bg-asphalt-900/5">
        <h2 class="font-display font-semibold text-base text-asphalt-900">Add Team Member</h2>
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
        <?php $member = NULL;
        $action_url = base_url('admin/members/add');
        $this->load->view('admin/_member_fields', array('member' => $member, 'action_url' => $action_url)); ?>
      </div>
    </div>
  </div>

  <!-- ==================== EDIT MEMBER MODALS ==================== -->
  <?php foreach ($members as $m): ?>
    <div x-show="modal === 'edit-<?= $m->id; ?>'" x-cloak
      class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>
      <div class="absolute inset-0 bg-asphalt-950/60" @click="modal = null"></div>
      <div
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden border border-asphalt-800/10"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10 bg-asphalt-900/5">
          <h2 class="font-display font-semibold text-base text-asphalt-900">Edit Member Info</h2>
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
          <?php $action_url = base_url('admin/members/edit/' . $m->id);
          $this->load->view('admin/_member_fields', array('member' => $m, 'action_url' => $action_url)); ?>
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

      <h2 class="font-display font-bold text-lg text-asphalt-900 mb-1">Remove member?</h2>
      <p class="text-xs text-asphalt-700/70 leading-relaxed mb-6">
        Are you sure you want to remove <span class="font-semibold text-asphalt-900" x-text="delLabel"></span> from the
        public roster? This operation cannot be undone.
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