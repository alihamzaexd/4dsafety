<?php
echo "<script> alert('scripts working');</script>";
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>


<script>
var objJson;

	$.post("testFile.php",{getResponse:1}, function(x){
			if(x){                                                          // x contains response of the function
			objJson = JSON.parse(x);
			changePage(1);
			}
			else{
				alert("No response");
			}
		}); 

var current_page = 1;
var records_per_page = 2;

function prevPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
}

function nextPage()
{
    if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    }
}
    
function changePage(page)
{
    var btn_next = document.getElementById("btn_next");
    var btn_prev = document.getElementById("btn_prev");
    var listing_table = document.getElementById("listingTable");
    var page_span = document.getElementById("page");
 
    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();

    listing_table.innerHTML = "";

    for (var i = (page-1) * records_per_page; i < (page * records_per_page) && i < objJson.length; i++) {
        listing_table.innerHTML += objJson[i]['user']+ "<br>";
    }
    page_span.innerHTML = page + "/" + numPages();

    if (page == 1) {
        btn_prev.style.visibility = "hidden";
    } else {
        btn_prev.style.visibility = "visible";
    }

    if (page == numPages()) {
        btn_next.style.visibility = "hidden";
    } else {
        btn_next.style.visibility = "visible";
    }
}

function numPages()
{
    return Math.ceil(objJson.length / records_per_page);
}
				
				
</script>
<table border="1">
<thead>
<tr><th>id</th><th>user firstname</th><th>user lastname</th><tr>
</thead>
<tbody id ="listingTable">

</tbody>
</table>
</div>
<a href="javascript:prevPage()" id="btn_prev">Prev</a>
<a href="javascript:nextPage()" id="btn_next">Next</a>
page: <span id="page"></span>
