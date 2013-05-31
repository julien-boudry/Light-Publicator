<?php 
/**
*
* @package LIGHT PUBLICATOR
* @copyright (c) 2013 BOUDRY Julien - Born : 22/10/1988 - France
* @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License / Licence publique générale limitée GNU
*
*/ 
?>

<div class="error" id="edit_errors">
	<?php IF (isset($edit_fails_list)) { error_show($edit_fails_list) ; } ?>
</div>

<form method="post" action="post.php?editmode=on">

<div id="edit_title">
	<div class="int_article_title" id="edit_title_int">
		<label for="edit_titre"><?php echo $lang_edit_title ; ?></label>
	</div>
	<div class="edit_article_title" id="edit_title_input">
		<input style="text-align:center;" type="text" name="edit_titre" id="edit_titre" size="110" maxlength="300" value="<?php echo $post_titre ; ?>" required />
	</div>
</div>


<div id="edit_content">
	<div class="edit_article_inscription" id="edit_content_input">
		<textarea name="edit_content" cols="110" rows="40"><?php echo $post_content ; ?></textarea>
	</div>
</div>
	
	<input type="hidden" name="<?php echo $send_type ; ?>" value="<?php echo $post_hidden_value ?>" />	
	
	<input type="submit" value="<?php echo $lang_post_send ; ?>" />
	
</form>	
