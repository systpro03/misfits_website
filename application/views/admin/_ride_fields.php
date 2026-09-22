<form action="<?= $action_url; ?>" method="post" enctype="multipart/form-data" class="space-y-5">
  <div class="rounded-xl bg-ember-500/5 border border-ember-500/10 px-4 py-3 text-xs text-asphalt-700/70">
    <span class="font-semibold text-asphalt-900">Ride details</span><br>
    Set the schedule, meeting point, and optional cover image for this ride.
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Ride title *</label>
    <input type="text" name="title" required maxlength="180" value="<?= htmlspecialchars($ride->title ?? ''); ?>"
      class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 focus:ring-1 focus:ring-ember-500 outline-none">
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Status *</label>
      <select name="ride_type" required class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
        <option value="upcoming" <?= (isset($ride->ride_type) && $ride->ride_type === 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
        <option value="past" <?= (isset($ride->ride_type) && $ride->ride_type === 'past') ? 'selected' : ''; ?>>Past / Latest ride</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Ride date *</label>
      <input type="date" name="ride_date" required value="<?= htmlspecialchars($ride->ride_date ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Time (optional)</label>
      <input type="time" name="ride_time" value="<?= htmlspecialchars($ride->ride_time ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Meeting point</label>
      <input type="text" name="meeting_point" maxlength="255" value="<?= htmlspecialchars($ride->meeting_point ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Description</label>
    <textarea name="description" rows="4" class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none"><?= htmlspecialchars($ride->description ?? ''); ?></textarea>
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Cover image</label>
    <?php if (!empty($ride->cover_image)): ?>
      <div class="w-32 h-20 rounded overflow-hidden bg-asphalt-900 mb-2">
        <img src="<?= upload_url('rides', $ride->cover_image); ?>" class="w-full h-full object-cover" alt="">
      </div>
    <?php endif; ?>
    <input type="file" name="cover_image" accept="image/png,image/jpeg,image/webp"
      class="w-full text-sm border border-asphalt-800/20 rounded px-3 py-2 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:bg-ember-500 file:text-white file:font-medium">
    <p class="text-xs text-asphalt-700/50 mt-1">JPG, PNG or WEBP, up to 5MB.<?= !empty($ride) ? ' Leave blank to keep the current image.' : ''; ?></p>
  </div>

  <div class="flex items-center gap-3 pt-2 border-t border-asphalt-800/10 mt-2">
    <button type="submit" class="px-5 py-2.5 bg-ember-500 hover:bg-ember-600 text-white font-display font-semibold tracking-wide rounded transition-colors">
      <?= !empty($ride) ? 'Save Changes' : 'Create Ride'; ?>
    </button>
    <button type="button" @click="modal = null" class="text-sm text-asphalt-700/60 hover:text-asphalt-900">Cancel</button>
  </div>
</form>
