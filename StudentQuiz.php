<?php	
	include "connect.php";
	session_start('user_credentials');
	// $subj = $_GET['subj'];
	$status = $_SESSION['POSITION'];
	$quizTitle = $_GET['quiz'];
?>
<html>
<head>
<link type = "text/css" rel = "stylesheet" href = "StudentQuiz.css">
<link type = "text/css" rel = "stylesheet" href = "homepage.css">
<title>Quiz Time!</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type = "text/javascript" src="Homepage.js"></script>
<script type = "text/javascript" src="jQuery.js"></script>
<!-- <script type = "text/javascript" src="slimscroll.js"></script> -->
<script type = "text/javascript" src="jquery.blockUI.js"></script>
<script type = "text/javascript">
//GET SUBJECT
var subject = <?php echo json_encode($_GET['subj']);?>;
var quizTitle = <?php echo json_encode($quizTitle);?>;
function ChangeProfileName(){
	// alert("LALALALALA");
	var pic = document.getElementById('profilepicture');
	pic.src = <?php echo json_encode($_SESSION['PROFILEPIC']); ?>;
	var profile = document.getElementById('profilename');
   	profile.value = <?php echo json_encode($_SESSION['REALNAME'])?>;

}
function Stud_Prof_Dropdowns(){
	var studDrop = document.getElementById('dropdowndivSTUDENT');
	var profDrop = document.getElementById('dropdowndivPROF');
	var status = <?php echo json_encode ($status); ?>;
	if (status == "Professor"){
		 if(profDrop.style.display == 'block'){
		          profDrop.style.display = 'none';
		      }else{
		          profDrop.style.display = 'block';
		      }
	}else if(status == "Student"){
		if(studDrop.style.display == 'block'){
		          studDrop.style.display = 'none';
		      }else{
		          studDrop.style.display = 'block';
		      }
	}
}
function LoadClassesForDropDown(){
	$(document).ready(function(){
		$.get( "checkclassesfordropdown.php", function(data) {
		  $( "#dropdowndivSTUDENT" ).html(data);
		});
	});
}

function LoadTitleAndNumberOfQuestions(){
	var title = document.getElementById('studentquiztitle');
	title.value = <?php echo json_encode($quizTitle)?>;
	var questions = document.getElementById('studentquestions');
	$.post("CountNumberofQuestions.php", {subj:subject, quiz:quizTitle}, function(data){
		$('#studentquestions').append(data);
	});
}


function LoadQuestion(){
	var questionsDropDown = document.getElementById('studentquestions');
	// var choice = questionsDropDown.getAttribute('value');
	// alert(questionsDropDown.value);
	$.post("Get_Quiz_Question.php", {num:questionsDropDown.value, subj:subject, title:quizTitle}, function(data){
		data = jQuery.parseJSON(data);
		// alert(data.question);
		$('#studentquestionnumber').html(questionsDropDown.value+".");
		$('#studentquestion').val(data.question);
		var counter = data.num_of_choices;
		// alert(counter); 
		for(i = 0; i < counter; i++){
			// var strin = '<input id = "radio" class = "radiobutt" type="radio" name="a" value="a" >
			// 						<textarea id = "studentanswerchoices" disabled>Ewan</textarea>';
			// $('#choicecontainer').append(strin);
		}
	});
}

</script>
</head>
<body onload="ChangeProfileName(); LoadClassesForDropDown(); LoadTitleAndNumberOfQuestions(); LoadQuestion()">
<div id="main">

<!-- HEADER -->
	<div id = "header" onclick="Hide()">
		<div id = "logo-mole"><a href = "Homepage.php">
			<img id = "logo" src = "_assets/Logo.png">
			<img id = "mole" src = "_assets/Mole.png">
		</a></div>
		<div id = "profilepic-div">
			<img id = "profilepicture" src="_assets/Profile-icon.jpg">
		</div>
		<input id = "class" type = "submit" value = "Classes" name = "classBtn" 
			onclick = "Stud_Prof_Dropdowns(); Hide(editclassdiv); Hide(creatediv); Hide(deleteclassdiv)">
		<input id = "profilename" type = "button"  name = "profilename" 
			onclick = "toggle_visibility('namedropdown'); Hide(notificationdiv)">
		<input id = "notification" type = "submit" value = "" name = "notificationBtn" 
			onclick = "toggle_visibility('notificationdiv'); Hide(namedropdown)">
	</div>

	<div id = "mainpage" onclick="Hide(notificationdiv); Hide(namedropdown);">

