<?php
//MIDTERM ADDITIONS - DATABASE CONNECTION
// Create Database connection
$con=mysqli_connect("db536766613.db.1and1.com","dbo536766613","IMCsql!s05","db536766613");//php variable connection (con)

// Check Database connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 
	if(isset($_POST['name'])) {
	
//MIDTERM ADDITIONS - EXPERT TIP - AVOID POSTING LOOP  //dont worry about lines 1 through 185 
	 if(isset($_POST['cookie'])) {
	  $COOKIELOAD=1; }
	  
		 $CARTCOUNT = 0;
	     $UNAME = ($_POST['name']);
		 $GREETING = 'Welcome back '. $UNAME.'.';
		 
	//MIDTERM ADDITIONS - SQL SELECT TO GET USER DETAILS	
		 $search1 = mysqli_query($con,"SELECT * FROM `Customer` WHERE FIRST = '". $UNAME ."'");
		 if(mysqli_num_rows($search1) > 0){
		 while($row = mysqli_fetch_array($search1)) {
		  $CARTCOUNT = $row[CartItems];
		  $PREF = $row[Pref];
		  $LATEST = $row[LastCart];
		  }
	//MIDTERM ADDITIONS - LOGIC TO SET BOOKS
	      $search2 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE CatID = '". $PREF ."'"); //the var con gives all the database information
		  if($LATEST != 0) {
		   $n=2;
		   $search3 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid = '". $LATEST ."'");
	       $BOOKID1=$LATEST;
		   while($row = mysqli_fetch_array($search3)) {
		   ${"BOOKPIC1"} = $row[Image];
		   ${"BOOKTITLE1"} = $row[Title];
		   ${"BOOKAUTH1"} = $row[Author];
		   ${"BOOKDESC1"} = $row[Description];
		   ${"BOOKPRICE1"} = $row[Price];
		   }
		  } else 
		  { $n=1;  // if the customer is not already on the database, then the default options load where there is a book from each of the 4 categories
		  }
		  while($row = mysqli_fetch_array($search2)) {
		  if($row[bid] != $LATEST){
	       ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];
		   $n++;
		   }
		    }
		   } else {
		    $n=1;
		    $search4 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid in (100,200,300,400)");
           while($row = mysqli_fetch_array($search4)) {
		   ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];	
           $n++;
		   }		   
      }
     }	  else { 
		 $GREETING = 'Welcome Guest. <a href="#" class="my_popup_open">Log on</a> for recommendations.';
	//MIDTERM ADDITIONS - SET BOOKS FOR LOGGED OUT VISITORS: shows the default books for site vistiors with no history data
		 $n=1;
		 $search4 = mysqli_query($con,"SELECT * FROM `Bookdetails` WHERE bid in (100,200,300,400)");
           while($row = mysqli_fetch_array($search4)) {
		   ${"BOOKID$n"} = $row[bid];
		   ${"BOOKPIC$n"} = $row[Image];
		   ${"BOOKTITLE$n"} = $row[Title];
		   ${"BOOKAUTH$n"} = $row[Author];
		   ${"BOOKDESC$n"} = $row[Description];
		   ${"BOOKPRICE$n"} = $row[Price];	
           $n++;
		   }		   

		 }
		 
		 
?>

<html>

 <head>

 
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="http://www.imcanalytics.com/js/jquery.popupoverlay.js"></script>
 <style>
 section {
    width: 90%;
    height: 200px;
    margin: auto;
    padding: 10px;
}

#one {
  float:left; 
  margin-right:20px;
  width:40%;
  border:1px solid;
  min-height:220px;
}

#two { 
  overflow:hidden;
  width:40%;
  border:1px solid;
  min-height:220px;
}

#three {
  float:left; 
  margin-top:10px;
  margin-right:20px;
  width:40%;
  border:1px solid;
  min-height:220px;
}

#four { 
  overflow:hidden;
  margin-top:10px;
  width:40%;
  border:1px solid;
  min-height:220px;
}

@media screen and (max-width: 400px) {
   #one { 
    float: none;
	margin-right:0;
    margin-bottom:10px;
    width:auto;
  }
  
  #two { 
  background-color: white;
  overflow:hidden;
  width:auto;
  margin-bottom:10px;
  min-height:170px;
}

   #three { 
    float: none;
	margin-right:0;
    margin-bottom:10px;
    width:auto;
  }
  
  #four { 
  background-color: white;
  overflow:hidden;
  width:auto;
  min-height:170px;
}

}
</style>

