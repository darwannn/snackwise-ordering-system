<!-- Nav-Contact -->
<div class="contactNavContainer">
    <div class="contactInformation">
        <div class="mobile">
            <a href="tel:09757667128"><i class="fas fa-phone"></i></a>
            <a href="mailto:sanluis.visuals@gmail.com"><i class=" fas fa-envelope "></i></a>
        </div>
        <div class="desktop">
            Phone No:<a href="tel:09757667128"> 0975 766 7128</span> </a>
            Email:<a href="mailto:sanluis.visuals@gmail.com"> sanluis.visuals@gmail.com </a>
        </div>
    </div>
    <div class="socialLink">
        <a href="https://www.facebook.com/SL-Visuals-115077600325689/"><i class="fab fa-facebook-f "></i></a>
        <a href="https://www.instagram.com/sanluis.visuals/"><i class="fab fa-instagram"></i></a>
    </div>
</div>

<nav class="navigationContainer">
    <ul>
        <li class="navigationLogo"><img src="img/logo.png"></li>

        <?php
        if(isset($_SESSION['email']) && $_SESSION['password'] == true){
        ?>
        <a class="logout" href="logout.php">
            Logout</a>
        <?php
        } 
        ?>

        <li class="navigationToggle"><i class="fas fa-bars"></i></li>
        <li class="navigationLinks">
            <a class="home " href="home.php"> <i class="fa fa-question fa-lg"></i>
                Home <i class="fa fa-chevron-circle-right  fa-lg"></i></a>
        </li>
        <div class="divider" id="divider"></div>
        <li class="navigationLinks">
            <a class="works" href="works.php?page=1"> <i class="fa fa-pen fa-lg"></i>Works
                <i class="fa fa-chevron-circle-right   fa-lg" aria-hidden="true"></i></i></a>
        </li>
        <div class="divider"></div>
        <li class="navigationLinks">
            <a class="contact" href="contact.php"> <i class="fa fa-phone  fa-lg" aria-hidden="true"></i>
                Contact <i class="fa fa-chevron-circle-right  fa-lg" aria-hidden="true"></i></a>
        </li>
    </ul>
</nav>