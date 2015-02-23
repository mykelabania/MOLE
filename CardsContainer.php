<?php	
	include "connect.php";
	session_start('user_credentials');

	$subj = $_GET['subj'];
	$author = '';
	$queryAuthor = "SELECT `Created_By` FROM classes WHERE '$subj' = Classes";
	$resultAuthor = mysqli_query($conn,$queryAuthor)
			or die("");
	$rowAuthor = mysqli_fetch_array($resultAuthor);
	$serverAuthor = $rowAuthor["Created_By"];
?>
<html>
<head>
<link type = "text/css" rel = "stylesheet" href = "CardsContainer.css">
<title><?php echo ($_GET['subj'] ); echo " Home"; ?> </title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type = "text/javascript" src="Homepage.js"></script>
<script type = "text/javascript" src="jQuery.js"></script>
<script type = "text/javascript" src="slimscroll.js"></script>
<script type = "text/javascript">
window.onload = function(){
	var element = document.getElementsByClassName('cardcontainer');
	var e = Array.prototype.slice.call(element);
	// alert (e[0]);
	scroll.useSlimScroll(e[0]);
}
function GoToQuiz(){
	// alert("LALALALALALA");
	$(document).ready(function(){
		var subj = <?php echo json_encode($_GET['subj']); ?>;
		window.location.href = "CreateQuiz.php?subj=" + subj;
		// $.get("CreateQuiz.php",function(){

		// });
	});
}
function LoadLists(){
	var getSubj = <?php echo json_encode($_GET['subj']); ?>;
	var className = document.getElementById('classname');
		$.post( "LoadLists.php", {subj:getSubj}, function(list) {
		  $( "#lists-container").html(list);
		});
	// });
}
function ChangeProfileName(){
	// alert (<?php echo json_encode($_SESSION['PROFILEPIC']); ?>);
	var pic = document.getElementById('profilepicture');
	pic.src = <?php echo json_encode($_SESSION['PROFILEPIC']); ?>;
	var profile = document.getElementById('profilename');
   	profile.value = <?php echo json_encode($_SESSION['REALNAME']); ?>;
}
function ChangeClassName(){
	var className = document.getElementById('classname');
	className.value = <?php echo json_encode($_GET['subj']); ?>;
}
function AddList(){
	var className = document.getElementById('classname');
	var listName = $("input[name='listName']").val();
	$.post("addlist_class.php?subj=" + className.value, {listLabel:listName}, function(list){
		$("#lists-container").html(list);
	});
}
function CheckAuthor(){
	var addListTextBox = document.getElementById('add-lists-container')
	var author = <?php echo json_encode($serverAuthor); ?>;
	var currentUser = <?php echo json_encode($_SESSION['REALNAME']); ?>;
	if (author == currentUser){
		addListTextBox.style.display = 'block';
	}else{
		addListTextBox.style.display = 'none';
	}

}

function AddCard(listname){
	var className = document.getElementById('classname');
	var cardtitle = $("input[name='"+listname+"']").val();
	$(document).ready(function(){
		$.post("addcards_class.php?subj=" + className.value +"&list=" + listname, {cardName:cardtitle}, function(card){
			$("#notificationdiv").html(card);
		});
	});
	
}


function LoadCards(){
	var getSubj = <?php echo json_encode($_GET['subj']); ?>;
	$(document).ready(function(){
		$.post( "LoadCards.php", {subj:getSubj}, function(cards) {
		  $( "#notificationdiv").html(cards);
		  ChangeCardPosition();
		  // alert (getCards);
		});
	});
}

function ChangeCardPosition(){
	var getCards = document.getElementsByClassName('card');
	var cards = Array.prototype.slice.call(getCards);
	// alert (cards[1].id);
	$(document).ready(function(){
		for (i = 0; i < cards.length; i++) {
		var theCard = document.getElementById(cards[i].id);
		$("#cardcontainer_"+cards[i].id).append(theCard);
		// alert(theCard.id);
		}	
	});
}
</script>

</head>
<body onload = "ChangeProfileName(); ChangeClassName(); LoadLists(); CheckAuthor();LoadCards(); ">
<!-- HEADER -->
	<div id = "header" onclick="Hide()">
		<div id = "logo-mole">
			<img id = "logo" src = "_assets/Logo.png">
			<img id = "mole" src = "_assets/Mole.png">
		</div>
		<div id = "profilepic-div">
			<img id = "profilepicture" src="_assets/ProfilePicture.png">
		</div>
		<input id = "class" type = "submit" value = "Classes" name = "classBtn" onclick = "toggle_visibility('dropdowndiv')">
		<input id = "profilename" type = "button"  name = "profilename" onclick = "toggle_visibility('namedropdown')">
		<input id = "notification" type = "submit" value = "" name = "notificationBtn" onclick = "toggle_visibility('notificationdiv')">
	</div>

	<div id = "mainpage">
<!-- NOTIFICATIONSIDE -->
		<div id = "notificationdiv" class = "notificationdiv">
		</div>

<!-- NAMEDROPDOWN -->
		<div id = "namedropdown">
			<input id = "viewprofile" class = "namedropdown" type = "submit" value = "View Profile">
			<form action="index.html"> 
				<input id = "logout" class = "namedropdown" type = "submit" value = "Logout">
			</form>
		</div>
		
<!-- CARDSCONTAINER -->
		<input id = "classname" type="text" value="" readonly>
			<div id="lists-container">
				<!-- <div id = "cards-container-div">
					<input id = "containertitle" type = "text" name = "containertitle" placeholder = "Container Title">
					<input id = "cardtitle" type = "textbox" placeholder = "Card Title">
						<div id = "buttondiv">
							<input id = "addcard" class = "addbutton" type = "submit" value = "Add">
						</div>
					<div id = "card">
					</div>
				</div> -->
			</div>

		<div id = "add-lists-container">
				<input id = "addcontainer" type = "textbox" placeholder = "Add List" name = "listName">
				<input id = "addbuttoncontainer" class = "addbutton" type = "submit" value = "Add" onclick="AddList()">
		</div>

		<div id="hiddencontainer"></div>

</body>
</html>