<!-- NOTIFICATIONSIDE -->
		<div id = "notificationdiv" class = "notificationdiv">
		</div>

<!-- NAMEDROPDOWN -->
		<div id = "namedropdown">
			<form action="userprofile.php">
				<input id = "viewprofile" class = "namedropdown" type = "submit" value = "View Profile">
			</form>
			<form action="index.php"> 
				<input id = "logout" class = "namedropdown" type = "submit" value = "Logout">
			</form>
		</div>

<!-- CLASS DROPDOWN -->
<!-- FOR PROFESSOR -->
		<div id = "dropdowndivPROF">
			<input id = "createclass" class = "dropdowncontent" type = "submit" value = "Create Class" name = "createclassBtn" 
				onclick = "toggle_visibility('creatediv'); Hide(editclassdiv); Hide(deleteclassdiv)">
			<input id = "editclass" class = "dropdowncontent" type = "submit" value = "Edit Class" 
				onclick = "toggle_visibility('editclassdiv'); Hide(creatediv); Hide(deleteclassdiv)">
			<input id = "deleteclass-dropdowncontent" class = "dropdowncontent" type = "submit" value = "Delete Class" 
				onclick = "toggle_visibility('deleteclassdiv'); Hide(creatediv); Hide(editclassdiv)">
		</div>
		<!-- EDIT CLASS SLIDESIDE DIV -->
		<div id = "editclassdiv">

			<!-- <div id = "editdropdowncards" class = "cards"> -->
				<!-- <label id = "editdropdowncardsclassname">Capstone</label>
				<input id = "editdropdowndeletebutton" type = "submit" value = "x"> -->
			<!-- </div> -->
		</div>
		<!-- DELETE CLASS SLIDESIDE DIC -->
		<div id = "deleteclassdiv">
			
		</div>

		<!-- CREATE CLASS SLIDESIDE DIV -->
		<div id = "creatediv">
			<form id = "create-class-form" method = "post" action = "CreateClasses.php">
                <input id = "classname" class = "form-textbox" type = "text" name = "classname" placeholder = "Classname"> 
        		<input id = "password" class = "form-textbox" type = "password" name = "password" placeholder = "Password">
        		<input id = "confirmationpassword" class = "form-textbox" type = "password" 
        		name = "confirmationpassword" placeholder = "Confirmation Password">
                <textarea id = "classdescription" name = "classdescription" placeholder = "Class Description"></textarea> 
                <input class = "create-cancel" type = "submit" value = "Create"> 
			</form>
			<input id = "cancel" class = "create-cancel" type = "submit" value = "Cancel" 
			onclick = "toggle_visibility('creatediv'); toggle_visibility('dropdowndiv')">
		</div>

<!-- FOR STUDENT -->
		<div id = "dropdowndivSTUDENT">
			<div id = "dropdowncards" class = "cards">
				<label id = "dropdowncardsclassname">Capstone</label>
				<input id = "dropdowndeletebutton" type = "submit" value = "x">
			</div>
		</div>

<!-- ENROLL DESCRIPTION -->
		<form id = "classviewdiv" style="display:none">
			<div id = "classviewtitle"></div>
			<div id = "classviewprofessor"></div>
			<textarea id = "classviewdescription" value = "classviewdescription" disabled readonly></textarea>
			<input id = "classviewpassword" name = "classpass" type = "password" placeholder = "Password">
			<input id = "enrollbutton" type="button" value = "Enroll" class = "Enroll" onclick="Enroll()">
			<input id = "messagebox" type="text" disabled>
		</form>

<!-- TAKE QUIZ -->
		<div id = "takequizpopupdiv">
			<div id = "studentquiz">
				<div id = "questiondiv">
					<input id = "studentquiztitle" type = "text" value = "">
					<select id = "studentquestions" placeholder = "Quiz Number" onchange="LoadQuestion()">
						<!-- <option value = "1">1</option> -->
					</select>
				</div>
				<div id = "studentquiestionandanswer">
					<label id = "studentquestionnumber">1.</label>
					<textarea id = "studentquestion" type = "text" disabled></textarea>
					<div id="choicecontainer">
						<!-- <input id = "radio" class = "radiobutt" type="radio" name="a" value="a" >
						<textarea id = "studentanswerchoices" disabled>Ewan</textarea> -->
					</div>
					<input id = "nextbutton" type = "submit" value = "Next">
				</div?
			</div>
		</div>

	</div>
</div>
</body>
</html>