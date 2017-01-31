	<!DOCTYPE HTML>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>Moonslider</title>
			<link rel="stylesheet" type="text/css" href="css/styles.css">
		</head>
		<body>
			<script>
				var progHolder = []; //Holds class of each program.

				function Programme(id, name, image, mood1, mood2, mood3, mood4) { //programme class function. Each programme has 4 moods that are listed in order of importance.
					this.id = id;
					this.name = name;
					this.image = image;
					this.mood1 = mood1;
					this.mood2 = mood2;
					this.mood3 = mood3;
					this.mood4 = mood4;
				}

				function Mood(mood, value) { //mood class function
				  this.mood = mood;
				  this.value = value;
				}

				function sliderMoved(sid){ //Called by slider movement. Takes slider values and calls function to update the GUI.
					var slid1=document.getElementById("slider1").value;
					var slid2=document.getElementById("slider2").value;
					var slid3=document.getElementById("slider3").value;
					var slid4=document.getElementById("slider4").value;
					updateGUI(slid1,slid2,slid3,slid4);
				}
				function updateGUI(slid1,slid2,slid3,slid4){ //Works out the input moods based on the slider values and organises them in order of severity.
					//mood classes for each mood declared and given default value of 0;
					var calm = new Mood("Calm", 0);
					var agitated = new Mood("Agitated", 0);
					var sad = new Mood("Sad", 0);
					var happy = new Mood("Happy", 0);
					var wideAwake = new Mood("Wide Awake", 0);
					var tired = new Mood("Tired", 0);
					var fearless = new Mood("Fearless", 0);
					var scared = new Mood("Scared", 0);
					var moodArray = [calm, agitated, sad, happy, wideAwake, tired, fearless, scared];

					//If statements used to get value for each mood. Moods with negative values on the sliders have their slider value made positive to compare them.
					if(slid1 > 0){
						moodArray[0].value = slid1;
					}else if(slid1 < 0){
						moodArray[1].value = slid1*= -1;
					}

					if(slid2 > 0){
						moodArray[2].value = slid2;
					}else if(slid2 < 0){
						moodArray[3].value = slid2*= -1;
					}

					if(slid3 > 0){
						moodArray[4].value = slid3;
					}else if(slid3 < 0){
						moodArray[5].value = slid3*= -1;
					}

					if(slid4 > 0){
						moodArray[6].value = slid4;
					}else if(slid4 < 0){
						moodArray[7].value = slid4*= -1;
					}

					//Below finds the user selected moods and puts them in variables dependant on their value.
					var highest = new Mood("", 0);
					var holder1;
					for(i = 0; i < moodArray.length; i++){
						holder1 = moodArray[i];
						if(highest.value < holder1.value){
							highest.mood = holder1.mood;
							highest.value = holder1.value;
						}
					}

					var secondHighest = new Mood("", 0);
					var holder2;
					for(i = 0; i < moodArray.length; i++){
						holder2 = moodArray[i];
						if(secondHighest.value < holder2.value && holder2.mood !== highest.mood){
							secondHighest.mood = holder2.mood;
							secondHighest.value = holder2.value;
						}
					}

					var thirdHighest = new Mood("", 0);
					var holder3;
					for(i = 0; i < moodArray.length; i++){
						holder3 = moodArray[i];
						if(thirdHighest.value < holder3.value && holder3.mood !== highest.mood
						&& holder3.mood !== secondHighest.mood){
							thirdHighest.mood = holder3.mood;
							thirdHighest.value = holder3.value;
						}
					}

					var fourthHighest = new Mood("", 0);
					var holder4;
					for(i = 0; i < moodArray.length; i++){
						holder4 = moodArray[i];
						if(fourthHighest.value < holder4.value && holder4.mood !== highest.mood
						&& holder4.mood !== secondHighest.mood && holder4.mood !== thirdHighest.mood){
							fourthHighest.mood = holder4.mood;
							fourthHighest.value = holder4.value;
						}
					}
					fetchProgrammes(highest.mood, secondHighest.mood, thirdHighest.mood, fourthHighest.mood);
				}

				function showProgrammes(programmes){
					//Takes an array of programmes to display. If an element in the array is empty then it implies there is no
					//recommended program to go in that slot and the placeholder img is displayed instead.
					if(programmes[0]){
						document.getElementById("prog1").src = programmes[0].image;
						document.getElementById("progTitle1").innerHTML = programmes[0].name;
					}else{
						document.getElementById("prog1").src = "img/none.png";
						document.getElementById("progTitle1").innerHTML = "None left";
							}
					if(programmes[1]){
						document.getElementById("prog2").src = programmes[1].image;
						document.getElementById("progTitle2").innerHTML = programmes[1].name;
					}else{
						document.getElementById("prog2").src = "img/none.png";
						document.getElementById("progTitle2").innerHTML = "None left";
					}
					if(programmes[2]){
						document.getElementById("prog3").src = programmes[2].image;
						document.getElementById("progTitle3").innerHTML = programmes[2].name;
					}else{
						document.getElementById("prog3").src = "img/none.png";
						document.getElementById("progTitle3").innerHTML = "None left";
					}
					if(programmes[3]){
						document.getElementById("prog4").src = programmes[3].image;
						document.getElementById("progTitle4").innerHTML = programmes[3].name;
					}else{
						document.getElementById("prog4").src = "img/none.png";
						document.getElementById("progTitle4").innerHTML = "None left";
					}
					if(programmes[4]){
						document.getElementById("prog5").src = programmes[4].image;
						document.getElementById("progTitle5").innerHTML = programmes[4].name;
					}else{
						document.getElementById("prog5").src = "img/none.png";
						document.getElementById("progTitle5").innerHTML = "None left";
					}
				}

				function fetchProgrammes(first,second,third,fourth){ //Works out which programmes to recommend to the user.

					//Below finds the opposite of all given moods to determine which ones will harm a programmes recommendability.
					var harmful = []; //Stores all of the moods that would harm the recommendability of a program.
					harmful.push(fetchHarmful(first));

					if (second.value > 0){
						harmful.push(fetchHarmful(second));
					}
					if (third.value > 0){
						harmful.push(fetchHarmful(third));
					}
					if (fourth.value > 0){
						harmful.push(fetchHarmful(fourth));
					}

					//A points system determines which programmes are most appropriate, the more similar to the set of moods the user selects the programs moods are the more points it gets.
					//100 points are awarded if the biggest mood of the user matches the top mood of a programme. 75/50/25 points are awarded for other similarities based on the rank of each mood.
					var similarity = [];
					for(var i = 0; i < progHolder.length; i++){
						similarity.push(0);
						if(progHolder[i].mood1 === first){ //If the primary mood of the program matches the primary mood of the user.
							similarity[i] += 100;
						}
						if(progHolder[i].mood1 === second || progHolder[i].mood2 === second || progHolder[i].mood2 === first){
							similarity[i] += 75;
						}
						if(progHolder[i].mood1 === third || progHolder[i].mood2 === third || progHolder[i].mood3 === third ||
							progHolder[i].mood3 === first || progHolder[i].mood3 === second){
							similarity[i] += 50;
						}
						if(progHolder[i].mood1 === fourth || progHolder[i].mood2 === fourth || progHolder[i].mood3 === fourth ||
							progHolder[i].mood4 === fourth || progHolder[i].mood4 === first || progHolder[i].mood4 === second || progHolder[i].mood4 === third){
							similarity[i] += 25;
						}
					}
					// Programs with recommended moods that clash with the users mood are docked points.
					//This is done in the same way that points are given but inverted so that the worse the clash is the more points are docked.
					for(var i = 0; i < progHolder.length; i++){
						if(progHolder[i].mood1 === harmful[0]){
							similarity[i] -= 80;
						}
						if(progHolder[i].mood1 === harmful[1] || progHolder[i].mood2 === harmful[0] || progHolder[i].mood2 === harmful[1]){
							similarity[i] -= 60;
						}
						if(progHolder[i].mood1 === harmful[2] || progHolder[i].mood2 === harmful[2] || progHolder[i].mood3 === harmful[2] ||
							progHolder[i].mood3 === harmful[0] || progHolder[i].mood3 === harmful[1]){
							similarity[i] -= 40;
						}
						if(progHolder[i].mood1 === harmful[3] || progHolder[i].mood2 === harmful[3] || progHolder[i].mood3 === harmful[3] ||
							progHolder[i].mood4 === harmful[3] || progHolder[i].mood4 === harmful[0] || progHolder[i].mood4 === harmful[1] || progHolder[i].mood4 === harmful[2]){
							similarity[i] -= 20;
						}
					}

					var prog1, prog2, prog3, prog4, prog5; //To hold the 5 recommended programs.

					var progVal = 0;
					var index1;
					for(var i = 0; i < progHolder.length; i++){ //Finds the program with the highest similarity value.
						if(progVal < similarity[i]){
							progVal = similarity[i];
							index1 = i;
						}
					}
					prog1 = progHolder[index1];

					var index2;
					progVal = 0;
					for(var i = 0; i < progHolder.length; i++){ //Finds the program with the second highest similarity value.
						if(i != index1 && progVal < similarity[i]){
							progVal = similarity[i];
							index2 = i;
						}
					}
					prog2 = progHolder[index2];

					var index3;
					progVal = 0;
					for(var i = 0; i < progHolder.length; i++){ //Finds the program with the third highest similarity value.
						if(i != index1 && i != index2 && progVal < similarity[i]){
							progVal = similarity[i];
							index3 = i;
						}
					}
					prog3 = progHolder[index3];

					var index4;
					progVal = 0;
					for(var i = 0; i < progHolder.length; i++){ //Finds the program with the fourth highest similarity value.
						if(i != index1 && i != index2 && i != index3 && progVal < similarity[i]){
							progVal = similarity[i];
							index4 = i;
						}
					}
					prog4 = progHolder[index4];

					var index5;
					progVal = 0;
					for(var i = 0; i < progHolder.length; i++){ //Finds the program with the fifth highest similarity value.
						if(i != index1 && i != index2 && i != index3 && i != index4 && progVal < similarity[i]){
							progVal = similarity[i];
							index5 = i;
						}
					}
					prog5 = progHolder[index5];

					var programmes = [prog1, prog2, prog3, prog4, prog5]; //stores all of the final program recommendations.
					showProgrammes(programmes);
				}
				function fetchHarmful(mood){
					//returns the opposite mood of a given mood.
					var harmVal;
					if(mood === "agitated" ){
						harmVal = "calm";
					}else if(mood === "calm"){
						harmVal = "agitated";
					}else if(mood === "Happy"){
						harmVal = "Sad";
					}else if(mood === "Sad"){
						harmVal = "Happy";
					}else if(mood === "Tired"){
						harmVal = "Wide Awake";
					}else if(mood === "Wide Awake"){
						harmVal = "Tired";
					}else if(mood === "Scared"){
						harmVal = "Fearless";
					}else if(mood === "Fearless"){
						harmVal = "Scared";
					}else{
						harmVal = "";
					}
					return harmVal;
				}
			</script>
			<header>
				<div class="mainLogo">
				<img src="img/sky_logo.png" class="mainLogo" alt="sky logo">
				</div>
				<div class="title"><p>Moonslider</p></div>
				<div class = "nav">Moonslider | <a href="upload.php">Upload Content</a></div>
			</header>
			<div class="sliders">
				<form action="index.php" method="POST" enctype="multipart/form-data">
					<br><div class="slider" id="slider1cont">
						<label for="slider1" class="leftlabels">Agitated
						<input type="range" min = "-50" max="50" value ="0" name = "slider1" id ="slider1" class="slider" onchange="sliderMoved(1)"/>
						<label for="slider1" class="rightlabels">Calm
					</div><br><br><br>

					<div class="slider" id="slider2cont">
						<label for="slider2" class="leftlabels">Happy
						<input type="range" min = "-50" max="50" value ="0" name = "slider2" id ="slider2" class="slider" onchange="sliderMoved(2)"/>
						<label for="slider2" class="rightlabels">Sad
					</div><br><br><br>

					<div class="slider" id="slider3cont">
						<label for="slider3"  class="leftlabels">Tired
						<input type="range" min = "-50" max="50" value ="0" name = "slider3" id ="slider3" class="slider" onchange="sliderMoved(3)"/>
						<label for="slider3" class="rightlabels">Wide Awake
					</div><br><br><br>

					<div class="slider" id="slider4cont">
						<label for="slider4"  class="leftlabels">Scared
						<input type="range" min = "-50" max="50" value ="0" name = "slider4" id ="slider4" class="slider" onchange="sliderMoved(4)"/>
						<label for="slider4" class="rightlabels">Fearless
					</div>
				</form>
			</div>

			<img class = "progImg" id = "prog1" src="img/none.png"></img>
			<img class = "progImg" id = "prog2" src="img/none.png"></img>
			<img class = "progImg" id = "prog3" src="img/none.png"></img>
			<img class = "progImg" id = "prog4" src="img/none.png"></img>
			<img class = "progImg" id = "prog5" src="img/none.png"></img>
			<div class = "progTitle" id = "progTitle1">No Content</div>
			<div class = "progTitle" id = "progTitle2">No Content</div>
			<div class = "progTitle" id = "progTitle3">No Content</div>
			<div class = "progTitle" id = "progTitle4">No Content</div>
			<div class = "progTitle" id = "progTitle5">No Content</div>
	</body><br>
