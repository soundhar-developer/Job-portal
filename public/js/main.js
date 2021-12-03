$(document).ready(function() {
	getLocation();
	getActiveJob();
	$('#jobTab').trigger('click');
})


function getLocation() {
	$.ajax({
		url     : '/getJobLocation',
        type    : 'get',
		dataType : 'json',
		success:function(response) {
			$('#location').html('');
			$('#location').append('<option selected disabled>Select Location</option>');
			for (var i = 0; i < response.data.length; i++) {
				$('#location').append('<option value="'+ response.data[i].city_name +'">'+ response.data[i].city_name +'</option'
					);
			}

			$('#job_location').html('');
			$('#job_location').append('<option selected disabled>Select Location</option>');
			for (var i = 0; i < response.data.length; i++) {
				$('#job_location').append('<option value="'+ response.data[i].city_name +'">'+ response.data[i].city_name +'</option'
					);
			}

			$('#candidate_location').html('');
			$('#candidate_location').append('<option selected disabled>Select Location</option>');
			for (var i = 0; i < response.data.length; i++) {
				$('#candidate_location').append('<option value="'+ response.data[i].city_name +'">'+ response.data[i].city_name +'</option'
					);
			}

			$('#seeker_location').html('');
			$('#seeker_location').append('<option selected disabled>Select Location</option>');
			for (var i = 0; i < response.data.length; i++) {
				$('#seeker_location').append('<option value="'+ response.data[i].city_name +'">'+ response.data[i].city_name +'</option'
					);
			}
		}
	})
}



$('#addJobForm').submit(function() {
	$.ajax({
		url     : '/addJob',
        type    : 'post',
        data    :  $(this).serialize(),
		dataType : 'json',
		success:function(response) {
			if(response.data.success == true) {
				alert(response.data.message);
				$('#addJobModal').modal('hide');
				getJob();
			} else {
				alert(response.data.message);
			}
		},
		error:function(response) {
			alert("Something went wrong!");
		}
	})
	return false;
})


$('#editJobForm').submit(function() {
	$.ajax({
		url     : '/editJob',
        type    : 'post',
        data    :  $(this).serialize(),
		dataType : 'json',
		success:function(response) {
			if(response.data.success == true) {
				alert(response.data.message);
				$('#editJobModal').modal('hide');
				getJob();
			} else {
				alert(response.data.message);
			}
		},
		error:function(response) {
			alert("Something went wrong!");
		}
	})
	return false;
})


function getJob() {
	$.ajax({
		url     : '/getAllJob',
        type    : 'get',
		dataType : 'json',
		success:function(response) {
			$('#allJobs').html('');
			if(response.data.length > 0) {
				for (var i = 0; i < response.data.length; i++) {
					$('#allJobs').append('<tr id="row'+ i +'"><td>'+ response.data[i].job_title +'</td><td>'+ response.data[i].experience  +'</td><td>'+ response.data[i].job_description +'</td><td>'+ response.data[i].skills_required +'</td><td>'+ response.data[i].status +'</td><td><i class="fa fa-pencil-square-o mr-3" onclick="fetchJob('+ response.data[i].id +')" style="font-size:30px;color:orange;"></i></td><td><i class="fa fa-trash-o mr-3" onclick="showDeleteModal('+ response.data[i].id +')" style="font-size:30px;color:red;"></i></td></tr>'
						);
				}
			} else {
				$('#allJobs').append('<tr><td colspan="2"></td><td>No Data Available!</td><td colspan="2"></td></tr>');
			}
		}
	})
}


function getActiveJob() {
	$.ajax({
		url     : '/getActiveJob',
        type    : 'get',
		dataType : 'json',
		success:function(response) {
			$('#allActiveJobs').html('');
			if(response.data.length > 0) {
				for (var i = 0; i < response.data.length; i++) {
					if(response.data[i].apply_status == "Applied") {
						$('#allActiveJobs').append('<tr id="row'+ i +'"><td>'+ response.data[i].recruiter.company_name +'</td><td>'+ response.data[i].job_title +'</td><td>'+ response.data[i].experience  +'</td><td><span class="text-success">'+response.data[i].apply_status+'</span></td></tr>'
						);
					} else {
						$('#allActiveJobs').append('<tr id="row'+ i +'"><td>'+ response.data[i].recruiter.company_name +'</td><td>'+ response.data[i].job_title +'</td><td>'+ response.data[i].experience  +'</td><td><button type="button" onclick="applyJob('+ response.data[i].id +', '+ response.data[i].recruiter_id +')"  class="btn btn-outline-primary">Apply</button></td></tr>'
						);
					}
				}
			} else {
				$('#allActiveJobs').append('<tr><td colspan="2"></td><td>No Data Available!</td><td colspan="2"></td></tr>');
			}
		}
	})
}


function showDeleteModal(jobId) {
	$('#deleteJobModal').modal('show');
	$('#deleteJobId').val(jobId);
}


$('#deleteJobForm').submit(function() {
	$.ajax({
		url     : '/deleteJob',
        type    : 'delete',
        data    :  $(this).serialize(),
		dataType : 'json',
		success:function(response) {
			if(response.data.success == true) {
				alert(response.data.message);
				$('#deleteJobModal').modal('hide');
				getJob();
			} else {
				alert(response.data.message);
			}
		},
		error:function(response) {
			alert("Something went wrong!");
		}
	})
	return false;
})

