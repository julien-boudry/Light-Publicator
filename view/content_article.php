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

	<?php

		IF ( ctype_digit($_GET['article']) )
		{
			show_article($_GET['article']) ;
		}
		ELSE
		{
		echo 'TOI TU VAS ARRETER DE ME CHERCHER DES FAILLES' ;
		}

	?>

		<div id="article_intersection_libre"> &nbsp; </div>

		<div id="comments">

			<?php

				IF ( ctype_digit($_GET['article']) )
				{
					show_comments($_GET['article']) ;
				}

			?>
			
		</div>
		

	<?php

		IF ( etat() == FALSE )
				{
				echo '</div>' ;
				exit() ;
				}
				
	?>

	<div id="post_comment">
		<h3 id="post_comment_title"><?php echo $lang_post_comment_title ; ?></h3>
		<div class="error" id="comment_error"><?php IF (isset($comment_fails_list)) { error_show($comment_fails_list) ; } ?></div>
		<div id="post_comment_formulaire">
		
			<form method="post" action="index.php?article=<?php echo $_GET['article'] ?>#comments">
				<div id="edit_comment_box" >
					<textarea name="comment_content" cols="50" rows="15" maxlength="30000"></textarea>
					<input type="hidden" name="post_comment" value="new" />
				</div>
				<div id="edit_comment_submit" >
					<input type="submit" value="<?php echo $lang_post_send ; ?>" />
				</div>
			</form>
			
		</div>
	</div>

</div>