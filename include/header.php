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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/css/datatable.css">
    <style>
        /* Styles for your loading overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Ensure the loading overlay appears on top */
        }

        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            border: 3px solid;
            border-color: blue blue transparent transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .loader::after,
        .loader::before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            border: 3px solid;
            border-color: transparent transparent #FF3D00 #FF3D00;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-sizing: border-box;
            animation: rotationBack 0.5s linear infinite;
            transform-origin: center center;
        }

        .loader::before {
            width: 32px;
            height: 32px;
            border-color: blue blue transparent transparent;
            animation: rotation 1.5s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes rotationBack {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(-360deg);
            }
        }

        /* Initially hide the content */
        body {
            overflow: hidden;
            /* Prevent scrolling while loading */
        }
    </style>
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
                    <div class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/class.php')? 'active' : ''?>" aria-current="page" href="<?php echo htmlspecialchars($url . 'class'); ?>">Class</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/member.php')? 'active' : ''?>" aria-current="page" href="<?php echo htmlspecialchars($url . 'member'); ?>">Member</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['PHP_SELF'] == '/server_admin.php')? 'active' : ''?>" aria-current="page" href="<?php echo htmlspecialchars($url . 'server_admin'); ?>">Server Access</a>
                    </div>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Setting</a></li>
                            <li><a class="dropdown-item" href="/session/logout.php">logout</a></li>
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

    <script src="/include/loader.js"></script>
</body>

</html>