function fetchJob(jobId) {
	$('#editJobModal').modal('show');
	$.ajax({
		url     : '/fetchJob/' + jobId,
        type    : 'get',
		dataType : 'json',
		success:function(response) {
			$('#editId').val(response.data.id);
			$('#editjob_title').val(response.data.job_title);
			$('#editexperience').val(response.data.experience);
			$('#editjob_description').val(response.data.job_description);
			$('#editskills_required').val(response.data.skills_required).change();
			$('#editstatus').val(response.data.status).change();
		},
		error:function(response) {
			alert("Something went wrong!");
		}
	})
}


$('#searchActiveJobForm').submit(function() {
		$.ajax({
			url     : '/searchActiveJob',
	        type    : 'post',
	        data    :  $(this).serialize(),
			dataType : 'json',
			success:function(response) {
				$('#allActiveJobs').html('');
				if(response.data.length > 0) {
					for (var i = 0; i < response.data.length; i++) {
						if(response.data[i].apply_status == "Applied") {
							$('#allActiveJobs').append('<tr id="row'+ i +'"><td>'+ response.data[i].recruiter.company_name +'</td><td>'+ response.data[i].job_title +'</td><td>'+ response.data[i].experience  +'</td><td><span class="text-success">'+response.data[i].apply_status+'</span></td></tr>'
							);
						} else {
							$('#allActiveJobs').append('<tr id="row'+ i +'"><td>'+ response.data[i].recruiter.company_name +'</td><td>'+ response.data[i].job_title +'</td><td>'+ response.data[i].experience  +'</td><td><button type="button" onclick="applyJob('+ response.data[i].id +', '+ response.data[i].recruiter_id +')" class="btn btn-outline-primary">Apply</button></td></tr>'
							);
						}
					}
				} else {
					$('#allActiveJobs').append('<tr><td colspan="2"></td><td>No Data Available!</td><td colspan="2"></td></tr>');
				}
			},
			error:function(response) {
				alert(response.data.message);
			}
		})
	return false;
})


function applyJob(jobId, recruiterId) {
	$.ajax({
		url     : '/applyJob/' + jobId + '/' + recruiterId,
        type    : 'get',
		dataType : 'json',
		success:function(response) {
			if(response.data.success == true) {
				alert(response.data.message);
				window.location.reload();
			} else {
				alert(response.data.message);
			}
		},
		error:function(response) {
			alert("Something went wrong!");
		}
	})
}


$('#filterCandidateForm').submit(function() {
		$.ajax({
			url     : '/filterCandidate',
	        type    : 'post',
	        data    :  $(this).serialize(),
			dataType : 'json',
			success:function(response) {
				$('#allCandidates').html('');
				if(response.data.length > 0) {
					for (var i = 0; i < response.data.length; i++) {
						$('#allCandidates').append('<tr id="row'+ i +'"><td>'+ response.data[i].name +'</td><td>'+ response.data[i].email +'</td><td>'+ response.data[i].phone  +'</td><td>'+ response.data[i].experience +'</td><td>'+ response.data[i].notice_period +'</td><td>'+ response.data[i].location +'</td></tr>'
							);
					}
				} else {
					$('#allCandidates').append('<tr><td colspan="2"></td><td>No Data Available!</td><td colspan="2"></td></tr>');
				}
			},
			error:function(response) {
				alert(response.data.message);
			}
		})
	return false;
})


function getAllCandidate() {
	$.ajax({
		url     : '/getAllCandidate',
        type    : 'get',
		dataType : 'json',
		success:function(response) {
			$('#allCandidates').html('');
			if(response.data.length > 0) {
				for (var i = 0; i < response.data.length; i++) {
					$('#allCandidates').append('<tr id="row'+ i +'"><td>'+ response.data[i].name +'</td><td>'+ response.data[i].email +'</td><td>'+ response.data[i].phone  +'</td><td>'+ response.data[i].experience +'</td><td>'+ response.data[i].notice_period +'</td><td>'+ response.data[i].location +'</td></tr>'
						);
				}
			} else {
				$('#allCandidates').append('<tr><td colspan="2"></td><td>No Data Available!</td><td colspan="2"></td></tr>');
			}
		}
	})
}


function getAllAppliedJob() {
	$.ajax({
		url     : '/getAllAppliedJob',
        type    : 'get',
		dataType : 'json',
		success:function(response) {
			$('#allAppliedJob').html('');
			if(response.data.length > 0) {
				for (var i = 0; i < response.data.length; i++) {
					var imageUrl = "/storage/photos/"+ response.data[i].photo;
					var resumeUrl = "/storage/photos/"+ response.data[i].resume;
					$('#allAppliedJob').append('<tr id="row'+ i +'"><td>'+ response.data[i].canditate_name +'</td><td>'+ response.data[i].job_title +'</td><td>'+ response.data[i].phone  +'</td><td>'+ response.data[i].experience +'</td><td style="width: 40%;"><img src="'+ imageUrl +'" style="width: 30%;" alt="" title="" /></td><td><a href="'+ resumeUrl +'" download>Download Resume</a></td></tr>'
						);
				}
			} else {
				$('#allAppliedJob').append('<tr><td colspan="2"></td><td>No Data Available!</td><td colspan="2"></td></tr>');
			}
		}
	})
}




