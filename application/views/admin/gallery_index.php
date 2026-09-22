<?php
// Format gallery data for Alpine.js state
$galleryItems = array_map(function ($g) {
  return [
    'id' => (int) $g->id,
    'image' => site_url('admin/gallery/image/' . rawurlencode($g->image)),
    'caption' => $g->caption ?: 'No caption',
    'submittedBy' => ($g->source === 'member_request') ? 'From ' . $g->submitted_by_name : '',
    'deleteUrl' => site_url('admin/gallery/delete/' . $g->id)
  ];
}, $gallery);
?>

<div x-data="{ 
    items: <?= htmlspecialchars(json_encode($galleryItems), ENT_QUOTES); ?>,
    modal: <?= htmlspecialchars(json_encode($open_modal), ENT_QUOTES); ?>, 
    delUrl: '', 
    lightboxIndex: null,
    fileCount: 0,
    uploadPreviews: [],
    
    // Multi-select state
    selected: [],
    selectMode: false,
    confirmBatchDelete: false,
    
    // Client-side Pagination (18 per page)
    currentPage: 1,
    perPage: 18,

    get totalPages() {
      return Math.ceil(this.items.length / this.perPage) || 1;
    },

    get paginatedItems() {
      let start = (this.currentPage - 1) * this.perPage;
      return this.items.slice(start, start + this.perPage);
    },

    nextImage() {
      if (!this.items || this.items.length === 0) return;
      this.lightboxIndex = (this.lightboxIndex + 1) % this.items.length;
    },

    prevImage() {
      if (!this.items || this.items.length === 0) return;
      this.lightboxIndex = (this.lightboxIndex - 1 + this.items.length) % this.items.length;
    },

    openLightbox(id) {
      const idx = this.items.findIndex(item => item.id === id);
      if (idx !== -1) {
        this.lightboxIndex = idx;
      }
    },

    toggleSelect(id) {
      if (this.selected.includes(id)) {
        this.selected = this.selected.filter(i => i !== id);
      } else {
        this.selected.push(id);
      }
    },

    selectAllOnPage() {
      let pageIds = this.paginatedItems.map(i => i.id);
      let allSelected = pageIds.every(id => this.selected.includes(id));
      if (allSelected) {
        this.selected = this.selected.filter(id => !pageIds.includes(id));
      } else {
        this.selected = Array.from(new Set([...this.selected, ...pageIds]));
      }
    },

    clearSelection() {
      this.selected = [];
      this.selectMode = false;
    },

    handleFileChange(event) {
      const files = Array.from(event.target.files);
      this.fileCount = files.length;
      this.uploadPreviews = files.map(file => URL.createObjectURL(file));
    },

    removePreview(index) {
      this.uploadPreviews.splice(index, 1);
      const input = $refs.fileInput;
      const dt = new DataTransfer();
      const { files } = input;
      for (let i = 0; i < files.length; i++) {
        if (i !== index) dt.items.add(files[i]);
      }
      input.files = dt.files;
      this.fileCount = input.files.length;
    },

    closeModal() {
      this.modal = null;
      this.uploadPreviews = [];
      this.fileCount = 0;
      if ($refs.fileInput) $refs.fileInput.value = '';
    }
}" x-cloak class="space-y-6">

  <!-- Header & Toolbar -->
  <div
    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-asphalt-800/10 shadow-xs">
    <div>
      <h1 class="text-xl font-display font-semibold text-asphalt-900">Ride Gallery</h1>
      <p class="text-asphalt-700/60 text-xs mt-0.5" x-text="items.length + ' total photos stored'"></p>
    </div>

    <div class="flex items-center gap-2">
      <!-- Select Mode Toggle -->
      <button type="button" @click="selectMode = !selectMode; if(!selectMode) selected = []"
        :class="selectMode ? 'bg-asphalt-900 text-white' : 'bg-asphalt-100 text-asphalt-800 hover:bg-asphalt-200'"
        class="px-3 py-2 text-xs font-semibold rounded-lg transition-colors flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span x-text="selectMode ? 'Cancel Selection' : 'Select Photos'"></span>
      </button>

      <!-- Upload Trigger -->
      <button type="button" @click="modal = 'add'"
        class="px-4 py-2 bg-ember-500 hover:bg-ember-600 text-white text-xs font-display font-semibold tracking-wide rounded-lg transition-all shadow-xs hover:shadow active:scale-95 flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Upload Photos
      </button>
    </div>
  </div>

  <!-- Multi-Select Action Banner -->
  <div x-show="selectMode" x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    class="flex items-center justify-between bg-asphalt-900 text-white px-4 py-3 rounded-lg shadow-md">

    <div class="flex items-center gap-3">
      <button type="button" @click="selectAllOnPage()"
        class="text-xs bg-asphalt-800 hover:bg-asphalt-700 px-2.5 py-1.5 rounded transition-colors">
        Toggle Current Page
      </button>
      <span class="text-xs text-asphalt-300" x-text="selected.length + ' selected'"></span>
    </div>

    <div class="flex items-center gap-2">
      <button type="button" :disabled="selected.length === 0" @click="confirmBatchDelete = true"
        :class="selected.length > 0 ? 'bg-red-600 hover:bg-red-700 text-white cursor-pointer' : 'bg-asphalt-800 text-asphalt-500 cursor-not-allowed'"
        class="px-3 py-1.5 text-xs font-medium rounded transition-colors flex items-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        Delete Selected (<span x-text="selected.length"></span>)
      </button>
    </div>
  </div>

  <!-- Gallery Frame -->
  <template x-if="items.length === 0">
    <div class="bg-white border border-asphalt-800/10 rounded-xl p-16 text-center text-asphalt-700/60 text-sm">
      No photos in gallery yet. Click above to add photos.
    </div>
  </template>

  <template x-if="items.length > 0">
    <div>
      <!-- Gallery Display Grid (18 items max per page) -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
        <template x-for="item in paginatedItems" :key="item.id">
          <div
            class="group relative bg-asphalt-950 rounded-lg overflow-hidden aspect-square shadow-xs hover:shadow-md transition-all duration-200 border border-asphalt-800/10">

            <!-- Thumbnail Image -->
            <img :src="item.image" loading="lazy"
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
              @click="selectMode ? toggleSelect(item.id) : openLightbox(item.id)" :alt="item.caption">

            <!-- Selection Checkbox (Active in Select Mode or Hover) -->
            <div class="absolute top-2 left-2 z-10" x-show="selectMode || selected.includes(item.id)">
              <input type="checkbox" :checked="selected.includes(item.id)" @click.stop="toggleSelect(item.id)"
                class="w-4 h-4 rounded border-asphalt-300 text-ember-500 focus:ring-ember-500 cursor-pointer">
            </div>

            <!-- Standard Hover Overlay -->
            <div x-show="!selectMode"
              class="absolute inset-0 bg-gradient-to-t from-asphalt-950/85 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col justify-between p-2 pointer-events-none">

              <div class="flex justify-end pointer-events-auto">
                <button type="button" @click.stop="delUrl = item.deleteUrl"
                  class="p-1 bg-red-600/90 hover:bg-red-600 text-white rounded transition-colors shadow-xs"
                  title="Delete Photo">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>

              <div class="pointer-events-auto cursor-pointer" @click="openLightbox(item.id)">
                <p class="text-[11px] text-white font-medium truncate leading-tight" x-text="item.caption"></p>
                <p x-show="item.submittedBy" class="text-[10px] text-ember-400 truncate leading-tight mt-0.5 text-white"
                  x-text="item.submittedBy"></p>
              </div>
            </div>

          </div>
        </template>
      </div>

      <!-- Pagination Bar -->
      <div x-show="totalPages > 1"
        class="flex items-center justify-between bg-white border border-asphalt-800/10 rounded-xl px-4 py-3 mt-6">
        <p class="text-xs text-asphalt-700/60">
          Showing <span class="font-semibold text-asphalt-900" x-text="((currentPage - 1) * perPage) + 1"></span>
          to <span class="font-semibold text-asphalt-900" x-text="Math.min(currentPage * perPage, items.length)"></span>
          of <span class="font-semibold text-asphalt-900" x-text="items.length"></span> photos
        </p>

        <div class="flex items-center gap-1">
          <!-- Previous Button -->
          <button type="button" @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1"
            :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-asphalt-100'"
            class="px-2.5 py-1.5 border border-asphalt-800/10 rounded text-xs font-medium text-asphalt-700 transition-colors">
            Prev
          </button>

          <!-- Numeric Pages -->
          <template x-for="p in totalPages" :key="p">
            <button type="button" @click="currentPage = p"
              :class="currentPage === p ? 'bg-ember-500 text-white font-semibold' : 'hover:bg-asphalt-100 text-asphalt-700'"
              class="w-7 h-7 flex items-center justify-center rounded text-xs transition-colors" x-text="p">
            </button>
          </template>

          <!-- Next Button -->
          <button type="button" @click="if(currentPage < totalPages) currentPage++"
            :disabled="currentPage === totalPages"
            :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-asphalt-100'"
            class="px-2.5 py-1.5 border border-asphalt-800/10 rounded text-xs font-medium text-asphalt-700 transition-colors">
            Next
          </button>
        </div>
      </div>
    </div>
  </template>


  <!-- ===== Fullscreen Lightbox Modal with Interactive Slide Controls ===== -->
  <!-- ===== Fullscreen Lightbox Modal with Interactive Slide Controls & Zoom ===== -->
