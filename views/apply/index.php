<?php

use yii\helpers\Html;
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
            !empty($user->nuptk) && 
            !empty($user->name) &&
            !empty($user->birthdate) &&
            !empty($user->religion_id) &&
            !empty($user->telp) &&
            !empty($user->address) &&
            !empty($user->cv) &&
            !empty($user->foto)
        ) {
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php        
        $nomor = 0;
        echo '<table class="table table-bordered table-striped">';
        echo '<tr>';
            echo '<th>No</th>';
            echo '<th>Sekolah</th>';
            echo '<th>Mata Pelajaran</th>';
            echo '<th>Lamaran</th>';            
        echo'</tr>';

        $hasil = '';
        foreach ($jobvacancies as $jobvacancy) {                                                                                    
            $nomor++;
            echo '<tr>';
                echo '<td>'.$nomor.'</td>';
                echo '<td>'.Html::a($jobvacancy->school->name,['school/view','user_id' => $jobvacancy->school->user_id]).'</td>';
                echo '<td>'.$jobvacancy->lesson->name.'</td>';
                echo '<td>';    
                $hasil = Html::a('<span class="btn btn-info">Lamar</span>', ['apply/create','jobvacancy_id' => $jobvacancy->id]);                    
                foreach ($applies as $apply) {       
                    if ($jobvacancy->id == $apply->jobvacancy_id && $apply->teacher_id == Yii::$app->user->identity->id) {                                                                                
                        if ($apply->status == 'M') {
                            $hasil = Html::a('<span class="btn btn-warning">Menunggu</span>', ['apply/batal','jobvacancy_id' => $jobvacancy->id]);
                            break;
                        }                        
                        else if ($apply->status == 'N') {
                            $hasil = Html::a('<span class="btn btn-danger">diTolak</span>');
                            break;
                        }                        
                        else if ($apply->status == 'Y') {
                            $hasil = Html::a('<span class="btn btn-success">diTerima</span>');
                            break;
                        }              
                    }                    
                }                
                echo $hasil;
                echo '</td>';
            echo '</tr>';                               
        }
        echo '</table>'; 
        }
        else {            
    ?>
        <div class="jumbotron btn-danger" style="color: white;">
            <h1>Lengkapi Profil Terlebih Dahulu</h1>
            <p><a class="btn btn-primary btn-lg" href=<?= "user/settings/teacher" ?> role="button">Buka Profil</a></p>
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
