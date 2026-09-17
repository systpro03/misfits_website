<?php
$a = $announcement;
$title = $a ? $a->title : '';
$message = $a ? $a->message : '';
$type = $a ? $a->type : 'announcement';
$priority = $a ? $a->priority : 'normal';
$status = $a ? $a->status : 'published';
$show_until = $a ? $a->show_until : '';
?>
<div>
  <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Title *</label>
  <input type="text" name="title" required maxlength="180" value="<?= htmlspecialchars($title); ?>" placeholder="e.g. Saturday Ride Reminder" class="w-full rounded-xl border border-asphalt-800/15 bg-white px-3 py-2 text-sm outline-none focus:border-ember-500 focus:ring-2 focus:ring-ember-500/10 transition-all">
</div>

<div>
  <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Message *</label>
  <textarea name="message" required rows="3" placeholder="Write the reminder, announcement, attention notice or ride suggestion..." class="w-full rounded-xl border border-asphalt-800/15 bg-white px-3.5 py-2 text-sm outline-none resize-y focus:border-ember-500 focus:ring-2 focus:ring-ember-500/10 transition-all"><?= htmlspecialchars($message); ?></textarea>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
  <div>
    <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Type *</label>
    <select name="type" required class="w-full rounded-xl border border-asphalt-800/15 bg-white px-3 py-2.5 text-xs outline-none focus:border-ember-500">
      <?php foreach (array('announcement' => 'Announcement', 'reminder' => 'Ride Reminder', 'attention' => 'Attention', 'suggestion' => 'Ride Suggestion') as $value => $label): ?>
        <option value="<?= $value; ?>" <?= $type === $value ? 'selected' : ''; ?>><?= $label; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Priority *</label>
    <select name="priority" required class="w-full rounded-xl border border-asphalt-800/15 bg-white px-3 py-2.5 text-xs outline-none focus:border-ember-500">
      <?php foreach (array('normal' => 'Normal', 'important' => 'Important', 'urgent' => 'Urgent') as $value => $label): ?>
        <option value="<?= $value; ?>" <?= $priority === $value ? 'selected' : ''; ?>><?= $label; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Status *</label>
    <select name="status" required class="w-full rounded-xl border border-asphalt-800/15 bg-white px-3 py-2.5 text-xs outline-none focus:border-ember-500">
      <option value="published" <?= $status === 'published' ? 'selected' : ''; ?>>Published</option>
      <option value="draft" <?= $status === 'draft' ? 'selected' : ''; ?>>Draft</option>
    </select>
  </div>
</div>

<div>
  <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Display Until <span class="font-normal text-asphalt-700/50">(optional)</span></label>
  <input type="date" name="show_until" value="<?= htmlspecialchars($show_until ?: ''); ?>" class="w-full rounded-xl border border-asphalt-800/15 bg-white px-3.5 py-2.5 text-xs outline-none focus:border-ember-500 focus:ring-2 focus:ring-ember-500/10 transition-all">
  <p class="mt-1.5 text-[10px] text-asphalt-700/50">Leave empty to keep a published announcement visible until an admin removes or drafts it.</p>
</div>
