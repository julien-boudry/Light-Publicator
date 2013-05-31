<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div id="ucp_billets_title">
	<?php echo $lang_ucp_profil_title  ; ?>
</div>

<div class="error" id="profilage_errors">
	<?php IF (isset($profilage_fails_list)) { error_show($profilage_fails_list) ; } ?>
</div>


		<form method="post" action="index.php?module=ucp&amp;page=profil">
		
	
	<div class="ligne_formulaire_inscription" id="inscription_pseudo">
		<div class="int_formulaire_inscription" id="pseudo_int">
			<label for="pseudo"><?php echo $lang_join_pseudo ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="pseudo_input">
			<input type="text" name="pseudo" id="pseudo" maxlength="20" value="<?php echo $member_infos['pseudo'] ; ?>" required />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_prenom">
		<div class="int_formulaire_inscription" id="prenom_int">
			<label for="prenom"><?php echo $lang_join_prenom ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="prenom_input">
			<input type="text" name="prenom" id="prenom" maxlength="25" autocomplete="on"  value="<?php echo $member_infos['prenom'] ; ?>"  />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_nom">
		<div class="int_formulaire_inscription" id="nom_int">
			<label for="nom"><?php echo $lang_join_nom ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="nom_input">
			<input type="text" name="nom" id="nom" maxlength="25" autocomplete="on"  value="<?php echo $member_infos['nom'] ; ?>" />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_genre">
		<div class="int_formulaire_inscription" id="genre_int">
			<?php echo $lang_join_genre ; ?>
		</div>
		<div class="input_formulaire_inscription" id="genre_input">
			<input type="radio" name="genre" id="unknow" checked="checked" value="unknow" /> <label for="unknow"><?php echo $lang_join_unknow ; ?></label>
			<input type="radio" name="genre" id="male" value="male" /> <label for="male"><?php echo $lang_male ; ?></label>
			<input type="radio" name="genre" id="female" value="female" /> <label for="female"><?php echo $lang_female ; ?></label>
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_email">
		<div class="int_formulaire_inscription" id="email_int">
			<label for="email"><?php echo $lang_join_email ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="email_input">
			<input type="email" name="email" id="email" maxlength="50" autocomplete="on"  value="<?php echo $member_infos['email'] ; ?>"  required />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_lang">
		<div class="int_formulaire_inscription" id="lang_int">
			<label for="lang"><?php echo $lang_join_lang ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="lang_input">
			<select name="lang" id="lang">
			  <?php list_langs($member_infos['id_language']) ; ?>
			</select>
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_style">
		<div class="int_formulaire_inscription" id="style_int">
			<label for="style"><?php echo $lang_join_style ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="style_input">
			<select name="style" id="style">
				<?php list_styles($member_infos['id_style']) ; ?>
			</select>
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_password">
		<div class="int_formulaire_inscription" id="password_int">
			<label for="password"><?php echo $lang_join_password ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="password_input">
			<input type="password" name="password" id="password" maxlength="30" />
		</div>
	</div>
	
	<div class="ligne_formulaire_inscription" id="inscription_password_confirm">
		<div class="int_formulaire_inscription" id="password_confirm_int">
			<label for="password_confirm"><?php echo $lang_join_password_confirm ; ?></label>
		</div>
		<div class="input_formulaire_inscription" id="password_confirm_input">
			<input type="password" name="password_confirm" id="password_confirm" maxlength="30"/>
		</div>
	</div>
	
	<input type="hidden" name="edit_ucp_candidate" value="on" />
		
	<input id="inscription_submit" type="submit" value="<?php echo $lang_edit_confirm ; ?>" />   
      
		</form>