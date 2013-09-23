<div class="topbar">
		<div class="header-wrapper">
	  		<!--<div class="logo"><a href="index.php"><img src="images/logo.png" /></a>
	  		</div>-->

	  		<div class="nav_menu"><!--nav_menu st-->
			<div class="logo"><a href="index.php"><img src="images/logo.png" /></a>
	  		</div>
		      <ul style="text-transform:uppercase;">
		      
				<?php
				if(isset($_SESSION['userid']) && $_SESSION['userid'] !='')
				{
				?>
		        <li><a href="signout.php" class="signout"><img src="images/signout.png" class="signup-icon">&nbsp; SIGN OUT </a> </li>
		        <li><a href="category_listing.php">My Room</a></li>
		        <?php
				$sel_cat="select * from ".$tbname."_category order by _ID desc ";
					$qr_cat=mysql_query($sel_cat);
					$i=1;
					while($rs_cat=mysql_fetch_array($qr_cat))
					{
					?>
		    			<li><a class="act<?php echo $i; ?> <?php if($rs_cat['_ID']==$CatID){ echo "current".$i; } ?>" href="rating.php?catall=all&CID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>"><?php echo $rs_cat['_Name']; ?></a></li>
		    		<?php
					$i++;
					}
					?>
		      
				<?php
					}
					else
					{
					?>
					<a href="registration.php"><div class="signup"><img src="images/user.png" class="signup-icon">&nbsp; Sign Up</div></a>

				<?php
				  }
				  ?>
		      </ul>
		   </div>
	</div><!--end header-wrapper-->
</div><!--end topbar-->

<div class="wrapper"><!--start body wrapper-->