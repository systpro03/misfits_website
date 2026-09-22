    </main>
  </div>
</div>

<script>
  document.getElementById('mobile-admin-toggle')?.addEventListener('click', function () {
    var menu = document.getElementById('mobile-admin-menu');
    var expanded = this.getAttribute('aria-expanded') === 'true';
    this.setAttribute('aria-expanded', String(!expanded));
    menu.classList.toggle('hidden');
  });
</script>

<script src="<?php echo base_url('assets/js/datatable.js') ?>"></script>

<!-- Global DataTables Auto-Initialization Script -->
<script>
  $(document).ready(function () {
    // Apply default UI styling globally for all DataTables
    $.extend(true, $.fn.dataTable.defaults, {
      pageLength: 10,
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records...",
        lengthMenu: "Show _MENU_",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        paginate: {
          first: "«",
          previous: "‹",
          next: "›",
          last: "»"
        }
      }
    });

    // Initialize only tables that are not already controlled by a page-level
    // Alpine/search UI. Page-specific tables can opt out with data-datatable="false".
    $('.app-datatable').each(function () {
      if ($(this).attr('data-datatable') !== 'false' && !$.fn.dataTable.isDataTable(this)) {
        $(this).DataTable();
      }
    });
  });
</script>
</body>
</html>