<div x-show="lightboxIndex !== null" x-cloak
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
  x-effect="if(lightboxIndex === null) resetZoom()"
  class="fixed inset-0 z-50 flex items-center justify-center p-3 select-none"
  x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
  x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
  x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
  @keydown.escape.window="lightboxIndex = null; resetZoom();" 
  @keydown.arrow-right.window="if(lightboxIndex !== null) { nextImage(); resetZoom(); }"
  @keydown.arrow-left.window="if(lightboxIndex !== null) { prevImage(); resetZoom(); }">

  <div class="absolute inset-0 bg-asphalt-950/90 backdrop-blur-sm" @click="lightboxIndex = null; resetZoom();"></div>

  <div class="relative max-w-4xl w-full flex flex-col items-center z-10"
    x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150 transform"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">

    <!-- Image Box Container -->
    <div class="relative inline-block max-h-[75vh] rounded-xl overflow-hidden border border-asphalt-800/80 shadow-2xl bg-asphalt-900 group">

      <!-- Zoom Control Bar (Top-Left) -->
      <div class="absolute top-3 left-3 flex items-center gap-1 z-30 bg-asphalt-950/70 p-1 rounded-lg border border-asphalt-800/80 backdrop-blur-xs">
        <button type="button" @click.stop="zoom = Math.min(zoom + 0.5, 4)" class="p-1.5 text-chrome-200 hover:text-white transition-colors" title="Zoom In">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </button>
        <button type="button" @click.stop="zoom = Math.max(zoom - 0.5, 1); if(zoom === 1) resetZoom();" class="p-1.5 text-chrome-200 hover:text-white transition-colors" title="Zoom Out">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
        </button>
        <button type="button" @click.stop="resetZoom()" class="p-1.5 text-chrome-200 hover:text-white text-[10px] font-display font-bold uppercase px-1.5 transition-colors" title="Reset Zoom">
          Reset
        </button>
      </div>

      <!-- Upper-Right Close Button -->
      <button type="button" @click="lightboxIndex = null; resetZoom();"
        class="absolute top-3 right-3 z-30 p-2 bg-asphalt-950/70 hover:bg-asphalt-900 text-chrome-200 hover:text-white rounded-full border border-asphalt-800/80 transition-all duration-200 shadow-md active:scale-90"
        aria-label="Close preview">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Slide Previous Button (Inside Left) -->
      <template x-if="items && items.length > 1">
        <button type="button" @click.stop="prevImage(); resetZoom();"
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
          <img :src="items[lightboxIndex].image" :alt="items[lightboxIndex].caption"
            :style="`transform: scale(${zoom}) translate(${panX / zoom}px, ${panY / zoom}px); transition: ${isDragging ? 'none' : 'transform 0.2s ease-out'};`"
            class="max-h-[75vh] w-auto max-w-full object-contain block mx-auto select-none pointer-events-none">
        </template>
      </div>

      <!-- Slide Next Button (Inside Right) -->
      <template x-if="items && items.length > 1">
        <button type="button" @click.stop="nextImage(); resetZoom();"
          class="absolute right-3 top-1/2 -translate-y-1/2 p-2.5 text-chrome-200 hover:text-white bg-asphalt-950/70 hover:bg-asphalt-900 rounded-full border border-asphalt-800/80 transition-all duration-200 z-30 shadow-lg active:scale-90 opacity-80 hover:opacity-100"
          aria-label="Next image">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </template>
    </div>

    <!-- Caption, Submitter Info & Slide Counter -->
    <template x-if="items && items[lightboxIndex]">
      <div class="mt-3 text-center">
        <p class="text-sm font-medium text-asphalt-100" x-text="items[lightboxIndex].caption"></p>
        <p class="text-xs text-ember-400 mt-0.5 text-white" x-text="items[lightboxIndex].submittedBy"
          x-show="items[lightboxIndex].submittedBy"></p>
        <span
          class="text-[10px] font-display text-asphalt-400/80 mt-1.5 block font-semibold uppercase tracking-widest"
          x-text="`${lightboxIndex + 1} / ${items.length}`"></span>
      </div>
    </template>
  </div>
