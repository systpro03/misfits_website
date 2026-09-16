<div x-data="{ 
  approveUrl: '', 
  approveName: '', 
  rejectUrl: '', 
  rejectName: '', 
  deleteUrl: '', 
  deleteName: '',
  search: '',
  statusFilter: 'all',
  previewImage: null
}" x-cloak class="space-y-6">

  <!-- ==================== TOP ACTION & FILTER BAR ==================== -->
  <div
    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-asphalt-800/10 p-4 rounded-2xl shadow-xs">

    <!-- Title & Total Counter -->
    <div class="flex items-center gap-3">
      <div>
        <h1 class="text-lg font-display font-bold text-asphalt-900 tracking-tight">Gallery Submissions</h1>
        <p class="text-asphalt-700/60 text-xs">Review, publish, or reject photo submissions from visitors.</p>
      </div>
      <span
        class="px-2.5 py-1 text-xs font-semibold text-asphalt-800 bg-asphalt-900/5 rounded-full border border-asphalt-800/10">
        <?= count($requests); ?> Submissions
      </span>
    </div>

    <!-- Right Controls: Status Tabs & Live Search -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
      <!-- Status Filter Tabs -->
      <div
        class="flex bg-asphalt-900/5 p-1 rounded-xl border border-asphalt-800/10 text-xs font-medium text-asphalt-700">
        <button type="button" @click="statusFilter = 'all'"
          :class="statusFilter === 'all' ? 'bg-white text-asphalt-900 shadow-xs font-semibold' : 'hover:text-asphalt-900'"
          class="px-3 py-1.5 rounded-lg transition-all">All</button>
        <button type="button" @click="statusFilter = 'pending'"
          :class="statusFilter === 'pending' ? 'bg-white text-asphalt-900 shadow-xs font-semibold' : 'hover:text-asphalt-900'"
          class="px-3 py-1.5 rounded-lg transition-all">Pending</button>
        <button type="button" @click="statusFilter = 'approved'"
          :class="statusFilter === 'approved' ? 'bg-white text-asphalt-900 shadow-xs font-semibold' : 'hover:text-asphalt-900'"
          class="px-3 py-1.5 rounded-lg transition-all">Approved</button>
        <button type="button" @click="statusFilter = 'rejected'"
          :class="statusFilter === 'rejected' ? 'bg-white text-asphalt-900 shadow-xs font-semibold' : 'hover:text-asphalt-900'"
          class="px-3 py-1.5 rounded-lg transition-all">Rejected</button>
      </div>

      <!-- Live Search Input -->
      <div class="relative min-w-[200px]">
        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-asphalt-700/40" fill="none"
          stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" x-model="search" placeholder="Search submitters, captions..."
          class="w-full pl-9 pr-3 py-2 bg-asphalt-900/5 hover:bg-asphalt-900/10 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-transparent focus:border-ember-500/50 outline-none transition-all placeholder:text-asphalt-700/40">
      </div>
    </div>

  </div>

  <!-- ==================== SUBMISSIONS GRID ==================== -->
  <?php if (empty($requests)): ?>

    <!-- Empty State Container -->
    <div class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs py-16 text-center">
      <div
        class="w-12 h-12 rounded-full bg-asphalt-900/5 text-asphalt-700/40 flex items-center justify-center mx-auto mb-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
      <h3 class="text-sm font-semibold text-asphalt-900">No submissions found</h3>
      <p class="text-xs text-asphalt-700/50 mt-1 max-w-sm mx-auto">When visitors submit community photos through the
        public gallery, they will appear here for review.</p>
    </div>

  <?php else: ?>

    <div class="space-y-4">
      <?php foreach ($requests as $req): ?>
        <div
          x-show="(statusFilter === 'all' || statusFilter === '<?= $req->status; ?>') && (!search || '<?= addslashes(strtolower(htmlspecialchars($req->submitter_name))); ?>'.includes(search.toLowerCase()) || '<?= addslashes(strtolower(htmlspecialchars($req->caption ?: ''))); ?>'.includes(search.toLowerCase()))"
          class="bg-white border border-asphalt-800/10 rounded-2xl p-5 shadow-xs hover:shadow-md transition-all flex flex-col sm:flex-row gap-5 group">
          <!-- Photo Container (Click to Lightbox Preview) -->
          <div @click="previewImage = {
              src: '<?= upload_url('requests', $req->image); ?>',
              name: '<?= addslashes(htmlspecialchars($req->submitter_name)); ?>',
              caption: '<?= addslashes(htmlspecialchars($req->caption ?: 'No caption provided')); ?>',
              status: '<?= $req->status; ?>',
              approveUrl: '<?= site_url('admin/requests/approve/' . $req->id); ?>',
              rejectUrl: '<?= site_url('admin/requests/reject/' . $req->id); ?>'
            }"
            class="w-full sm:w-48 h-48 sm:h-36 rounded-xl overflow-hidden bg-asphalt-900/10 flex-shrink-0 relative group/img cursor-pointer border border-asphalt-800/10">
            <img src="<?= upload_url('requests', $req->image); ?>"
              class="w-full h-full object-cover transition-transform duration-300 group-hover/img:scale-105"
              alt="Submission photo">
            <!-- Zoom Overlay -->
            <div
              class="absolute inset-0 bg-asphalt-950/30 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center text-white">
              <svg class="w-6 h-6 drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
              </svg>
            </div>
          </div>

          <!-- Submission Metadata & Body -->
          <div class="flex-1 min-w-0 flex flex-col justify-between">
            <div>
              <div class="flex items-start justify-between gap-3 mb-2">
                <div>
                  <h3 class="font-bold text-sm text-asphalt-900"><?= htmlspecialchars($req->submitter_name); ?></h3>
                  <?php if ($req->submitter_email): ?>
                    <p class="text-xs text-asphalt-700/50 flex items-center gap-1.5 mt-0.5">
                      <svg class="w-3.5 h-3.5 text-asphalt-700/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                      <?= htmlspecialchars($req->submitter_email); ?>
                    </p>
                  <?php endif; ?>
                </div>

                <!-- Status Badge -->
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold flex-shrink-0
                  <?php if ($req->status === 'pending'): ?> bg-amber-50 text-amber-700 border border-amber-200/60
                  <?php elseif ($req->status === 'approved'): ?> bg-emerald-50 text-emerald-700 border border-emerald-200/60
                  <?php else: ?> bg-rose-50 text-rose-700 border border-rose-200/60 <?php endif; ?>">
                  <span class="w-1.5 h-1.5 rounded-full 
                    <?php if ($req->status === 'pending'): ?> bg-amber-500
                    <?php elseif ($req->status === 'approved'): ?> bg-emerald-500
                    <?php else: ?> bg-rose-500 <?php endif; ?>"></span>
                  <?= ucfirst($req->status); ?>
                </span>
              </div>

              <!-- Caption -->
              <p
                class="text-xs text-asphalt-700/80 mb-2 leading-relaxed bg-asphalt-900/5 p-2.5 rounded-xl border border-asphalt-800/5 italic">
                &ldquo;<?= htmlspecialchars($req->caption ?: 'No caption provided'); ?>&rdquo;
              </p>
            </div>

            <!-- Footer: Timestamp & Actions -->
            <div class="flex items-center justify-between pt-3 border-t border-asphalt-800/10 mt-2">
              <span class="text-[11px] text-asphalt-700/40 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Submitted <?= friendly_date(date('Y-m-d', strtotime($req->created_at))); ?>
              </span>

              <!-- Pending Actions -->
              <?php if ($req->status === 'pending'): ?>
                <div class="flex items-center gap-2">
                  <button type="button"
                    @click="rejectUrl = '<?= site_url('admin/requests/reject/' . $req->id); ?>'; rejectName = '<?= addslashes(htmlspecialchars($req->submitter_name)); ?>'"
                    class="px-3 py-1.5 border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-semibold rounded-xl transition-all">
                    Reject
                  </button>
                  <button type="button"
                    @click="approveUrl = '<?= site_url('admin/requests/approve/' . $req->id); ?>'; approveName = '<?= addslashes(htmlspecialchars($req->submitter_name)); ?>'"
                    class="px-3.5 py-1.5 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95">
                    Approve &amp; Publish
                  </button>
                </div>
              <?php else: ?>
                <!-- Approved/Rejected Metadata & Delete -->
                <div class="flex items-center gap-3">
                  <?php if (!empty($req->admin_note)): ?>
                    <span class="text-xs text-asphalt-700/60 italic max-w-xs truncate"
                      title="<?= htmlspecialchars($req->admin_note); ?>">
                      Note: <?= htmlspecialchars($req->admin_note); ?>
                    </span>
                  <?php endif; ?>
                  <button type="button"
                    @click="deleteUrl = '<?= site_url('admin/requests/delete/' . $req->id); ?>'; deleteName = '<?= addslashes(htmlspecialchars($req->submitter_name)); ?>'"
                    class="p-1.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors flex items-center gap-1 text-xs font-medium"
                    title="Delete record">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Record
                  </button>
                </div>
              <?php endif; ?>
            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

  <!-- ==================== PHOTO PREVIEW LIGHTBOX MODAL ==================== -->
  <div x-show="previewImage !== null" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/80" @click="previewImage = null"></div>
    <div
      class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden border border-asphalt-800/10 flex flex-col max-h-[90vh]"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Close Header -->
      <div class="flex items-center justify-between px-5 py-3 border-b border-asphalt-800/10 bg-asphalt-900/5">
        <h3 class="font-display font-semibold text-xs text-asphalt-900">Submitted Photo Preview</h3>
        <button type="button" @click="previewImage = null"
          class="p-1 text-asphalt-700/40 hover:text-asphalt-900 hover:bg-asphalt-900/10 rounded-lg transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Image & Details Container -->
      <div class="p-4 overflow-y-auto flex-1 flex flex-col items-center bg-asphalt-950/5">
        <img :src="previewImage?.src"
          class="max-h-[60vh] w-auto object-contain rounded-xl shadow-md border border-asphalt-800/10 mb-4"
          alt="Photo Preview">

        <div class="w-full bg-white p-4 rounded-xl border border-asphalt-800/10">
          <p class="text-xs text-asphalt-700/50 mb-1">Submitted by: <span class="font-bold text-asphalt-900"
              x-text="previewImage?.name"></span></p>
          <p class="text-xs text-asphalt-700/80 italic" x-text="previewImage?.caption"></p>
        </div>
      </div>

      <!-- Action Footer with Approve / Reject -->
      <div class="flex items-center justify-between p-4 border-t border-asphalt-800/10 bg-white">
        <button type="button" @click="previewImage = null"
          class="px-4 py-2 text-xs font-semibold text-asphalt-700 hover:text-asphalt-900 bg-asphalt-900/5 hover:bg-asphalt-900/10 rounded-xl transition-colors">
          Close Preview
        </button>

        <template x-if="previewImage?.status === 'pending'">
          <div class="flex items-center gap-2">
            <button type="button"
              @click="rejectUrl = previewImage.rejectUrl; rejectName = previewImage.name; previewImage = null;"
              class="px-4 py-2 border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-semibold rounded-xl transition-all">
              Reject
            </button>
            <button type="button"
              @click="approveUrl = previewImage.approveUrl; approveName = previewImage.name; previewImage = null;"
              class="px-4 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95">
              Approve &amp; Publish
            </button>
          </div>
        </template>
      </div>

    </div>
  </div>

  <!-- ==================== APPROVE CONFIRMATION MODAL ==================== -->
  <div x-show="approveUrl !== ''" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/60" @click="approveUrl = ''"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 border border-asphalt-800/10"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Icon Header -->
      <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>

      <h2 class="font-display font-bold text-lg text-asphalt-900 mb-1">Publish Photo to Gallery?</h2>
      <p class="text-xs text-asphalt-700/70 leading-relaxed mb-6">
        The photo submitted by <span x-text="approveName" class="font-semibold text-asphalt-900"></span> will
        immediately become visible to all visitors on the public gallery.
      </p>

      <div class="flex items-center justify-end gap-3">
        <button type="button" @click="approveUrl = ''"
          class="px-4 py-2 text-xs font-semibold text-asphalt-700 hover:text-asphalt-900 bg-asphalt-900/5 hover:bg-asphalt-900/10 rounded-xl transition-colors">
          Cancel
        </button>
        <a :href="approveUrl"
          class="px-4 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95">
          Approve &amp; Publish
        </a>
      </div>

    </div>
  </div>

  <!-- ==================== REJECT MODAL (WITH NOTE) ==================== -->
  <div x-show="rejectUrl !== ''" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/60" @click="rejectUrl = ''"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 border border-asphalt-800/10"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">

      <!-- Icon Header -->
      <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </div>

      <h2 class="font-display font-bold text-lg text-asphalt-900 mb-1">Reject Photo Submission</h2>
      <p class="text-xs text-asphalt-700/70 leading-relaxed mb-4">
        The submission from <span x-text="rejectName" class="font-semibold text-asphalt-900"></span> will not be
        published. You can record an optional administrative note below.
      </p>

      <form :action="rejectUrl" method="post">
        <textarea name="admin_note" rows="3" placeholder="Reason for rejection (optional)..."
          class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 border border-asphalt-800/10 focus:border-ember-500 rounded-xl p-3 outline-none transition-all placeholder:text-asphalt-700/40 mb-5"></textarea>

        <div class="flex items-center justify-end gap-3">
          <button type="button" @click="rejectUrl = ''"
            class="px-4 py-2 text-xs font-semibold text-asphalt-700 hover:text-asphalt-900 bg-asphalt-900/5 hover:bg-asphalt-900/10 rounded-xl transition-colors">
            Cancel
          </button>
          <button type="submit"
            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95">
            Confirm Rejection
          </button>
        </div>
      </form>

    </div>
  </div>

  <!-- ==================== CONFIRM DELETE MODAL ==================== -->
  <div x-show="deleteUrl !== ''" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xs" x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/60" @click="deleteUrl = ''"></div>
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

      <h2 class="font-display font-bold text-lg text-asphalt-900 mb-1">Delete Record Permanently?</h2>
      <p class="text-xs text-asphalt-700/70 leading-relaxed mb-6">
        The request record and image from <span x-text="deleteName" class="font-semibold text-asphalt-900"></span> will
        be permanently deleted. This cannot be undone.
      </p>

      <div class="flex items-center justify-end gap-3">
        <button type="button" @click="deleteUrl = ''"
          class="px-4 py-2 text-xs font-semibold text-asphalt-700 hover:text-asphalt-900 bg-asphalt-900/5 hover:bg-asphalt-900/10 rounded-xl transition-colors">
          Cancel
        </button>
        <a :href="deleteUrl"
          class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs active:scale-95">
          Confirm Delete
        </a>
      </div>

    </div>
  </div>

</div>