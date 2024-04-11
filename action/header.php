<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/eliyantosarage/font-awesome-pro@main/fontawesome-pro-6.5.1-web/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.3/css/buttons.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
</head>

<?php $url = '/' ?>

<body>

    <div id="loading-overlay">
        <span class="loader"></span>
    </div>

    <!-- nav start -->

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TLTC Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/index.php') ? 'active' : ''; ?>" aria-current="page" href="<?php echo htmlspecialchars($url); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/student.php') ? 'active' : ''; ?>" aria-current="page" href="<?php echo htmlspecialchars($url . 'student'); ?>">Student</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/batch.php') ? 'active' : ''; ?>" aria-current="page" href="<?php echo htmlspecialchars($url . 'batch'); ?>">Batch</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown link
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <form class="d-flex justify-content-end">
                <input type="text" class="form-control me-2" id="searchInput" placeholder="Type to search...">
                <button id="searchButton" class="btn btn-outline-success">Search</button>
            </form>
        </div>
    </nav>
    <!-- Nav End -->
</body>

</html>