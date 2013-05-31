<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>


<div id="content">

	<div class="error" id="profilage_errors">
		<?php IF (isset($profilage_fails_list)) { error_show($profilage_fails_list) ; } ?>
	</div>
		
		<form method="post" action="index.php">
		
	
	<div class="ligne_formulaire_inscription" id="inscription_pseudo">
		<div class="int_formulaire_inscription" id="pseudo_int">
			<label for="pseudo"><?php echo $lang_join_pseudo ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="pseudo_input">
			<input type="text" name="pseudo" id="pseudo" maxlength="20" value="<?php IF ( isset($_POST['pseudo']) ) {echo $_POST['pseudo'] ;}  ?>" required />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_prenom">
		<div class="int_formulaire_inscription" id="prenom_int">
			<label for="prenom"><?php echo $lang_join_prenom ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="prenom_input">
			<input type="text" name="prenom" id="prenom" maxlength="25" autocomplete="on"  value="<?php IF ( isset($_POST['prenom']) ) {echo $_POST['prenom'] ;}  ?>"  />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_nom">
		<div class="int_formulaire_inscription" id="nom_int">
			<label for="nom"><?php echo $lang_join_nom ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="nom_input">
			<input type="text" name="nom" id="nom" maxlength="25" autocomplete="on"  value="<?php IF ( isset($_POST['nom']) ) {echo $_POST['nom'] ;}  ?>" />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_genre">
		<div class="int_formulaire_inscription" id="genre_int">
			<?php echo $lang_join_genre ; ?>
		</div>
		<div class="input_formulaire_inscription" id="genre_input">
			<input type="radio" name="genre" value="unknow" id="unknow" <?php echo $return_profil['genre']['unknow'] ; ?> /> <label for="unknow"><?php echo $lang_join_unknow ; ?></label>
			<input type="radio" name="genre" id="male" value="male" <?php echo $return_profil['genre']['male'] ; ?> /> <label for="male"><?php echo $lang_male ; ?></label>
			<input type="radio" name="genre" id="female" value="female" <?php echo $return_profil['genre']['female'] ; ?> /> <label for="female"><?php echo $lang_female ; ?></label>
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_email">
		<div class="int_formulaire_inscription" id="email_int">
			<label for="email"><?php echo $lang_join_email ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="email_input">
			<input type="email" name="email" id="email" maxlength="50" autocomplete="on"  value="<?php IF ( isset($_POST['email']) ) {echo $_POST['email'] ;}  ?>"  required />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_lang">
		<div class="int_formulaire_inscription" id="lang_int">
			<label for="lang"><?php echo $lang_join_lang ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="lang_input">
			<select name="lang" id="lang">
			  <?php list_langs() ?>
			</select>
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_style">
		<div class="int_formulaire_inscription" id="style_int">
			<label for="style"><?php echo $lang_join_style ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="style_input">
			<select name="style" id="style">
				<?php list_styles() ?>
			</select>
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_password">
		<div class="int_formulaire_inscription" id="password_int">
			<label for="password"><?php echo $lang_join_password ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="password_input">
			<input type="password" name="password" id="password" maxlength="30" required />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_password_confirm">
		<div class="int_formulaire_inscription" id="password_confirm_int">
			<label for="password_confirm"><?php echo $lang_join_password_confirm ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="password_confirm_input">
			<input type="password" name="password_confirm" id="password_confirm" maxlength="30" required />
		</div>
	</div>
	
	<input type="hidden" name="inscription_candidate" value="on" />
		
	<input id="inscription_submit" type="submit" value="<?php echo $lang_join_confirm ; ?>" />   
      
		</form>


</div>