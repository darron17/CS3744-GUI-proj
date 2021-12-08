
    <div id="content">
      <form id="editing" method="POST" action="<?= BASE_URL ?>/EditProfile/process">
        <h2><?= $pageTitle ?></h2>

        <h2>Password</h2>
        <input class="password" name="password" type="text" placeholder="Type password here">

        <h2>First name</h2>
        <input class="first" name="first" type="text" placeholder="Type first name here">

        <h2>Last name</h2>
        <input class="last" name="last" type="text" placeholder="Type last name here">

        <h2>Email</h2>
        <input class="email" name="email" type="text" placeholder="Type email here">

        <h2>Experience</h2>
        <select name="experience">
		        <option value="new" />new
		        <option value="novice" />novice
            <option value="expert" />expert
	      </select>

        <input class="editBtn" type="submit" value="Submit changes">
      </form>




    </div><!-- #content -->
