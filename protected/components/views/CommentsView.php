<h3><i class="fa fa-comment-o" aria-hidden="true"></i> Comentarios:</h3>

<?php
    $userCanComment = TRUE;
 foreach ($commentsMods as $commentMod) :
     if(Yii::app()->user->getId() == $commentMod->user_id){
        $userCanComment = FALSE;
     }
    $class = $commentMod->user->id == 1 ? "admin-comment" : "";
?>

         <div class="col-md-12 comment-content <?php echo $class; ?>">
             <div class="row">
                 <?php echo "Escrito por <span class=\"username\">".ucfirst($commentMod->user->username)."</span> <small>el ".date("d/m/Y", strtotime($commentMod->enter_date))." a las ".date("H:i", strtotime($commentMod->enter_date))."</small>" ?>
             </div>
            <div class="row">
                 <?php echo $commentMod->content; ?>
            </div>
         </div>
<?php endforeach; ?>
<?php if ($userCanComment) : ?>
<div class="col-md-12">
    <form name="frmNewComment">
        <label>Añade un comentario:</label>
        <textarea name="Usercomments[content]" id="Userscomments_content" class="form-control bg-dark"></textarea>
        <input type="hidden" name="Usercomments[user_id]" id="Usercomments_user_id" value="<?php echo Yii::app()->user->getId(); ?>">
        <input type="hidden" name="Usercomments[film_id]" id="Usercomments_film_id" value="<?php echo $this->filmId; ?>">
        <div class="row" style="margin-top: 10px;">
            <button type="button" class="btn btn-success">Enviar</button>
        </div>
    </form>
</div>
<?php endif; ?>
