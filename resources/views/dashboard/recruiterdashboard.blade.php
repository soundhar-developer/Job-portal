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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body class="antialiased">
        

                <div class="container-fluid py-3">
                  <header>
                    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                      <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                        <span class="fs-4">JOB PORTAL</span>
                      </a>

                      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">

                        <a class="me-3 py-2 text-dark text-decoration-none" href="/logout">Logout</a>

                      </nav>
                    </div>
                </header>
                 ;
                
                <div class="container mt-3">
                  <h2>Recruiter Panel</h2>
                  <br>
                  <!-- Nav pills -->
                  <ul class="nav nav-pills col-md-12" role="tablist">
                    <li class="nav-item col-md-4">
                      <a class="nav-link active text-center" data-bs-toggle="pill" id="jobTab" href="#jobPostTab" onclick="getJob()">Job Post</a>
                    </li>
                    <li class="nav-item col-md-4">
  
                      <a class="nav-link text-center" data-bs-toggle="pill" href="#findCandidateTab" onclick="getAllCandidate();">Find Candidates</a>
                    </li>
                    <li class="nav-item col-md-4">
  
                      <a class="nav-link text-center" data-bs-toggle="pill" href="#appliedJobTab" onclick="getAllAppliedJob()">Applied Jobs</a>
                    </li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div id="jobPostTab" class="container tab-pane active">
                      <div class="p-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addJobModal">Add Job</button>
                      </div>
                      <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Job Title</th>
                              <th>Experience</th>
                              <th>Job Description</th>
                              <th>Skills Required</th>
                              <th>Status</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody id="allJobs">
                            
                          </tbody>
                        </table>
                    </div>
                    <div id="findCandidateTab" class="container tab-pane fade"><br> 
                      <h4 class="p-3">Filter Candidates</h4>
                      <form id="filterCandidateForm">
                        @csrf
                      <div class="row">
                        <div class="col-md-2 mb-3">
                            <input type="text" class="form-control" id="skills" name="skills" placeholder="Skills(Ex:php)"> 
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="text" class="form-control" id="notice_period" name="notice_period" placeholder="Notice period"> 
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="text" class="form-control" id="min_experience" name="min_experience" placeholder="Min Experience"> 
                        </div>
                        <div class="col-md-2 mb-3">
                            <input type="text" class="form-control" id="max_experience" name="max_experience" placeholder="Max Experience"> 
                        </div>
                        <div class="col-md-2 mb-3">
                            <select id="candidate_location" name="location" class="form-select">
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">      
                            <button type="submit" class="btn btn-outline-secondary" id="filterCandidates">Search</button>
                        </div>
                      </div>
                    </form>

                    <table class="table table-striped mt-5">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Experience</th>
                          <th>Notice Period</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody id="allCandidates">
                      </tbody>
                    </table>

                    </div>
                    <div id="appliedJobTab" class="container tab-pane fade"><br>
                      <table class="table table-striped mt-5">
                          <thead>
                            <tr>
                              <th>Candidate Name</th>
                              <th>Job Title</th>
                              <th>Phone</th>
                              <th>Experience</th>
                            </tr>
                          </thead>
                          <tbody id="allAppliedJob">
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            
                <!-- Modal -->
              <div class="modal fade" id="addJobModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Job</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form id="addJobForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Job Title</label>
                                    <input type="text" class="form-control" id="job_title" name="job_title" aria-describedby="emailHelp"> 
                                </div>
                              </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Experience( in years )</label>
                                    <input type="number" class="form-control" min="0" id="experience" name="experience">
                                </div>
                            </div>
                          <div class="row">
                            <div class="mb-3">
                                <label for="skills" class="form-label">Job Description</label>
                                <textarea class="form-control" id="job_description" name="job_description" rows="3"></textarea>
                            </div>
                          </div>
                          <div class="row">
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills Required</label>
                                <select id="skills_required" name="skills_required" class="form-select">
                                  <option disabled selected>Select</option>
                                  <option value="php">Php</option>
                                  <option value="css">Css</option>
                                  <option value="html">Html</option>
                                  <option value="java">Java</option>
                                  <option value="bootstrap">Bootstrap</option>
                                </select>
                            </div>
                          </div>
                          <div class="row">
                              <div class="mb-3">
                                  <label for="location" class="form-label">Location</label>
                                  <select id="job_location" name="location" class="form-select">
                                </select>
                              </div>
                          </div>
                          <div class="row">
                              <div class="mb-3">
                                  <label for="email" class="form-label">Status</label>
                                  <select id="status" name="status" class="form-select">
                                    <option selected disabled>Select</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                              </div>
                            </div>
                              
                        </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-success">Create</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>


                <div class="modal fade" id="editJobModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Job</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form id="editJobForm">
                        @csrf
                        <div class="modal-body">
                          <input type="hidden" id="editId" name="id">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Job Title</label>
                                    <input type="text" class="form-control" id="editjob_title" name="job_title" aria-describedby="emailHelp"> 
                                </div>
                              </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Experience( in years )</label>
                                    <input type="number" class="form-control" min="0" id="editexperience" name="experience">
                                </div>
                            </div>
                          <div class="row">
                            <div class="mb-3">
                                <label for="skills" class="form-label">Job Description</label>
                                <textarea class="form-control" id="editjob_description" name="job_description" rows="3"></textarea>
                            </div>
                          </div>
                          <div class="row">
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills Required</label>
                                <select id="editskills_required" name="skills_required" class="form-select">
                                  <option disabled selected>Select</option>
                                  <option value="php">Php</option>
                                  <option value="css">Css</option>
                                  <option value="html">Html</option>
                                  <option value="java">Java</option>
                                  <option value="bootstrap">Bootstrap</option>
                                </select>
                            </div>
                          </div>
                          <div class="row">
                              <div class="mb-3">
                                  <label for="email" class="form-label">Status</label>
                                  <select id="editstatus" name="status" class="form-select">
                                    <option selected disabled>Select</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                              </div>
                            </div>
                              
                        </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-success">Edit</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>


                <div class="modal fade" id="deleteJobModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Job</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form id="deleteJobForm">
                        @csrf
                        <input type="hidden" id="deleteJobId" name="id">
                      <div class="modal-body">
                        <h5>You want to delete this job?</h5>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="deleteJobBtn" class="btn btn-outline-danger">Delete</button>
                      </div>
                    </form>
                    </div>
                  </div>
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
            <script src="/js/main.js"></script>
    </body>
</html>

