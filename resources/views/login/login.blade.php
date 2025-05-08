<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>Sign In</title>

    <link href="{{ asset('template2/static/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Selemat datang di GEO-System!</h1>
                            <p class="lead">
                                Silahkan mengisi form di bawah untuk Log-in
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form id="loginForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email"
                                                placeholder="Enter your email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Enter your password" required>
                                        </div>
                                        {{-- <div>
											<div class="form-check align-items-center">
												<input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
												<label class="form-check-label text-small" for="customControlInline">Remember me</label>
											</div>
										</div> --}}
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="text-center mb-3">
							Don't have an account? <a href="pages-sign-up.html">Sign up</a>
						</div> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('template2/static/js/app.js') }}"></script>
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            // Tampilkan loading SweetAlert
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: '{{ route('ajax.login') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (let key in errors) {
                            errorMessages += errors[key][0] + '\n';
                        }

                        Swal.fire({
                            icon: 'warning',
                            title: 'Validasi Gagal',
                            text: errorMessages
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
