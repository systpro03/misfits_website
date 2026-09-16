<div x-data="adminChat()" x-cloak class="space-y-6">
  <!-- Delete confirmation modal -->
  <div x-show="confirmOpen" x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-asphalt-950/60 backdrop-blur-sm" @keydown.escape.window="confirmOpen = false" style="display:none;">
    <div x-show="confirmOpen" x-transition class="w-full max-w-sm bg-white rounded-2xl shadow-2xl border border-asphalt-800/10 overflow-hidden" @click.outside="confirmOpen = false">
      <div class="p-5">
        <div class="flex items-start gap-3">
          <div class="w-10 h-10 shrink-0 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 4.5l-7.2 13A1.7 1.7 0 004.6 20h14.8a1.7 1.7 0 001.5-2.5l-7.2-13a1.7 1.7 0 00-3.4 0z"/></svg>
          </div>
          <div>
            <h3 class="font-display font-bold text-sm text-asphalt-900">Delete message?</h3>
            <p class="text-xs text-asphalt-700/60 mt-1 leading-relaxed">This message will be permanently removed from the shared chat.</p>
          </div>
        </div>
        <div class="mt-5 flex gap-2 justify-end">
          <button type="button" @click="confirmOpen = false" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-asphalt-900 bg-asphalt-900/5 hover:bg-asphalt-900/10 transition-colors">Cancel</button>
          <button type="button" @click="confirmDelete()" :disabled="deleting" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
            <span x-text="deleting ? 'Deleting...' : 'Delete Message'"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-asphalt-800/10 p-4 rounded-2xl shadow-xs">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-ember-500/10 text-ember-500 flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5m7-2a8 8 0 01-8 8 8.5 8.5 0 01-3.8-.9L4 20l.9-3.2A8 8 0 1112 20z"/></svg>
      </div>
      <div>
        <h1 class="text-lg font-display font-bold text-asphalt-900 tracking-tight">Guest Chat</h1>
        <p class="text-asphalt-700/60 text-xs">Manage visitor messages and reply as MISFITS.</p>
      </div>
      <span class="px-2.5 py-1 text-xs font-semibold text-asphalt-800 bg-asphalt-900/5 rounded-full border border-asphalt-800/10" x-text="messages.length + ' Messages'"></span>
    </div>
    <div class="flex items-center gap-2">
      <button type="button" @click="load()" :disabled="loading" class="px-3.5 py-2 bg-asphalt-900/5 hover:bg-asphalt-900/10 text-asphalt-900 text-xs font-semibold rounded-xl transition-all disabled:opacity-50">
        <span x-text="loading ? 'Refreshing...' : 'Refresh'"></span>
      </button>
    </div>
  </div>

  <div class="bg-white border border-asphalt-800/10 rounded-2xl shadow-xs overflow-hidden">
    <div class="px-5 py-4 border-b border-asphalt-800/10 flex items-center justify-between bg-white sticky top-0 z-10">
      <div>
        <h2 class="font-display font-semibold text-sm text-asphalt-900">Conversation</h2>
        <p class="text-[11px] text-asphalt-700/50 mt-0.5">Messages are shared across visitors. New guest messages are marked read when opened here.</p>
      </div>
      <span class="text-[11px] text-emerald-600 font-semibold" x-show="!error">Live</span>
    </div>

    <div class="p-5 bg-asphalt-900/[0.025] min-h-[420px] max-h-[62vh] overflow-y-auto" x-ref="messageList">
      <template x-if="loading && !messages.length">
        <div class="py-16 text-center text-xs text-asphalt-700/50">Loading messages...</div>
      </template>

      <template x-if="!loading && !messages.length">
        <div class="py-16 text-center">
          <div class="w-12 h-12 rounded-full bg-asphalt-900/5 text-asphalt-700/40 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M8 10h8M8 14h5m7-2a8 8 0 01-8 8 8.5 8.5 0 01-3.8-.9L4 20l.9-3.2A8 8 0 1112 20z"/></svg>
          </div>
          <h3 class="text-sm font-semibold text-asphalt-900">No chat messages yet</h3>
          <p class="text-xs text-asphalt-700/50 mt-1">Guest messages will appear here.</p>
        </div>
      </template>

      <div class="space-y-4">
        <template x-for="item in messages" :key="item.id">
          <div class="flex gap-3" :class="Number(item.is_admin) === 1 ? 'justify-end' : 'justify-start'">
            <div class="max-w-[88%] sm:max-w-[70%]">
              <div class="flex items-center gap-2 mb-1" :class="Number(item.is_admin) === 1 ? 'justify-end' : 'justify-start'">
                <span class="text-[11px] font-bold" :class="Number(item.is_admin) === 1 ? 'text-ember-600' : 'text-asphalt-900'" x-text="Number(item.is_admin) === 1 ? 'MISFITS ADMIN' : (item.guest_name || 'Guest Rider')"></span>
                <span class="text-[10px] text-asphalt-700/40" x-text="formatTime(item.created_at)"></span>
              </div>
              <div class="flex items-end gap-1.5" :class="Number(item.is_admin) === 1 ? 'justify-end' : 'justify-start'">
                <div class="px-4 py-3 rounded-2xl text-xs leading-relaxed border" :class="Number(item.is_admin) === 1 ? 'bg-ember-500 text-white border-ember-500 rounded-br-md' : 'bg-white text-asphalt-900 border-asphalt-800/10 rounded-bl-md shadow-xs'">
                  <p class="whitespace-pre-wrap break-words" x-text="item.message"></p>
                </div>
                <button type="button" @click="remove(item.id)" class="shrink-0 w-7 h-7 inline-flex items-center justify-center rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 transition-colors" title="Delete message" aria-label="Delete message">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 7h12m-9 0V5h6v2m-7 4v6m4-6v6m4-6v6M8 21h8a1 1 0 001-1V7H7v13a1 1 0 001 1z"/></svg>
                </button>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>

    <div class="border-t border-asphalt-800/10 p-4 bg-white">
      <div class="mb-2 flex items-center justify-between">
        <label class="text-[11px] font-semibold uppercase tracking-wider text-asphalt-700/50">Reply as MISFITS ADMIN</label>
        <span class="text-[10px] text-asphalt-700/40" x-text="reply.length + '/500'"></span>
      </div>
      <div class="flex flex-col sm:flex-row gap-2">
        <input type="text" x-model="reply" maxlength="500" @keydown.enter.prevent="send()" placeholder="Write a reply to the chat..." class="flex-1 bg-asphalt-900/5 focus:bg-white text-xs text-asphalt-900 border border-asphalt-800/10 focus:border-ember-500 rounded-xl px-3 py-2.5 outline-none placeholder:text-asphalt-700/40">
        <button type="button" @click="send()" x-bind:disabled="sending || !reply.trim()" x-bind:class="(sending || !reply.trim()) ? 'bg-gray-300 text-gray-500 border border-gray-300 cursor-not-allowed' : 'bg-ember-500 hover:bg-ember-600 text-white border border-ember-500'" class="px-5 py-2.5 text-xs font-display font-semibold tracking-wide rounded-xl transition-all shadow-xs">
          <span x-text="sending ? 'Sending...' : 'Send Reply'"></span>
        </button>
      </div>
      <p x-show="error" x-text="error" class="text-xs text-rose-600 mt-2"></p>
      <p x-show="notice" x-text="notice" class="text-xs text-emerald-600 mt-2"></p>
    </div>
  </div>
