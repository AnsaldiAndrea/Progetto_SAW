<?php 
    include('helper/connection.php');
    $stmt = $conn->prepare("SELECT * FROM Tags");
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    $counter=0; 
?>
<table style="width:100%">
    <?php foreach($result as $tag) : ?>
        <?php if($counter===0) :?>
            <tr>
        <?php endif ?>
        <td>
            <div class="checkbox"><label><input type="checkbox" class="tags" name="tags[]" value="<?= $tag['id'] ?>"<?php if(in_array($tag['id'],$_tags)) : ?>checked<?php endif ?>><?= $tag['tag'] ?></label></div>
        </td>
        <?php if($counter===2) :?>
            </tr>
        <?php endif; $counter=($counter+1) % 3?>
        <?php endforeach ?>
</table>