</div>

  <!-- ===== Batch Delete Confirmation Modal ===== -->
  <div x-show="confirmBatchDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/70 backdrop-blur-xs" @click="confirmBatchDelete = false"></div>
    <div class="relative bg-white rounded-lg shadow-xl w-full max-w-sm p-6 z-10"
      x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">
      <h2 class="font-display font-semibold text-lg text-asphalt-900 mb-2">Delete <span x-text="selected.length"></span>
        photo(s)?</h2>
      <p class="text-sm text-asphalt-700/70 mb-6">These photos will be permanently removed from the public gallery. This
        operation cannot be undone.</p>

      <form action="<?= site_url('admin/gallery/delete_batch'); ?>" method="post" class="flex items-center gap-3">
        <template x-for="id in selected" :key="id">
          <input type="hidden" name="ids[]" :value="id">
        </template>
        <button type="submit"
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-display font-semibold tracking-wide rounded-lg transition-colors">Delete
          Selected</button>
        <button type="button" @click="confirmBatchDelete = false"
          class="text-sm text-asphalt-700/60 hover:text-asphalt-900">Cancel</button>
      </form>
    </div>
  </div>


  <!-- ===== Upload Modal with Dynamic Previews ===== -->
  <div x-show="modal === 'add'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/70 backdrop-blur-xs" @click="closeModal()"></div>
    <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md z-10 overflow-hidden"
      x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">
      <div class="flex items-center justify-between px-6 py-4 border-b border-asphalt-800/10">
        <h2 class="font-display font-semibold text-lg text-asphalt-900">Upload Photos</h2>
        <button type="button" @click="closeModal()" class="text-asphalt-700/50 hover:text-asphalt-900"
          aria-label="Close">&times;</button>
      </div>
      <div class="p-6">
        <form action="<?= site_url('admin/gallery/add'); ?>" method="post" enctype="multipart/form-data"
          class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-asphalt-900 mb-1">Select Photo(s) *</label>
            <input type="file" name="images[]" x-ref="fileInput" multiple required
              accept="image/png,image/jpeg,image/webp" @change="handleFileChange($event)"
              class="w-full text-sm border border-asphalt-800/20 rounded-lg px-3 py-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-ember-500 file:text-white file:font-medium hover:file:bg-ember-600 file:transition-colors cursor-pointer">
            <p x-show="fileCount > 0" class="text-xs text-asphalt-700/70 mt-1.5"
              x-text="fileCount + ' file(s) selected'"></p>
          </div>

          <!-- Multiple Image Preview Grid -->
          <template x-if="uploadPreviews.length > 0">
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-asphalt-700 uppercase tracking-wider">Preview Selected
                Photos</label>
              <div
                class="grid grid-cols-4 gap-2 max-h-48 overflow-y-auto p-2 bg-asphalt-50 rounded-lg border border-asphalt-800/10">
                <template x-for="(src, idx) in uploadPreviews" :key="idx">
                  <div
                    class="relative group aspect-square rounded-md overflow-hidden bg-asphalt-900 border border-asphalt-800/20">
                    <img :src="src" class="w-full h-full object-cover">
                    <button type="button" @click="removePreview(idx)"
                      class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-0.5 opacity-80 hover:opacity-100 transition-opacity"
                      title="Remove image">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </template>
              </div>
            </div>
          </template>

          <div>
            <label class="block text-sm font-medium text-asphalt-900 mb-1">Caption (Optional)</label>
            <input type="text" name="caption" placeholder="Applied to all uploaded photos" maxlength="255"
              class="w-full border border-asphalt-800/20 rounded-lg px-3 py-2 text-sm focus:border-ember-500 outline-none">
          </div>
          <div class="flex items-center gap-3 pt-3 border-t border-asphalt-800/10 mt-2">
            <button type="submit"
              class="px-5 py-2.5 bg-ember-500 hover:bg-ember-600 text-white font-display font-semibold tracking-wide rounded-lg text-sm transition-all duration-150 active:scale-95">Upload
              Photos</button>
            <button type="button" @click="closeModal()"
              class="text-sm text-asphalt-700/60 hover:text-asphalt-900">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- ===== Single Delete Modal ===== -->
  <div x-show="delUrl !== ''" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition.opacity>
    <div class="absolute inset-0 bg-asphalt-950/70 backdrop-blur-xs" @click="delUrl = ''"></div>
    <div class="relative bg-white rounded-xl shadow-xl w-full max-w-sm p-6 z-10"
      x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">
      <h2 class="font-display font-semibold text-lg text-asphalt-900 mb-2">Remove this photo?</h2>
      <p class="text-sm text-asphalt-700/70 mb-6">It will be permanently removed from the public gallery. This cannot be
        undone.</p>
      <div class="flex items-center gap-3">
        <a :href="delUrl"
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-display font-semibold tracking-wide rounded-lg transition-colors">Delete</a>
        <button type="button" @click="delUrl = ''"
          class="text-sm text-asphalt-700/60 hover:text-asphalt-900">Cancel</button>
      </div>
    </div>
  </div>

</div>