<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Jobvacancy */

$this->title = $model->lesson->name;
$this->params['breadcrumbs'][] = ['label' => 'Lowongan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jobvacancy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php        
        $nomor = 0;
        echo '<table class="table table-bordered table-striped">';
        echo '<tr>';
            echo '<th>No</th>';
            echo '<th>Guru</th>';
            echo '<th>Lamaran</th>';
        echo'</tr>';
        foreach ($applies as $apply) {   
            if ($apply->jobvacancy_id == $model->id) {                         
                $nomor++;
                echo '<tr>';
                    echo '<td>'.$nomor.'</td>';
                    echo '<td>'.Html::a($apply->teacher->name,['teacher/view','user_id' => $apply->teacher->user_id]).'</td>';
                    echo '<td>';       
                    if ($apply->status == 'Y') {
                        echo Html::a('<span class="btn btn-success">Menerima</span>');                  
                        echo Html::a('<span class="btn btn-danger disabled" style="margin-left: 10px">Menolak</span>');
                    }
                    else if ($apply->status == 'N') {
                        echo Html::a('<span class="btn btn-success disabled">Menerima</span>');                  
                        echo Html::a('<span class="btn btn-danger" style="margin-left: 10px">Menolak</span>');
                    }
                    else{                        
                        echo Html::a('<span class="btn btn-success">Menerima</span>',['apply/terima','jobvacancy_id' => $apply->jobvacancy->id, 'teacher_id' => $apply->teacher->user_id]);                  
                        echo Html::a('<span class="btn btn-danger" style="margin-left: 10px">Menolak</span>',['apply/tolak','jobvacancy_id' => $apply->jobvacancy->id, 'teacher_id' => $apply->teacher->user_id]);                                    
                    }                           
                    echo '</td>';
                echo '</tr>';    
            }
        }
        echo '</table>';        
    ?>

</div>
