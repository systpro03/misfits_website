<form action="<?= $action_url; ?>" method="post" enctype="multipart/form-data" class="space-y-5">

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Route name *</label>
    <input type="text" name="route_name" required maxlength="180" value="<?= htmlspecialchars($route->route_name ?? ''); ?>"
      class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Attach to ride</label>
    <select name="ride_id" class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
      <option value="">— Not attached yet —</option>
      <?php foreach ($rides as $rid => $label): ?>
        <option value="<?= $rid; ?>" <?= (isset($route->ride_id) && (int) $route->ride_id === (int) $rid) ? 'selected' : ''; ?>><?= htmlspecialchars($label); ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Start point *</label>
      <input type="text" name="start_point" required maxlength="200" value="<?= htmlspecialchars($route->start_point ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">End point *</label>
      <input type="text" name="end_point" required maxlength="200" value="<?= htmlspecialchars($route->end_point ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Waypoints / stops (one per line)</label>
    <textarea name="waypoints" rows="3" class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none"><?= htmlspecialchars($route->waypoints ?? ''); ?></textarea>
  </div>

  <div class="grid grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Distance (km)</label>
      <input type="number" step="0.01" name="distance_km" value="<?= htmlspecialchars($route->distance_km ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Est. duration</label>
      <input type="text" name="estimated_duration" placeholder="e.g. 2h 30m" value="<?= htmlspecialchars($route->estimated_duration ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Difficulty *</label>
      <select name="difficulty" required class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
        <?php foreach (array('easy','moderate','hard') as $opt): ?>
          <option value="<?= $opt; ?>" <?= (isset($route->difficulty) && $route->difficulty === $opt) ? 'selected' : ''; ?>><?= ucfirst($opt); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Google Maps embed / share URL</label>
    <input type="url" name="map_embed_url" placeholder="https://www.google.com/maps/embed?..." value="<?= htmlspecialchars($route->map_embed_url ?? ''); ?>"
      class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Route map image (optional)</label>
    <?php if (!empty($route->route_image)): ?>
      <div class="w-32 h-20 rounded overflow-hidden bg-asphalt-900 mb-2">
        <img src="<?= upload_url('routes', $route->route_image); ?>" class="w-full h-full object-cover" alt="">
      </div>
    <?php endif; ?>
    <input type="file" name="route_image" accept="image/png,image/jpeg,image/webp"
      class="w-full text-sm border border-asphalt-800/20 rounded px-3 py-2 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:bg-ember-500 file:text-white file:font-medium">
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Notes for riders</label>
    <textarea name="notes" rows="3" class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none"><?= htmlspecialchars($route->notes ?? ''); ?></textarea>
  </div>

  <div class="flex items-center gap-3 pt-2 border-t border-asphalt-800/10 mt-2">
    <button type="submit" class="px-5 py-2.5 bg-ember-500 hover:bg-ember-600 text-white font-display font-semibold tracking-wide rounded transition-colors">
      <?= !empty($route) ? 'Save Changes' : 'Create Route'; ?>
    </button>
    <button type="button" @click="modal = null" class="text-sm text-asphalt-700/60 hover:text-asphalt-900">Cancel</button>
  </div>
</form>
