<?php

use kartik\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Lesson;
use kartik\growl\Growl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JobvacancySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lowongan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobvacancy-index">    

    <?php        
        if (
            !empty($user->npsn) && 
            !empty($user->level_id) &&
            !empty($user->name) &&
            !empty($user->address) &&
            !empty($user->telp) &&
            !empty($user->foto)
        ) {
    ?>

    <h1><?= Html::encode($this->title) ?></h1>    

    <p>
        <?= Html::a('Buat Lowongan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
            $nomor = 0;
            echo '<table class="table table-bordered table-striped">';
            echo '<tr>';
            echo '<th>No</th>';
            echo '<th>Mata Pelajaran</th>';            
            echo '<th>Action</th>';
            echo'</tr>';        
            foreach ($jobvacancies as $jobvacancy) {
                if (Yii::$app->user->identity->id == $jobvacancy->school_id) {
                    $nomor++;
                    $hasil = '';
                    echo '<tr>';
                        echo '<td>'.$nomor.'</td>';
                        echo '<td>'.$jobvacancy->lesson->name."\t".Html::badge($jobvacancy->flags).'</td>';                                                            
                        echo '<td>';
                            echo Html::a('<i class="glyphicon glyphicon-eye-open"></i>',['jobvacancy/view', 'id' => $jobvacancy->id]);
                            echo Html::a('<i class="glyphicon glyphicon-pencil"></i>',['jobvacancy/update', 'id' => $jobvacancy->id],['style'=>'margin-left:10px;']);
                            echo Html::a('<i class="glyphicon glyphicon-trash"></i>',['jobvacancy/delete', 'id' => $jobvacancy->id],['onclick'=>'return(confirm("Apakah data mau dihapus?") ? true : false);', 'style'=>'margin-left:10px;']);
                        echo '</td>';
                    echo '</tr>';
                }            
            }
            echo '</table>';
        }  
        else{      
        ?>

        <div class="jumbotron btn-danger" style="color: white;">
            <h1>Lengkapi Profil Terlebih Dahulu</h1>
            <p><a class="btn btn-primary btn-lg" href=<?= "user/settings/school" ?> role="button">Buka Profil</a></p>
        </div>
        
        <?php
            echo Growl::widget([
                'type' => Growl::TYPE_DANGER,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'title' => 'Peringatan',
                'showSeparator' => true,
                'body' => 'Pastikan semua data profil sudah terisi'
            ]);
        }      
    ?>

</div>
