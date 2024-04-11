<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-rk7lJzePdTu6rP/qqLWNW0j33+yO5GCg3/JXxkmsNjQgrRnHS2m+XnvKhrtfD6dG" crossorigin="anonymous"></script> -->
<!-- Link To Datatable -->
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.3/js/jquery.dataTables.js"></script> -->
<!-- JavaScript for Printing and XLSX Exporting -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script> -->

<script>
    $(document).ready(function() {
        var dataTable = $('#sortTable').DataTable({
            "lengthMenu": [
                [5, 10, 25, 50, 60, -1],
                [5, 10, 25, 50, 60, "All"]
            ], // Customizing per page margin
            "paging": true, // Enable pagination
            "searching": true, // Disable search functionality
            "ordering": true, // Enable sorting
            "info": false, // Show information summary
            "scrollX": false, // Horizontal scrolling
            "scrollY": "300px", // Vertical scrolling
            "scrollCollapse": true, // Collapse table when smaller than scrollY
            // Add custom styling
            "columnDefs": [{
                    "className": "dt-center",
                    "targets": "_all"
                } // Center align all columns
            ],
            // Define custom sorting options
            "order": [
                [1, 'asc']
            ], // Sort by the second column in ascending order by default
            // Define custom language options
            "language": {
                "lengthMenu": "Display _MENU_ per page",
                "zeroRecords": "Nothing found Your Search Data",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)",

            }
        });

        // Search button click event
        $('#searchButton').on('click', function() {
            var searchTerm = $('#searchInput').val();
            dataTable.search(searchTerm).draw();
        });

        // Optionally, you can trigger search on Enter key press
        $('#searchInput').on('keypress', function(e) {
            if (e.which == 13) { // Enter key
                var searchTerm = $(this).val();
                dataTable.search(searchTerm).draw();
                return false; // Prevent form submission
            }
        });
    });
</script>
