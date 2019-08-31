
//OPEN SIDEBAR
function openNav() {
	document.getElementById("mySidebar").style.width = "35%";
	document.getElementById("main").style.marginLeft = "35%";
	document.getElementById("inner_mySidebar").style.display = "inline";
}

//CLOSE SIDEBAR
function closeNav() {
	main_menu();
	document.getElementById("inner_mySidebar").style.display = "none";
	document.getElementById("mySidebar").style.width = "0";
	document.getElementById("main").style.marginLeft = "0";
}

//ADD_CENTER FUNCTION
function add_center() {
	document.getElementById("inner_mySidebar").style.display = "none";
	document.getElementById("myForm").style.display = "inline";
	document.getElementById("mySidebar").style.width = "40%";
	document.getElementById("main").style.marginLeft = "40%";
}

//VIEW_CENTERS FUNCTION
function view_centers() {
	document.getElementById("inner_mySidebar").style.display = "none";
	document.getElementById("display_centers").style.display = "inline";
	document.getElementById("mySidebar").style.width = "50%";
	document.getElementById("main").style.marginLeft = "50%";
}

//BACK TO MAIN_MENU
function main_menu() {
	document.getElementById("inner_mySidebar").style.display = "inline";
	document.getElementById("myForm").style.display = "none";
	document.getElementById("display_centers").style.display = "none";
	document.getElementById("mySidebar").style.width = "35%";
	document.getElementById("main").style.marginLeft = "35%";
}
