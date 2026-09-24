<?php
// ================= PAGINATION SETUP =================
$items_per_page = 18;
$total_items = count($gallery ?? []);
$total_pages = max(1, ceil($total_items / $items_per_page));

// Read current page from GET query param, default to 1
$current_page = isset($_GET[ 'page' ]) ? (int) $_GET[ 'page' ] : 1;
if ($current_page < 1)
  $current_page = 1;
if ($current_page > $total_pages)
  $current_page = $total_pages;

// Slice gallery items for current page
$offset = ($current_page - 1) * $items_per_page;
$page_gallery = array_slice($gallery ?? [], $offset, $items_per_page);

// Format gallery items for Alpine.js lightbox navigation
$formatted_gallery = [];
foreach (array_values($page_gallery) as $g) {
  $formatted_gallery[] = [
    'src' => upload_url('gallery', $g->image),
    'caption' => $g->caption ?? ''
  ];
}
$json_gallery = htmlspecialchars(json_encode($formatted_gallery, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8');
?>

<style>
  [x-cloak] {
    display: none !important;
  }
</style>

<!-- Container wrapping page and Alpine lightbox state -->
<div x-data="{ 
    lightboxOpen: false, 
    lightboxIndex: 0,
    items: <?= $json_gallery; ?>,
    submitModalOpen: false,
    submittingPhoto: false
  }" class="relative">

  <!-- ================= PAGE HEADER ================= -->
  <section
    class="relative bg-asphalt-950 text-chrome-200 py-10 md:py-14 overflow-hidden border-b border-asphalt-800/80">
    <div class="absolute inset-y-0 right-[-10%] w-1/2 bg-ember-500/10 -skew-x-12 pointer-events-none blur-2xl"></div>
    <div
      class="absolute top-1/2 left-0 -translate-y-1/2 w-48 h-48 bg-ember-500/5 rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="relative max-w-6xl mx-auto px-4">
      <p class="font-display text-ember-500 tracking-[0.2em] text-[10px] md:text-xs font-bold uppercase mb-1.5">FROM THE
        ROAD</p>
      <h1
        class="font-display font-bold text-3xl sm:text-4xl md:text-5xl max-w-3xl leading-[1.05] text-white tracking-tight">
        Ride Gallery
      </h1>
    </div>
  </section>

  <!-- ================= GALLERY GRID (6 PER ROW) ================= -->
  <section id="gallery-grid" class="max-w-6xl mx-auto px-4 py-8 md:py-12 mt-3 scroll-mt-24">
    <?php if (empty($gallery)): ?>
      <div class="bg-paper-50 border border-asphalt-800/10 rounded-xl p-6 text-center">
        <p class="text-asphalt-700/60 font-display text-sm">No photos yet — be the first to submit one below.</p>
      </div>
    <?php else: ?>
      <!-- 6 Columns Display on Desktop -->
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-2.5">
        <?php foreach ($page_gallery as $idx => $g): ?>
          <?php $img_url = upload_url('gallery', $g->image); ?>
          <div
            class="group relative aspect-square rounded-lg overflow-hidden bg-asphalt-900 cursor-pointer shadow-2xs border border-asphalt-800/10 hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5"
            @click="lightboxIndex = <?= $idx; ?>; lightboxOpen = true;">

            <img src="<?= $img_url; ?>" alt="<?= htmlspecialchars($g->caption ?? ''); ?>"
              class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
              onerror="this.parentElement.style.display='none'">

            <!-- Hover Glassmorphism Overlay with Preview Icon & Caption -->
            <div
              class="absolute inset-0 bg-asphalt-950/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-between p-2 text-center">
              <div></div>
              <div
                class="w-6 h-6 rounded-full bg-ember-500 text-asphalt-950 flex items-center justify-center transform scale-50 group-hover:scale-100 transition-all duration-300 shadow-md">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                </svg>
              </div>

              <?php if (!empty($g->caption)): ?>
                <p class="text-[10px] text-chrome-200 line-clamp-2 font-display leading-tight truncate w-full">
                  <?= htmlspecialchars($g->caption); ?>
                </p>
              <?php else: ?>
                <div></div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- ================= PAGINATION CONTROLS ================= -->
      <?php if ($total_pages > 1): ?>
        <div class="mt-10 flex items-center justify-center gap-1.5">
          <?php if ($current_page > 1): ?>
            <a href="?page=<?= $current_page - 1; ?>#gallery-grid"
              class="px-2.5 py-1.5 rounded-md border border-asphalt-800/10 bg-white font-display text-[11px] font-bold uppercase text-asphalt-900 hover:border-ember-500 hover:text-ember-600 transition-all shadow-2xs">
              &larr; Prev
            </a>
          <?php endif; ?>

          <div class="flex items-center gap-1 px-1">
            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
              <?php if ($p == $current_page): ?>
                <span
                  class="w-7 h-7 flex items-center justify-center rounded-md bg-ember-500 text-asphalt-950 font-display font-bold text-[11px] shadow-2xs">
                  <?= $p; ?>
                </span>
              <?php else: ?>
                <a href="?page=<?= $p; ?>#gallery-grid"
                  class="w-7 h-7 flex items-center justify-center rounded-md border border-asphalt-800/10 bg-white text-asphalt-900 font-display font-bold text-[11px] hover:border-ember-500 hover:text-ember-600 transition-all shadow-2xs">
                  <?= $p; ?>
                </a>
              <?php endif; ?>
            <?php endfor; ?>
          </div>

          <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?= $current_page + 1; ?>#gallery-grid"
              class="px-2.5 py-1.5 rounded-md border border-asphalt-800/10 bg-white font-display text-[11px] font-bold uppercase text-asphalt-900 hover:border-ember-500 hover:text-ember-600 transition-all shadow-2xs">
              Next &rarr;
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </section>

  <!-- ================= SUBMIT PHOTO SECTION ================= -->
  <section id="submit" class="bg-paper-50 border-t border-asphalt-800/10 py-10 md:py-12">
    <div class="max-w-md mx-auto px-4 text-center">
      <button type="button" @click="submitModalOpen = true"
        class="px-7 py-3.5 bg-ember-500 hover:bg-ember-600 text-asphalt-950 font-display font-bold text-sm tracking-wider uppercase rounded-xl transition-all shadow-md active:scale-95">
        Submit a Photo
      </button>
    </div>

  </section>

  <!-- ================= SUBMIT PHOTO MODAL ================= -->
  <div x-cloak x-show="submitModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition.opacity @keydown.escape.window="submitModalOpen = false">
    <div class="absolute inset-0 bg-asphalt-950/70 backdrop-blur-sm" @click="submitModalOpen = false"></div>
    <div class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-2xl bg-white text-asphalt-900 shadow-2xl" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="flex items-center justify-between border-b border-asphalt-800/10 px-6 py-4">
        <div><p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ember-600">Share a Moment</p><h2 class="font-display text-xl font-bold">Submit Photos</h2></div>
        <button type="button" @click="submitModalOpen = false" class="rounded-lg p-2 text-asphalt-700/50 hover:bg-asphalt-900/10 hover:text-asphalt-900" aria-label="Close modal">&times;</button>
      </div>
      <form action="<?= base_url('gallery/submit'); ?>" method="post" enctype="multipart/form-data" class="space-y-4 p-6" x-data="{ files: [], previews: [], select(e) { this.previews.forEach(url => URL.revokeObjectURL(url)); this.files = Array.from(e.target.files); this.previews = this.files.map(f => URL.createObjectURL(f)); }, remove(i) { URL.revokeObjectURL(this.previews[i]); this.files.splice(i,1); this.previews.splice(i,1); const dt = new DataTransfer(); this.files.forEach(f => dt.items.add(f)); this.$refs.input.files = dt.files; } }" @submit="if (!files.length || !$refs.input.files.length) { $event.preventDefault(); $refs.input.reportValidity(); } else { submittingPhoto = true; }">
        <div><label for="gallery_submitter_name" class="mb-1 block text-xs font-bold">Your Name *</label><input id="gallery_submitter_name" type="text" name="submitter_name" required maxlength="120" class="w-full rounded-lg border border-asphalt-800/20 px-3 py-2 text-sm outline-none focus:border-ember-500"></div>
        <div><label for="gallery_submitter_email" class="mb-1 block text-xs font-bold">Email (optional)</label><input id="gallery_submitter_email" type="email" name="submitter_email" maxlength="150" class="w-full rounded-lg border border-asphalt-800/20 px-3 py-2 text-sm outline-none focus:border-ember-500"></div>
        <div><label for="gallery_caption" class="mb-1 block text-xs font-bold">Caption / Note (optional)</label><input id="gallery_caption" type="text" name="caption" maxlength="255" placeholder="Where were these photos taken?" class="w-full rounded-lg border border-asphalt-800/20 px-3 py-2 text-sm outline-none focus:border-ember-500"></div>
        <div><label for="gallery_images" class="mb-1 block text-xs font-bold">Photos *</label><input id="gallery_images" x-ref="input" @change="select($event)" type="file" name="images[]" accept="image/png,image/jpeg,image/webp" multiple required class="w-full rounded-lg border border-asphalt-800/20 p-2 text-xs"><p class="mt-1 text-[10px] text-asphalt-700/60">JPG, PNG or WEBP up to 5MB each.</p></div>
        <div x-show="previews.length" class="grid grid-cols-4 gap-2 rounded-lg bg-paper-50 p-2"><template x-for="(src,i) in previews" :key="i"><div class="relative aspect-square overflow-hidden rounded-md"><img :src="src" class="h-full w-full object-cover"><button type="button" @click="remove(i)" class="absolute right-1 top-1 rounded-full bg-black/70 px-1.5 text-white">&times;</button></div></template></div>
        <button type="submit" :disabled="submittingPhoto" class="w-full rounded-lg bg-ember-500 py-3 text-xs font-bold uppercase tracking-wider text-asphalt-950 hover:bg-ember-600 disabled:opacity-70 disabled:cursor-not-allowed transition-all">
          <span x-show="!submittingPhoto">Submit Photos for Review</span>
          <span x-show="submittingPhoto" class="inline-flex items-center justify-center gap-2">
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path></svg>
            Submitting Photo...
          </span>
        </button>
      </form>
    </div>
  </div>

  <!-- ================= LIGHTBOX MODAL PREVIEW ================= -->
<div x-cloak x-show="lightboxOpen" 
  x-data="{
    zoom: 1,
    panX: 0,
    panY: 0,
    isDragging: false,
    startX: 0,
    startY: 0,
    resetZoom() {
      this.zoom = 1;
      this.panX = 0;
      this.panY = 0;
    },
    toggleZoom(e) {
      if (this.zoom > 1) {
        this.resetZoom();
      } else {
        this.zoom = 2.5;
        // Center zoom relative to click location
        const rect = e.currentTarget.getBoundingClientRect();
        this.panX = (rect.width / 2 - (e.clientX - rect.left)) * 1.5;
        this.panY = (rect.height / 2 - (e.clientY - rect.top)) * 1.5;
      }
    },
    startDrag(e) {
      if (this.zoom <= 1) return;
      this.isDragging = true;
      this.startX = e.clientX - this.panX;
      this.startY = e.clientY - this.panY;
    },
    drag(e) {
      if (!this.isDragging) return;
      this.panX = e.clientX - this.startX;
      this.panY = e.clientY - this.startY;
    },
    stopDrag() {
      this.isDragging = false;
    }
  }"
  x-effect="if(lightboxIndex !== null || !lightboxOpen) resetZoom()"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-md"
  x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-md"
  x-transition:leave-end="opacity-0 backdrop-blur-none" 
  @keydown.escape.window="lightboxOpen = false"
  @keydown.arrow-right.window="if(lightboxOpen && items.length) { lightboxIndex = (lightboxIndex + 1) % items.length; resetZoom(); }"
  @keydown.arrow-left.window="if(lightboxOpen && items.length) { lightboxIndex = (lightboxIndex - 1 + items.length) % items.length; resetZoom(); }"
  class="fixed inset-0 z-50 flex items-center justify-center bg-asphalt-950/80 p-3 select-none">

  <!-- Image & Caption Container -->
  <div @click.away="lightboxOpen = false; resetZoom();" x-show="lightboxOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
    class="max-w-4xl w-full flex flex-col items-center z-10 relative">

    <!-- Image Box Container -->
    <div class="relative inline-block max-h-[75vh] rounded-xl overflow-hidden border border-asphalt-800/80 shadow-xl bg-asphalt-900 group">

      <!-- Zoom UI Controls Top-Left -->
      <div class="absolute top-3 left-3 flex items-center gap-1 z-30 bg-asphalt-950/70 p-1 rounded-lg border border-asphalt-800/80 backdrop-blur-xs">
        <button @click.stop="zoom = Math.min(zoom + 0.5, 4)" class="p-1.5 text-chrome-200 hover:text-white transition-colors" title="Zoom In">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </button>
        <button @click.stop="zoom = Math.max(zoom - 0.5, 1); if(zoom===1) resetZoom();" class="p-1.5 text-chrome-200 hover:text-white transition-colors" title="Zoom Out">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
        </button>
        <button @click.stop="resetZoom()" class="p-1.5 text-chrome-200 hover:text-white text-[10px] font-display font-bold uppercase px-1.5 transition-colors" title="Reset Zoom">
          Reset
        </button>
      </div>

      <!-- Upper-Right Close Button inside Image Frame -->
      <button @click.stop="lightboxOpen = false; resetZoom();"
        class="absolute top-3 right-3 p-2 text-chrome-200 hover:text-white bg-asphalt-950/70 hover:bg-asphalt-900 rounded-full border border-asphalt-800/80 transition-all duration-200 z-30 shadow-md active:scale-90"
        aria-label="Close preview">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Previous Button -->
      <template x-if="items && items.length > 1">
        <button @click.stop="lightboxIndex = (lightboxIndex - 1 + items.length) % items.length; resetZoom();"
          class="absolute left-3 top-1/2 -translate-y-1/2 p-2.5 text-chrome-200 hover:text-white bg-asphalt-950/70 hover:bg-asphalt-900 rounded-full border border-asphalt-800/80 transition-all duration-200 z-30 shadow-lg active:scale-90 opacity-80 hover:opacity-100"
          aria-label="Previous image">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
      </template>

      <!-- Active Lightbox Image (Zoomable & Draggable) -->
      <div class="overflow-hidden cursor-grab active:cursor-grabbing"
           @dblclick="toggleZoom($event)"
           @mousedown="startDrag($event)"
           @mousemove.window="drag($event)"
           @mouseup.window="stopDrag()"
           @wheel.prevent="if($event.deltaY < 0) { zoom = Math.min(zoom + 0.2, 4); } else { zoom = Math.max(zoom - 0.2, 1); if(zoom === 1) resetZoom(); }">
        <template x-if="items && items[lightboxIndex]">
          <img :src="items[lightboxIndex].src" :alt="items[lightboxIndex].caption"
            :style="`transform: scale(${zoom}) translate(${panX / zoom}px, ${panY / zoom}px); transition: ${isDragging ? 'none' : 'transform 0.2s ease-out'};`"
            class="max-h-[75vh] w-auto object-contain block mx-auto pointer-events-none select-none">
        </template>
      </div>

      <!-- Next Button -->
      <template x-if="items && items.length > 1">
        <button @click.stop="lightboxIndex = (lightboxIndex + 1) % items.length; resetZoom();"
          class="absolute right-3 top-1/2 -translate-y-1/2 p-2.5 text-chrome-200 hover:text-white bg-asphalt-950/70 hover:bg-asphalt-900 rounded-full border border-asphalt-800/80 transition-all duration-200 z-30 shadow-lg active:scale-90 opacity-80 hover:opacity-100"
          aria-label="Next image">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </template>
    </div>

    <!-- Caption & Counter -->
    <template x-if="items && items[lightboxIndex]">
      <div class="mt-2.5 text-center">
        <p x-text="items[lightboxIndex].caption"
          class="font-display text-xs tracking-wide text-chrome-200/90 max-w-lg min-h-[1rem]"></p>
        <span class="text-[10px] font-display text-chrome-200/50 mt-1 block font-semibold uppercase tracking-widest"
          x-text="`${lightboxIndex + 1} / ${items.length}`"></span>
      </div>
    </template>
  </div>

</div>

</div>
