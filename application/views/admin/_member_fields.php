<form action="<?= $action_url; ?>" 
  method="post" 
  enctype="multipart/form-data" 
  x-data="{ imagePreview: '<?= (!empty($member->image)) ? upload_url('members', $member->image) : ''; ?>' }"
  class="space-y-5">

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Full name *</label>
      <input type="text" name="full_name" required maxlength="120" value="<?= htmlspecialchars($member->full_name ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Road name / nickname</label>
      <input type="text" name="road_name" maxlength="80" value="<?= htmlspecialchars($member->road_name ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Position / role *</label>
      <input type="text" name="position" required maxlength="80" placeholder="e.g. President, Road Captain, Member" value="<?= htmlspecialchars($member->position ?? 'Member'); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Bike model</label>
      <input type="text" name="bike_model" maxlength="120" value="<?= htmlspecialchars($member->bike_model ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Bio</label>
    <textarea name="bio" rows="3" class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none"><?= htmlspecialchars($member->bio ?? ''); ?></textarea>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Instagram handle</label>
      <input type="text" name="instagram_handle" maxlength="100" placeholder="@handle" value="<?= htmlspecialchars($member->instagram_handle ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Joined date</label>
      <input type="date" name="joined_date" value="<?= htmlspecialchars($member->joined_date ?? ''); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
    </div>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Display order ( Optional )</label>
      <input type="number" name="display_order" value="<?= htmlspecialchars($member->display_order ?? '0'); ?>"
        class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
      <p class="text-xs text-asphalt-700/50 mt-1">Lower numbers appear first.</p>
    </div>
    <div>
      <label class="block text-sm font-medium text-asphalt-900 mb-1">Status *</label>
      <select name="status" required class="w-full border border-asphalt-800/20 rounded px-3 py-2 focus:border-ember-500 outline-none">
        <option value="active" <?= (isset($member->status) && $member->status === 'active') ? 'selected' : ''; ?>>Active</option>
        <option value="inactive" <?= (isset($member->status) && $member->status === 'inactive') ? 'selected' : ''; ?>>Inactive (hidden from site)</option>
      </select>
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-asphalt-900 mb-1">Photo</label>

    <!-- Photo Preview Area (Displayed above input) -->
    <div x-show="imagePreview" class="mb-3 flex items-center gap-3">
      <div class="w-16 h-16 rounded-full overflow-hidden bg-asphalt-900 border border-asphalt-800/20 shadow-sm flex-shrink-0">
        <img :src="imagePreview" class="w-full h-full object-cover" alt="Member Photo Preview">
      </div>
    </div>

    <!-- File Input -->
    <input type="file" name="image" accept="image/png,image/jpeg,image/webp,image/jpg,image/jfif"
      @change="
        const file = $event.target.files[0];
        if (file) {
          imagePreview = URL.createObjectURL(file);
        }
      "
      class="w-full text-sm border border-asphalt-800/20 rounded px-3 py-2 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:bg-ember-500 file:text-white file:font-medium file:cursor-pointer hover:file:bg-ember-600 transition-colors">
  </div>

  <div class="flex items-center gap-3 pt-2 border-t border-asphalt-800/10 mt-2">
    <button type="submit" class="px-5 py-2.5 bg-ember-500 hover:bg-ember-600 text-white font-display font-semibold tracking-wide rounded transition-colors">
      <?= !empty($member) ? 'Save Changes' : 'Add Member'; ?>
    </button>
    <button type="button" @click="modal = null" class="text-sm text-asphalt-700/60 hover:text-asphalt-900">Cancel</button>
  </div>
</form>