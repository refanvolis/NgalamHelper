<table>
<?php
for($i=0; $i < count($item['content']); $i ++){
?>
    <tr>
        <td>
            <?= nl2br($item['content'][$i]['jdul_feed']); ?>
        </td>
        <td>
            <?= nl2br($item['content'][$i]['desc_feed']); ?>
        </td>
    </tr>
<?php
}
?>
</table>