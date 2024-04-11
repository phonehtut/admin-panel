<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
</head>
<body>
    <table id="myTable">
        <thead>
            <tr>
                <td>name</td>
                <td>email</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>test</td>
                <td>resr@gmail.com</td>
            </tr>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

    <script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>

</body>
</html>