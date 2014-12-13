<?php $project->partial('admin', 'header'); ?>

<div class="container">
<h1>Olá, <?php echo $auth->getSessionInfo()['userName'] ?>.</h1>
</div>

<?php $project->partial('admin', 'footer'); ?>