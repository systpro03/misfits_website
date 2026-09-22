<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

  <!-- ==================== LEFT COLUMN: MAIN SITE SETTINGS ==================== -->
  <div class="lg:col-span-2">
    <form action="<?= base_url('admin/settings'); ?>" method="post" enctype="multipart/form-data"
      class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs overflow-hidden">
      <input type="hidden" name="form_action" value="site_info">

      <!-- Form Header -->
      <div class="px-6 py-5 border-b border-asphalt-800/10 bg-asphalt-900/[0.02]">
        <h2 class="font-display font-bold text-base text-asphalt-900 tracking-tight">Site &amp; Club Configuration</h2>
        <p class="text-xs text-asphalt-700/60 mt-0.5">Manage general club identity, branding assets, and contact
          details.</p>
      </div>

      <div class="p-6 space-y-8 divide-y divide-asphalt-800/10">

        <!-- Section 1: Club Info -->
        <div class="space-y-4">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="font-display font-semibold text-xs uppercase tracking-wider text-asphalt-700/70">General
              Information</h3>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Club Name <span
                  class="text-rose-500">*</span></label>
              <input type="text" name="club_name" required maxlength="150"
                value="<?= htmlspecialchars($site->club_name); ?>"
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all placeholder:text-asphalt-700/40">
            </div>
            <div>
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Founded Year</label>
              <input type="number" name="founded_year" min="1950" max="2100"
                value="<?= htmlspecialchars($site->founded_year); ?>"
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all">
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Tagline</label>
            <input type="text" name="tagline" maxlength="255" value="<?= htmlspecialchars($site->tagline); ?>"
              placeholder="e.g. Speed, Passion, Precision."
              class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all placeholder:text-asphalt-700/40">
          </div>

          <div>
            <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">About Text</label>
            <textarea name="about_text" rows="3" placeholder="Brief summary of the club..."
              class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 p-3.5 outline-none transition-all placeholder:text-asphalt-700/40 leading-relaxed"><?= htmlspecialchars($site->about_text); ?></textarea>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Vision</label>
              <textarea name="vision_text" rows="3"
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 p-3.5 outline-none transition-all leading-relaxed"><?= htmlspecialchars($site->vision_text); ?></textarea>
            </div>
            <div>
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Mission</label>
              <textarea name="mission_text" rows="3"
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 p-3.5 outline-none transition-all leading-relaxed"><?= htmlspecialchars($site->mission_text); ?></textarea>
            </div>
          </div>
        </div>

        <!-- Section 2: Branding -->
        <div class="pt-6 space-y-4">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="font-display font-semibold text-xs uppercase tracking-wider text-asphalt-700/70">Branding &amp;
              Assets</h3>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Logo Upload Card -->
            <div
              class="bg-asphalt-900/[0.02] border border-asphalt-800/10 rounded-2xl p-4 flex flex-col justify-between">
              <div>
                <label class="block text-xs font-semibold text-asphalt-900 mb-2">Logo Image</label>
                <div class="flex items-center gap-4 mb-3">
                  <?php if (!empty($site->logo_image)): ?>
                    <div
                      class="w-16 h-16 rounded-xl overflow-hidden bg-asphalt-950 border border-asphalt-800/10 flex items-center justify-center p-2 flex-shrink-0 shadow-xs">
                      <img src="<?= upload_url('branding', $site->logo_image); ?>" class="w-full h-full object-contain"
                        alt="Club Logo">
                    </div>
                  <?php else: ?>
                    <div
                      class="w-16 h-16 rounded-xl bg-asphalt-900/5 border border-dashed border-asphalt-800/20 flex flex-col items-center justify-center text-asphalt-700/40 flex-shrink-0">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  <?php endif; ?>
                  <p class="text-[11px] text-asphalt-700/60 leading-relaxed">Recommended PNG or SVG with transparent
                    background.</p>
                </div>
              </div>
              <input type="file" name="logo_image" accept="image/*"
                class="w-full text-xs text-asphalt-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-asphalt-900/10 file:text-asphalt-900 hover:file:bg-asphalt-900/20 file:transition-colors cursor-pointer">
            </div>

            <!-- Hero Upload Card -->
            <div
              class="bg-asphalt-900/[0.02] border border-asphalt-800/10 rounded-2xl p-4 flex flex-col justify-between">
              <div>
                <label class="block text-xs font-semibold text-asphalt-900 mb-2">Hero Background</label>
                <div class="mb-3">
                  <?php if (!empty($site->hero_image)): ?>
                    <div
                      class="w-full h-16 rounded-xl overflow-hidden bg-asphalt-950 border border-asphalt-800/10 shadow-xs">
                      <img src="<?= upload_url('branding', $site->hero_image); ?>" class="w-full h-full object-cover"
                        alt="Hero Background">
                    </div>
                  <?php else: ?>
                    <div
                      class="w-full h-16 rounded-xl bg-asphalt-900/5 border border-dashed border-asphalt-800/20 flex items-center justify-center text-asphalt-700/40">
                      <span class="text-xs">No hero background uploaded</span>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <input type="file" name="hero_image" accept="image/*"
                class="w-full text-xs text-asphalt-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-asphalt-900/10 file:text-asphalt-900 hover:file:bg-asphalt-900/20 file:transition-colors cursor-pointer">
            </div>
          </div>
        </div>

        <!-- Section 3: Contact & Socials -->
        <div class="pt-6 space-y-4">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <h3 class="font-display font-semibold text-xs uppercase tracking-wider text-asphalt-700/70">Contact &amp;
              Social Links</h3>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Contact Email</label>
              <input type="email" name="contact_email" value="<?= htmlspecialchars($site->contact_email); ?>"
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all">
            </div>
            <div>
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Contact Phone</label>
              <input type="text" name="contact_phone" value="<?= htmlspecialchars($site->contact_phone); ?>"
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all">
            </div>
            <div>
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Facebook URL</label>
              <input type="url" name="facebook_url" value="<?= htmlspecialchars($site->facebook_url); ?>"
                placeholder="https://facebook.com/..."
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all placeholder:text-asphalt-700/40">
            </div>
            <div>
              <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Instagram URL</label>
              <input type="url" name="instagram_url" value="<?= htmlspecialchars($site->instagram_url); ?>"
                placeholder="https://instagram.com/..."
                class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all placeholder:text-asphalt-700/40">
            </div>
          </div>
        </div>

      </div>

      <!-- Form Footer / Submit -->
      <div class="px-6 py-4 bg-asphalt-900/[0.02] border-t border-asphalt-800/10 flex justify-end">
        <button type="submit"
          class="px-5 py-2.5 bg-ember-500 hover:bg-ember-600 text-white font-display font-semibold text-xs tracking-wide rounded-xl transition-all shadow-xs active:scale-95 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Save Site Settings
        </button>
      </div>
    </form>
  </div>

  <!-- ==================== RIGHT COLUMN: CHANGE PASSWORD ==================== -->
  <div class="lg:col-span-1">
    <form action="<?= base_url('admin/settings'); ?>" method="post"
      class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs overflow-hidden sticky top-6">
      <input type="hidden" name="form_action" value="password">

      <!-- Header -->
      <div class="px-6 py-5 border-b border-asphalt-800/10 bg-asphalt-900/[0.02] flex items-center gap-2.5">
        <div
          class="w-8 h-8 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
        <div>
          <h2 class="font-display font-bold text-base text-asphalt-900 tracking-tight">Security</h2>
          <p class="text-xs text-asphalt-700/60">Update account password</p>
        </div>
      </div>

      <!-- Form Body -->
      <div class="p-6 space-y-4">
        <div>
          <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">New Password <span
              class="text-rose-500">*</span></label>
          <input type="password" name="new_password" required minlength="8" placeholder="At least 8 characters"
            class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all placeholder:text-asphalt-700/40">
        </div>

        <div>
          <label class="block text-xs font-semibold text-asphalt-900 mb-1.5">Confirm Password <span
              class="text-rose-500">*</span></label>
          <input type="password" name="confirm_password" required minlength="8" placeholder="Repeat new password"
            class="w-full bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 rounded-xl border border-asphalt-800/10 focus:border-ember-500/80 focus:ring-2 focus:ring-ember-500/20 px-3.5 py-2.5 outline-none transition-all placeholder:text-asphalt-700/40">
        </div>
      </div>

      <!-- Footer -->
      <div class="px-6 py-4 bg-asphalt-900/[0.02] border-t border-asphalt-800/10">
        <button type="submit"
          class="w-full py-2.5 bg-asphalt-900 hover:bg-asphalt-950 text-white font-display font-semibold text-xs tracking-wide rounded-xl transition-all shadow-xs active:scale-95 flex items-center justify-center gap-2">
          Update Password
        </button>
      </div>
    </form>
  </div>

</div>