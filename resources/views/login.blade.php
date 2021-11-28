<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Job Portal</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body class="antialiased">
        

                <div class="container-fluid py-3">
                  <header>
                    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                      <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                        <span class="fs-4">JOB PORTAL</span>
                      </a>

                      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">

                        <a class="me-3 py-2 text-dark text-decoration-none" href="/jobseeker/register">Job Seeker Sign up</a>

                        <a class="me-3 py-2 text-dark text-decoration-none" href="/recruiter/register">Recruiter Sign up</a>

                      </nav>
                    </div>

                  </header>
                  <div class="row">
                      <div class="col-md-4"></div>
                      <div class="col-md-4 card p-4 shadow mt-4 bg-body rounded">
                          <h4 class="text-center">Login</h4>
                          <form id="loginForm">
                              @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="d-grid gap-2 mt-5">
                                  <button class="btn btn-primary" type="submit">Login</button>
                                </div>
                            </form>
                      </div>
                      <div class="col-md-4"></div>
                  </div>
                  


                  <footer class="pt-4 my-md-5 pt-md-5 border-top">
                    <div class="row">
                      <div class="col-12 col-md">
                        <!-- <img class="mb-2" src="../assets/brand/bootstrap-logo.svg" alt="" width="24" height="19"> -->
                        <small class="d-block mb-3 text-muted">&copy; 2021–2022</small>
                      </div>
                    </div>
                  </footer>
                </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    </body>
</html>
