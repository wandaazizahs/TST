<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>MyTicket | Birthday Treats</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | General UI Elements">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)-->
    <!-- Jika sebelumnya di /dist/assets/css/style.css -->
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <script src="dist/js/adminlte.js"></script>
     <!-- DataTables CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
 
</head> <!--end::Head--> <!--begin::Body-->


<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    
    <div class="app-wrapper"> <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
                </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
                
            </div> <!--end::Container-->
        </nav> <!--end::Header--> <!--begin::Sidebar-->
        
        <?php include 'bar/aside.php';?>

        <!--begin::App Main-->
        <main class="app-main">
            <br>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-6">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h3 class="mb-0">Pemesanan Tiket Birthday Treats</h3>
                                        <style>
                                            .custom-orange {
                                                background-color: var(--bs-orange);
                                            }
                                        </style>
                                    </div>
                                </div>
                                <?php
                                    include 'controllerindex.php';
                                ?>
                                <div class="card-body">
                                    <table id="example" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Transportasi</th>
                                                <th>Rute</th>
                                                <th>Tujuan</th>
                                                <th>Waktu Keberangkatan</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ticketData as $index => $tiket): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($tiket['transportasi']) ?></td>
                                                    <td><?= htmlspecialchars($tiket['start']) ?> - <?= htmlspecialchars($tiket['end']) ?></td>
                                                    <td><?= htmlspecialchars($tiket['tujuan']) ?></td>
                                                    <td><?= htmlspecialchars($tiket['jam']) ?></td>
                                                    <td>Rp <?= number_format($tiket['harga'], 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                    <div class="card-body">
                                        <h3>Pemesanan Tiket</h3>
                                        <form id="orderForm" method="post">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Masukan Nomor Induk Mahasiswa anda!</label>
                                                <input type="text" id="username" name="username" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ticket" class="form-label">Pilih Tiket</label>
                                                <select id="ticket" name="ticket" class="form-control" required>
                                                    <option value="">Pilih Tiket</option>
                                                    <!-- Data tiket akan dimuat dari database -->
                                                    <?php foreach ($ticketData as $tiket): ?>
                                                        <option value="<?= $tiket['id'] ?>"><?= $tiket['transportasi'] ?> - <?= $tiket['start'] ?> ke <?= $tiket['end'] ?> (Rp <?= number_format($tiket['harga'], 0, ',', '.') ?>)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Pesan Tiket</button>
                                        </form>

                                        <div id="orderResult" class="mt-3 alert d-none" role="alert"></div>
                                    </div>         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div id="modal"></div>
        <div id="modaledit"></div>

        <?php include 'bar/footer.php';?>

    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Datatables -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,  // Menambahkan dukungan responsif
                dom: 'Bfrtip',  // Menambahkan elemen tabel, button, dll
                buttons: [
                    'copy',    // Tombol untuk menyalin
                    'csv',     // Tombol untuk mengekspor ke CSV
                    'excel',   // Tombol untuk mengekspor ke Excel
                    'pdf',     // Tombol untuk mengekspor ke PDF
                    'print'    // Tombol untuk mencetak tabel
                ]
            });
        });
    </script>

</body><!--end::Body-->

    <!--modal input-->
    <script>
        function loadModalContent(url) {
            $('#modal').load(url, function() {
                $('#modal-default').modal('show');
            });
        }

        $(document).ready(function() {
            console.log("Listener terpasang!");
            $('.modal-trigger').click(function(e) {
                e.preventDefault();
                console.log("Tombol ditekan!");
                let url = $(this).attr('href');
                loadModalContent(url);
            });
        });
        $(document).ready(function() {
            console.log("Listener terpasang!");
            $('.modal-triggeredit').click(function(e) {
                e.preventDefault();
                console.log("Tombol ditekan!");
                let url = $(this).attr('href');
                loadModalContent(url);
            });
        });
    </script>
 
 <script>
$(document).ready(function() {
    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        var username = $('#username').val();
        var ticketId = $('#ticket').val();

        if (username && ticketId) {
            $.ajax({
                type: 'POST',
                url: 'check_username.php',  // Script untuk validasi username dan tiket
                data: { username: username, ticketId: ticketId },
                success: function(response) {
                    // Menampilkan hasil respons pada div
                    $('#orderResult').removeClass('d-none alert-danger alert-success'); // Reset class
                    if (response.toLowerCase().includes("diskon")) {
                        $('#orderResult').addClass('alert-success').html(response); // Jika diskon
                    } else if (response.toLowerCase().includes("tiket tidak ditemukan")) {
                        $('#orderResult').addClass('alert-danger').html(response); // Jika gagal
                    } else {
                        $('#orderResult').addClass('alert-info').html(response); // Default
                    }
                },
                error: function() {
                    $('#orderResult')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .html('Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
                }
            });
        } else {
            alert('Username dan tiket harus diisi!');
        }
    });
});

</script>
</html>