<script>
    
    $(document).ready(function() {

      // Initialize the plugin
	 
      $('#my_popup').popup({  
	   transition: 'all 0.3s',
       scrolllock: true // optional
   });

      $('#bookdeets').popup({  
	   transition: 'all 0.3s',
       scrolllock: true // optional
   });
   
});
//this is where the pop up for learn more and purchase get shown
   $.fn.DeetsBox = function(bid) {
        if(bid == '1'){	
	//MIDTERM ADDITIONS - NEW VARIABLES AND CONDITIONS
	//If then conditional statement for purchase - pulls the book name and book prices under the condition that there is nothing in the cart or that the member 
	//is new therefore one book from each category will pop up (in case of a log in
	// where the data is stored in the database, it pulls up your cart details and pushes book recommendations similar to the category of the book in your cart), 
		var bookname = $( "#book1" ).val(); //
		var bookprice = $( "#book1price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); //<p> is paragraph break
		$("#bookshelf").val('1'); 
		 var fromcart = $( "#iscart" ).val();
		 if(fromcart != 0){
		 
		 $("#deetcta").text('Purchase'); } //because book1 is in the cart
		
		}

		else if(bid == '2'){
		var bookname = $( "#book2" ).val();
		var bookprice = $( "#book2price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); //<p> indicates paragraph break
		$("#bookshelf").val('2'); //since book 2 is not in the cart and only in the preferences
		}
	
			else if(bid == '3'){
		var bookname = $( "#book3" ).val();
		var bookprice = $( "#book3price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); //<p> indicates paragraph break
		$("#bookshelf").val('3'); //since book 3 is not in the cart and only in the preferences
        }
			
			else if(bid == '4'){
		var bookname = $( "#book4" ).val();
		var bookprice = $( "#book4price" ).val();
		$("#showbookdeets").html(bookname + "<p>" + bookprice); //<p> indicates paragraph break
		$("#bookshelf").val('4'); //since book 4 is not in the cart and only in the preferences
		}
		$('#bookdeets').popup('show');
    };
	


</script>

<script language="JavaScript">

//TWO FUNCTIONS TO SET THE COOKIE

function mixCookie() {

 	    var name = document.forms["form1"]["name"].value;

        bakeCookie("readuser", name, 365);
			
   }
   
function bakeCookie(cname, cvalue1, cvalue2, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue1 + "%-" + cvalue2 + ";" + expires;
}

//TWO FUNCTIONS TO GET THE COOKIE

function checkCookie() {
    var userdeets = getCookie("readuser");
//MIDTERM ADDITIONS - 'CHECKFIRST' VARIABLE - FOR 'IF' BELOW
	var checkfirst = document.getElementById('firstload').value;

    if (userdeets != "") {
	    var deets = userdeets.split("%-");
		var user = deets[0];
		
//MIDTERM ADDITIONS - NEW NESTED 'IF' LOGIC TO POST USERNAME TO PHP TO CHECK FOR DETAILS THROUGH SQL		
		 if(checkfirst != 1){
		  
		  post('index.php',{name:user,cookie:yes});
		  
		 } else { greeting.innerHTML = 'Welcome ' + user; }
	     
  } else { return "";}
}

function getCookie(cname) {

    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

<!--MIDTERM ADDITIONS - FUNCTION TO DELETE COOKIE --> //when the user logs out the cookie gets deleted

function drop_cookie(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  window.location.href = window.location.pathname;
}

<!--MIDTERM ADDITIONS - FUNCTION TO POST FROM JS --> //dont worry about 276 to 297
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}


</script>

<!--GOOGLE ANALYTICS CODE WILL GO HERE -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61812395-1', 'auto'); //tracks the activity on your web page after you specify your GA username code
  ga('send', 'pageview');

</script>

 </head>
 
 
 <body  onload="checkCookie()">

 
 <div style="width:100%; height:25%; background-color:#57585A;">
 <img src="img/ic1.jpg" style="max-height: 100%;">
 
<!--MIDTERM ADDITIONS - LOG-OUT LINK & LOGIC FOR VISITOR LOGGED STATE. CART NOW A LINK.--> 
<!--the ga tag helps us track users who are adding products to the cart but not buying-->
<?php if(isset($_POST['name'])) { ?>
    <div style="float:right; margin-right:50px;margin-top:10px; color:white;"> <a href="#" style="color:white;" onclick="drop_cookie('readuser');">Log Out</a> </div>
	
	<div style="float:right; margin-right:75px;margin-top:10px; color:white;"> 
	 <a href="#" style="color:white;" onClick= "ga('send', 'event', 'review cart', 'click', <?php echo $CARTCOUNT ?>);" >Cart: <?php echo $CARTCOUNT ?></a>  
	 </div>
 <?php } ?>
 </div>
 <div style="margin-top:10px; margin-bottom:10px; font-size: 130%; color:#57585A;">
 <strong>Icculus Media: For All Your Fictional Needs</strong>
 </div>
 

 <div id="greeting"> <?php echo $GREETING ?> </div>
 
 <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED IN NEW CHECKCOOKIE LOGIC -->
 <input type="hidden" id="firstload" value="<?php echo $COOKIELOAD ?>">
 
  <!--MIDTERM ADDITIONS - NEW HIDDEN FIELD - USED FOR BOOK1 CTA -->
 <input type="hidden" id="iscart" value="<?php echo $LATEST ?>">
 
 <!-- The line above calls in the image from where it is stored. The lines below call in the book title, author and price. The items are hidden 
 because it allows for the dynamic calling of the books.
MIDTERM ADDITIONS - ADDED BOOKPRICE. MADE BOOK DYNAMIC - this pulls up the information from the database about the book title, price, book image. 
If there is no book in the cart, you will get the option to learn more about recommendations that are dynamically sent to you based on the book that is in the cart --> 

 
 <div id="cta1"> Please browse our options:</div>
 <section>
 <div id="one" style="padding:10px;">
	<?php echo $BOOK1; ?> <!--echo function is used to display or call out the info-->
	<img src="img/<?php echo $BOOKPIC1 ?>" style="float:left; margin-right:6px; height: 100px;">
	
<!-- MIDTERM ADDITIONS - ADDED BOOKPRICE. MADE BOOK DYNAMIC/customisation so that books appear based on the customer's preferences and book added to cart--> 
    <input type="hidden" id="book1" value="<?php echo $BOOKTITLE1 ?>">
	<input type="hidden" id="book1price" value="<?php echo $BOOKPRICE1 ?>">
	
	<strong><?php echo $BOOKTITLE1 ?></strong><p> <!-- start again here-->
	by <?php echo $BOOKAUTH1 ?> <p>
	<?php echo $BOOKDESC1 ?>
	<p>
	<?php if($LATEST != 0){ ?> <!--if statement used only for book 1 as book1 is the one added to cart -->
	<input type="button" value="Purchase" id="book1button" onclick="ga('send', 'event', 'convert', 'purchase', document.getElementById('book1').value);$(this).DeetsBox(1);"> <!-- the ga code for the event to track converts to purchases that can be seen in real time on the GA account-->
	<?php } else { ?>
	<input type="button" value="Learn More" id="book1button" onClick="ga('send', 'event','browse', 'learn_more_home', document.getElementById('book1').value); $(this).DeetsBox(1);"><!-- the ga code for the event to track browsing activity and cart adds that can be seen in real time on the GA account-->
	<?php } ?>
	</div>   
	<!--GA code for track purchase has been added only for Book 1 as that is the only book that has been added to cart by customer Sheryl-->

 <div id="two" style="padding:10px;">
	<?php echo $BOOKID2; ?>
	<img src="img/<?php echo $BOOKPIC2 ?>" style="float:left; margin-right:6px; height: 100px;">
    <input type="hidden" id="book2" value="<?php echo $BOOKTITLE2 ?>">
    <input type="hidden" id="book2price" value="<?php echo $BOOKPRICE2 ?>">

	<strong><?php echo $BOOKTITLE2 ?></strong><p>
	by <?php echo $BOOKAUTH2 ?> <p>
	<?php echo $BOOKDESC2 ?>
	<p>
	<input type="button" value="Learn More" id="book2button" onclick="$(this).DeetsBox(2)";>
	</div>
	
 <div id="three" style="padding:10px;">
	<?php echo $BOOKID3; ?>
	<img src="img/<?php echo $BOOKPIC3 ?>" style="float:left; margin-right:6px; height: 100px;">
    <input type="hidden" id="book3" value="<?php echo $BOOKTITLE3 ?>">
    <input type="hidden" id="book3price" value="<?php echo $BOOKPRICE3 ?>">

	<strong><?php echo $BOOKTITLE3 ?></strong><p>
	by <?php echo $BOOKAUTH3 ?> <p>
	<?php echo $BOOKDESC3 ?>
	<p>
	<input type="button" value="Learn More" id="book3button" onClick="$(this).DeetsBox(3)";>
	</div>
    
<!-- MIDTERM ADDITIONS - PHP SO THAT DISPLAY DEPENDS ON CART OR NOT -->	
<?php 
if($n > 4){ ?>                               
 <div id="four" style="padding:10px;">
	<?php echo $BOOKID4; ?>
	<img src="img/<?php echo $BOOKPIC4 ?>" style="float:left; margin-right:6px; height: 100px;">
    <input type="hidden" id="book4" value="<?php echo $BOOKTITLE4 ?>">
    <input type="hidden" id="book4price" value="<?php echo $BOOKPRICE4 ?>">

	<strong><?php echo $BOOKTITLE2 ?></strong><p>
	by <?php echo $BOOKAUTH4 ?> <p> 
	<?php echo $BOOKDESC4 ?> <!--displays the book description-->
	<p>
	<input type="button" value="Learn More" id="book4button" onClick="$(this).DeetsBox(4)";>
	</div>
	<?php } else { ?> <!--for customers where the book preferences may not have a 4th book -->
	<div id="four" style="padding:10px;"></div>
	<?php } ?>
	
</section>

	<div id="my_popup" style = "background-color: white; display: none; padding: 20px;">
    <form name="form1" action="#" method="post">
	     <div>Please enter your name:</div>
	
    <input name="name" id="uname" type="text" /><p>
	<input type="submit" onclick="mixCookie();" value="Log In"/> <p>
	</form>
	</div>
	

	<div id="bookdeets" style = "background-color: white; display: none; padding: 20px;">
	<div id="showbookdeets"></div>
    <input type="hidden" id="bookshelf"  value="0">
	
<!--MIDTERM ADDITIONS - CHANGED TO BUTTON TO CLOSE-->

	<button id="deetcta" class="bookdeets_close"  onClick="ga('send', 'event', 'convert', 'cart_add', document.getElementById('bookshelf').value)";/>Add to Cart</button> <p>
	</div>

 </body>
 </html>
