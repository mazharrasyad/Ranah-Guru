<?php

/* @var $this yii\web\View */

$this->title = 'Ranah Guru';
?>
<div class="site-index">

    <div class="jumbotron btn-info" style="color: white">
        <h1>Selamat di Ranah Guru</h1>    
    </div>

    <div class="row">    
    <?php foreach ($jobvacancies as $jobvacancy){ ?> 
        <div class="col-sm-6 col-md-4">       
        <div class="thumbnail">
            <img src="foto/<?= $jobvacancy->school->foto ?>">
            <div class="caption">
                <h3><?= $jobvacancy->school->name ?></h3>
                <p>Dibutuhkan Guru <b><?= $jobvacancy->lesson->name ?></b></p>
                <br>
                <p><?= $jobvacancy->description ?></p>
                <p><a href="school/view?user_id=<?= $jobvacancy->school_id ?>" class="btn btn-primary" role="button">Selengkapnya</a> 
                </p>
            </div>
        </div>
        </div>        
    <?php } ?>    
    </div>

</div>