</div>

<script>
function adminChat() {
  return {
    messages: <?= json_encode($messages); ?>,
    reply: '',
    loading: false,
    sending: false,
    error: '',
    notice: '',
    timer: null,
    confirmOpen: false,
    deleteId: null,
    deleting: false,

    init() {
      this.markRead();
      this.timer = setInterval(() => this.load(), 4000);
    },

    formatTime(value) {
      if (!value) return '';
      var d = new Date(String(value).replace(' ', 'T'));
      if (isNaN(d.getTime())) return value;
      return d.toLocaleDateString([], { month: 'short', day: 'numeric' }) + ' ' + d.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
    },

    load() {
      this.loading = true;
      fetch('<?= site_url('admin/messages'); ?>', { headers: { Accept: 'application/json' } })
        .then(r => r.json())
        .then(result => {
          if (!result.success) throw new Error(result.message || 'Unable to load messages.');
          this.messages = result.data || [];
          this.error = '';
          this.$nextTick(() => { this.$refs.messageList.scrollTop = this.$refs.messageList.scrollHeight; });
        })
        .catch(e => { this.error = e.message; })
        .finally(() => { this.loading = false; });
    },

    markRead() {
      fetch('<?= site_url('admin/mark-read'); ?>', { method: 'POST', headers: { Accept: 'application/json' } }).catch(() => {});
    },

    send() {
      if (!this.reply.trim() || this.sending) return;
      this.sending = true;
      this.error = '';
      this.notice = '';
      var body = new URLSearchParams();
      body.set('message', this.reply.trim());

      fetch('<?= site_url('admin/send'); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8', Accept: 'application/json' },
        body: body.toString()
      })
        .then(r => r.json().then(result => ({ ok: r.ok, result: result })))
        .then(response => {
          if (!response.ok || !response.result.success) throw new Error(response.result.message || 'Unable to send reply.');
          this.reply = '';
          this.notice = 'Reply sent.';
          this.load();
          setTimeout(() => { this.notice = ''; }, 2500);
        })
        .catch(e => { this.error = e.message; })
        .finally(() => { this.sending = false; });
    },

    remove(id) {
      if (!id || this.deleting) return;
      this.deleteId = id;
      this.confirmOpen = true;
    },

    confirmDelete() {
      if (!this.deleteId || this.deleting) return;
      var id = this.deleteId;
      this.deleting = true;
      this.error = '';
      this.notice = '';

      fetch('<?= site_url('admin/delete/'); ?>' + encodeURIComponent(id), {
        method: 'GET',
        headers: { Accept: 'application/json' }
      })
        .then(r => r.json().then(result => ({ ok: r.ok, result: result })))
        .then(response => {
          if (!response.ok || !response.result.success) throw new Error(response.result.message || 'Unable to delete message.');
          this.messages = this.messages.filter(item => String(item.id) !== String(id));
          this.confirmOpen = false;
          this.deleteId = null;
          this.notice = 'Message deleted.';
          setTimeout(() => { this.notice = ''; }, 2000);
        })
        .catch(e => { this.error = e.message; })
        .finally(() => { this.deleting = false; });
    }
  };
}
</script>
