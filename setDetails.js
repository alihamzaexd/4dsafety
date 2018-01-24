/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$( document ).ready(function() {
    
$.post("ViewGetOrgDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#org_table').append('<tr><td>'+data[i].organization_name+'</td><td>'+data[i].organization_startdate+'</td><td>'+data[i].organization_enddate+'</td><td>'+data[i].organization_sector+'</td></td><td><button class="btn btn-danger" onclick="editOrg('+data[i].organization_id+')" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewOrg('+data[i].organization_id+')" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetLocDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#loc_table').append('<tr><td>'+data[i].location_name+'</td><td>'+data[i].location_startdate+'</td><td>'+data[i].location_enddate+'</td></td><td><button class="btn btn-danger" onclick="editLoc('+data[i].location_id+')" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewLoc('+data[i].location_id+')" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetDivisionDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#div_table').append('<tr><td>'+data[i].division_name+'</td><td>'+data[i].division_startdate+'</td><td>'+data[i].division_enddate+'</td></td><td><button class="btn btn-danger" onclick="editDiv('+data[i].division_id+')" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewDiv('+data[i].division_id+')" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetDeptDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#dept_table').append('<tr><td>'+data[i].department_name+'</td><td>'+data[i].department_startdate+'</td><td>'+data[i].department_enddate+'</td></td><td><button class="btn btn-danger" onclick="editDept('+data[i].department_id+')"  data-dismiss="modal" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewDept('+data[i].department_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetGradeDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#grade_table').append('<tr><td>'+data[i].grade_name+'</td><td>'+data[i].grade_startdate+'</td><td>'+data[i].grade_enddate+'</td></td><td><button class="btn btn-danger" onclick="editGrade('+data[i].grade_id+')"  data-dismiss="modal" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewGrade('+data[i].grade_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetJobDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#job_table').append('<tr><td>'+data[i].job_name+'</td><td>'+data[i].job_startdate+'</td><td>'+data[i].job_enddate+'</td></td><td><button class="btn btn-danger" onclick="editJob('+data[i].job_id+')"  data-dismiss="modal" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewJob('+data[i].job_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetPositionDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#position_table').append('<tr><td>'+data[i].position_name+'</td><td>'+data[i].position_startdate+'</td><td>'+data[i].position_enddate+'</td><td>'+data[i].job_name+'</td></td><td><button class="btn btn-danger" onclick="editPosition('+data[i].position_id+')"  data-dismiss="modal" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewPosition('+data[i].position_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetEmpDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#emp_table').append('<tr><td>'+data[i].person_title+'</td><td>'+data[i].person_firstname+'</td><td>'+data[i].person_middlename+'</td><td>'+data[i].person_lastname+'</td></td><td><button class="btn btn-danger" onclick="editEmployee('+data[i].person_id+')"  data-dismiss="modal" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewEmployee('+data[i].person_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("ViewGetPersonDetails.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#emp_table').append('<tr><td>'+data[i].person_title+'</td><td>'+data[i].person_firstname+'</td><td>'+data[i].person_middlename+'</td><td>'+data[i].person_lastname+'</td></td><td><button class="btn btn-danger" onclick="editEmp('+data[i].person_id+')"  data-dismiss="modal" type="button">Details</button></td><td><button class="btn btn-primary" onclick="viewEmp('+data[i].person_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("GetMatchedAddresses.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#matchedAddressTable').append('<tr><td>'+data[i].address_id+'</td><td>'+data[i].address_dscription+'</td><td>'+data[i].address_city+'</td></td><td><button class="btn btn-danger" onclick="editMatchedAddress('+data[i].address_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("GetMatchedAddresses.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#matchedAddressTable1').append('<tr><td>'+data[i].address_id+'</td><td>'+data[i].address_dscription+'</td><td>'+data[i].address_city+'</td></td><td><button class="btn btn-danger" onclick="viewMatchedAddress('+data[i].address_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("GetMatchedContacts.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#matchedContactTable').append('<tr><td>'+data[i].phone_id+'</td><td>'+data[i].phone_type+'</td><td>'+data[i].phone_subdesc+'</td><td>'+data[i].phone_number+'</td></td><td><button class="btn btn-danger" onclick="editMatchedContact('+data[i].phone_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("GetMatchedContacts.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#matchedContactTable1').append('<tr><td>'+data[i].phone_id+'</td><td>'+data[i].phone_type+'</td><td>'+data[i].phone_subdesc+'</td><td>'+data[i].phone_number+'</td></td><td><button class="btn btn-danger" onclick="viewMatchedContact('+data[i].phone_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("GetMatchedQualifications.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#matchedQualificationTable').append('<tr><td>'+data[i].qualification_id+'</td><td>'+data[i].qualification_typeid+'</td><td>'+data[i].qualification_name+'</td></td><td><button class="btn btn-danger" onclick="editMatchedQualification('+data[i].qualification_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});

$.post("GetMatchedQualifications.php",{}, function(x){

   var data = JSON.parse(x);
   for(var i=0; i<data.length;i++){

	$('#matchedQualificationTable1').append('<tr><td>'+data[i].qualification_id+'</td><td>'+data[i].qualification_typeid+'</td><td>'+data[i].qualification_name+'</td></td><td><button class="btn btn-danger" onclick="viewMatchedQualification('+data[i].qualification_id+')"  data-dismiss="modal" type="button">Details</button></td>'+'</tr>');
	
   }
});
    
});


function editOrg(x){
	//alert(x);
    $.post("postOrg.php",{id:x}, function(x){
       window.location.href = "editOrg.php";
    });
}

function viewOrg(x){
	//alert(x);
    $.post("postOrg.php",{id:x}, function(x){
       window.location.href = "viewOrg.php";
    });
}

function editLoc(x){
	//alert(x);
    $.post("postLoc.php",{id:x}, function(x){
       window.location.href = "editLoc.php";
    });
}

function viewLoc(x){
	//alert(x);
    $.post("postLoc.php",{id:x}, function(x){
       window.location.href = "viewLoc.php";
    });
}


function editDiv(x){
	//alert(x);
    $.post("postDiv.php",{id:x}, function(x){
       window.location.href = "editDiv.php";
    });
}

function viewDiv(x){
	//alert(x);
    $.post("postDiv.php",{id:x}, function(x){
       window.location.href = "viewDiv.php";
    });
}

function editDept(x){
	//alert(x);
    $.post("postDept.php",{id:x}, function(x){
       window.location.href = "editDept.php";
    });
}

function viewDept(x){
	//alert(x);
    $.post("postDept.php",{id:x}, function(x){
       window.location.href = "viewDept.php";
    });
}

function editGrade(x){
	//alert(x);
    $.post("postGrade.php",{id:x}, function(x){
       window.location.href = "editGrade.php";
    });
}

function viewGrade(x){
	//alert(x);
    $.post("postGrade.php",{id:x}, function(x){
       window.location.href = "viewGrade.php";
    });
}

function editJob(x){
	//alert(x);
    $.post("postJob.php",{id:x}, function(x){
       window.location.href = "editJob.php";
    });
}

function viewJob(x){
	//alert(x);
    $.post("postJob.php",{id:x}, function(x){
       window.location.href = "viewJob.php";
    });
}

function editPosition(x){
	//alert(x);
    $.post("postPosition.php",{id:x}, function(x){
       window.location.href = "editPosition.php";
    });
}

function viewPosition(x){
	//alert(x);
    $.post("postPosition.php",{id:x}, function(x){
       window.location.href = "viewPosition.php";
    });
}

function editEmployee(x){
	//alert(x);
    $.post("postEmployee.php",{id:x}, function(x){
       window.location.href = "editEmployees.php";
    });
}

function viewEmployee(x){
	//alert(x);
    $.post("postEmployee.php",{id:x}, function(x){
       window.location.href = "viewEmployees.php";
    });
}

function editMatchedAddress(x){
	//alert(x);
    $.post("postMatchedAddress.php",{id:x}, function(x){
       window.location.href = "editAddress.php";
    });
}

function viewMatchedAddress(x){
	//alert(x);
    $.post("postMatchedAddress.php",{id:x}, function(x){
       window.location.href = "viewAddress.php";
    });
}

function editMatchedContact(x){
	//alert(x);
    $.post("postMatchedContact.php",{id:x}, function(x){
       window.location.href = "editContact.php";
    });
}

function viewMatchedContact(x){
	//alert(x);
    $.post("postMatchedContact.php",{id:x}, function(x){
       window.location.href = "viewContact.php";
    });
}

function editMatchedQualification(x){
	//alert(x);
    $.post("postMatchedQualification.php",{id:x}, function(x){
       window.location.href = "editQualification.php";
    });
}

function viewMatchedQualification(x){
	//alert(x);
    $.post("postMatchedQualification.php",{id:x}, function(x){
       window.location.href = "viewQualification.php";
    });
}