<?php //Php used to convert the data in the XML file into javascript objects.
			//Probably doable without needing php but time is very limited and I am much more familiar with php.
			//File uploading currently has no validation as there was no remaining time so please only use
			//XML documents in the format of the one included.

		if(isset($_FILES["progData"])){ //Creates a copy of the uploaded data file in the data folder then passes the path to parseData().
			$path = 'data/';
			$path = $path . basename($_FILES["progData"]["name"]);
			move_uploaded_file($_FILES["progData"]["tmp_name"], $path);
			parseData($path);
		}

		function parseData($programs){ //Loads the xml and dumps the data into Programme objects stored in the progHolder array.
			$xml = simplexml_load_file($programs);
			$a=0;
			foreach($xml->children() as $progListItem){
				echo' <script>
							var id = '. $progListItem['id'] . ';
							var name = "'. $progListItem->name . '";
							var image = "'. $progListItem->image . '";
							var moods = "'. $progListItem->moods . '";
							var moodOrder = moods.split(", ");
							var mood1 = moodOrder[0];
							var mood2 = moodOrder[1];
							var mood3 = moodOrder[2];
							var mood4 = moodOrder[3];
							var programme'.$a.' = new Programme(id,name,image,mood1,mood2,mood3,mood4);
							progHolder.push(programme'.$a.');
							</script>';
				$a++;
				}
		}
?>
