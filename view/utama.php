<?php include view .  'template.php' ?>
<?php startblock('content') ?>
<p>User</p>
<ul>
    <?php foreach($data as $u){ ?>
        <li><?=$u['nama']?></li>
    <?php } ?>
</ul>
<?php endblock() ?>