<div x-data="{
  modal: <?= htmlspecialchars(json_encode($open_modal), ENT_QUOTES); ?>,
  delUrl: '',
  delLabel: ''
}" x-cloak class="space-y-5 md:space-y-6 pb-6">

  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white border border-asphalt-800/10 p-4 sm:p-5 rounded-2xl shadow-xs">
    <div class="flex items-start sm:items-center gap-3 min-w-0">
      <div class="w-10 h-10 rounded-xl bg-ember-500/10 text-ember-600 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 5H5a2 2 0 00-2 2v9a2 2 0 002 2h3l4 3 4-3h3a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h7"/></svg>
      </div>
      <div class="min-w-0">
        <div class="flex items-center gap-2.5">
          <h1 class="text-lg sm:text-xl font-display font-bold text-asphalt-900 tracking-tight">Announcements & Notices</h1>
          <span class="px-2.5 py-1 text-[10px] sm:text-xs font-semibold text-asphalt-800 bg-asphalt-900/5 rounded-full border border-asphalt-800/10 whitespace-nowrap"><?= count($announcements); ?> Total</span>
        </div>
        <p class="text-asphalt-700/60 text-xs mt-0.5">Publish reminders, attention notices, route suggestions and club updates.</p>
      </div>
    </div>

    <button type="button" @click="modal = 'add'" class="w-full sm:w-auto justify-center px-4 py-2.5 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs hover:shadow active:scale-95 flex items-center gap-1.5">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      New Announcement
    </button>
  </div>

  <?php if (empty($announcements)): ?>
    <div class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs py-16 text-center">
      <div class="w-14 h-14 rounded-full bg-asphalt-900/5 text-asphalt-700/40 flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 5H5a2 2 0 00-2 2v9a2 2 0 002 2h3l4 3 4-3h3a2 2 0 002-2V7a2 2 0 00-2-2z"/></svg>
      </div>
      <h3 class="text-sm font-semibold text-asphalt-900">No announcements yet</h3>
      <p class="text-xs text-asphalt-700/50 mt-1 max-w-md mx-auto">Create a club notice to keep riders informed about upcoming rides, reminders and important updates.</p>
      <button type="button" @click="modal = 'add'" class="mt-4 px-4 py-2 bg-ember-500 text-white text-xs font-semibold rounded-lg hover:bg-ember-600 transition-all">Create First Announcement</button>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
      <?php foreach ($announcements as $a):
        $type_class = array(
          'announcement' => 'bg-sky-50 text-sky-700 border-sky-200',
          'reminder' => 'bg-amber-50 text-amber-700 border-amber-200',
          'attention' => 'bg-rose-50 text-rose-700 border-rose-200',
          'suggestion' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
        );
        $badge_class = isset($type_class[$a->type]) ? $type_class[$a->type] : $type_class['announcement'];
        $priority_class = $a->priority === 'urgent' ? 'text-rose-600' : ($a->priority === 'important' ? 'text-amber-600' : 'text-asphalt-700/50');
      ?>
        <article class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs overflow-hidden hover:border-ember-500/30 hover:shadow-md transition-all group">
          <div class="p-5 sm:p-6">
            <div class="flex items-start justify-between gap-4">
              <div class="flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[10px] font-bold uppercase tracking-wider <?= $badge_class; ?>">
                  <?php if ($a->type === 'attention'): ?>⚠<?php elseif ($a->type === 'reminder'): ?>◷<?php elseif ($a->type === 'suggestion'): ?>✦<?php else: ?>●<?php endif; ?>
                  <?= htmlspecialchars(ucfirst($a->type)); ?>
                </span>
                <span class="text-[10px] font-bold uppercase tracking-wider <?= $priority_class; ?>"><?= htmlspecialchars($a->priority); ?></span>
                <span class="px-2 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider <?= $a->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-asphalt-900/5 text-asphalt-700/50'; ?>">
                  <?= htmlspecialchars($a->status); ?>
                </span>
              </div>
              <div class="flex items-center gap-1 flex-shrink-0">
                <button type="button" @click="modal = 'edit-<?= (int) $a->id; ?>'" class="p-2 rounded-lg text-asphalt-700/40 hover:text-ember-600 hover:bg-ember-500/10 transition-colors" title="Edit">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 14l-4 1 1-4 7.5-7.5z"/></svg>
                </button>
                <button type="button" @click="delUrl = '<?= site_url('admin/announcements/delete/' . $a->id); ?>'; delLabel = '<?= htmlspecialchars(addslashes($a->title), ENT_QUOTES); ?>'; modal = 'delete'" class="p-2 rounded-lg text-asphalt-700/40 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-8 0h10"/></svg>
                </button>
              </div>
            </div>

            <h2 class="mt-4 font-display text-xl font-bold text-asphalt-900 group-hover:text-ember-600 transition-colors"><?= htmlspecialchars($a->title); ?></h2>
            <p class="mt-2 text-sm text-asphalt-700/70 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($a->message); ?></p>

            <div class="mt-5 pt-4 border-t border-asphalt-800/10 flex flex-wrap items-center justify-between gap-2 text-[10px] text-asphalt-700/50 uppercase tracking-wider font-semibold">
              <span>By <?= htmlspecialchars($a->admin_name ?: 'Admin'); ?></span>
              <span><?= date('M j, Y', strtotime($a->created_at)); ?><?= !empty($a->show_until) ? ' · Until ' . date('M j, Y', strtotime($a->show_until)) : ''; ?></span>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Add / Edit modals -->
  <div x-show="modal === 'add'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-asphalt-950/60 backdrop-blur-xs" @click="modal = null"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[82vh] overflow-y-auto text-asphalt-900">
      <div class="flex items-center justify-between px-5 py-4 border-b border-asphalt-800/10">
        <div><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ember-600">Club Bulletin</p><h2 class="font-display text-lg font-bold">New Announcement</h2></div>
        <button type="button" @click="modal = null" class="p-2 rounded-lg text-asphalt-700/40 hover:bg-asphalt-900/5 hover:text-asphalt-900">&times;</button>
      </div>
      <form action="<?= site_url('admin/announcements/add'); ?>" method="post" class="p-5 space-y-3">
        <?php $this->load->view('admin/_announcement_fields', array('announcement' => NULL)); ?>
        <div class="flex justify-end gap-2 pt-3 border-t border-asphalt-800/10">
          <button type="button" @click="modal = null" class="px-4 py-2.5 rounded-xl bg-asphalt-900/5 text-asphalt-800 text-xs font-semibold hover:bg-asphalt-900/10">Cancel</button>
          <button type="submit" class="px-5 py-2.5 rounded-xl bg-ember-500 text-white text-xs font-display font-bold hover:bg-ember-600 shadow-xs">Publish Announcement</button>
        </div>
      </form>
    </div>
  </div>

  <?php foreach ($announcements as $a): ?>
    <div x-show="modal === 'edit-<?= (int) $a->id; ?>'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-asphalt-950/60 backdrop-blur-xs" @click="modal = null"></div>
      <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[82vh] overflow-y-auto text-asphalt-900">
        <div class="flex items-center justify-between px-5 py-4 border-b border-asphalt-800/10">
          <div><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ember-600">Club Bulletin</p><h2 class="font-display text-lg font-bold">Edit Announcement</h2></div>
          <button type="button" @click="modal = null" class="p-2 rounded-lg text-asphalt-700/40 hover:bg-asphalt-900/5 hover:text-asphalt-900">&times;</button>
        </div>
        <form action="<?= site_url('admin/announcements/edit/' . $a->id); ?>" method="post" class="p-5 space-y-3">
          <?php $this->load->view('admin/_announcement_fields', array('announcement' => $a)); ?>
          <div class="flex justify-end gap-2 pt-3 border-t border-asphalt-800/10">
            <button type="button" @click="modal = null" class="px-4 py-2.5 rounded-xl bg-asphalt-900/5 text-asphalt-800 text-xs font-semibold hover:bg-asphalt-900/10">Cancel</button>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-ember-500 text-white text-xs font-display font-bold hover:bg-ember-600 shadow-xs">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Delete confirmation -->
  <div x-show="modal === 'delete'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-asphalt-950/70 backdrop-blur-xs" @click="modal = null"></div>
    <div class="relative w-full max-w-sm rounded-2xl bg-white shadow-2xl p-5 text-asphalt-900">
      <div class="w-11 h-11 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.3 3.6l-7 12.1A2 2 0 005 18.7h14a2 2 0 001.7-3l-7-12.1a2 2 0 00-3.4 0z"/></svg>
      </div>
      <h3 class="font-display text-lg font-bold">Delete announcement?</h3>
      <p class="text-sm text-asphalt-700/60 mt-2">This will permanently remove <strong x-text="delLabel"></strong> from the bulletin.</p>
      <div class="flex justify-end gap-2 mt-6">
        <button type="button" @click="modal = null" class="px-4 py-2.5 rounded-xl bg-asphalt-900/5 text-asphalt-800 text-xs font-semibold">Cancel</button>
        <a :href="delUrl" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold">Delete</a>
      </div>
    </div>
  </div>
</div>
