<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

$this->title = empty($school->name) ? Html::encode($school->user->username) : Html::encode($school->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <?= Html::img($school->getAvatarUrl(230), [
                    'class' => 'img-rounded img-responsive',
                    'alt' => $school->user->username,
                ]) ?>
            </div>
            <div class="col-sm-6 col-md-8">
                <h4><?= $this->title ?></h4>
                <ul style="padding: 0; list-style: none outside none;">
                    <?php if (!empty($school->location)): ?>
                        <li>
                            <i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($school->location) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($school->website)): ?>
                        <li>
                            <i class="glyphicon glyphicon-globe text-muted"></i> <?= Html::a(Html::encode($school->website), Html::encode($school->website)) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($school->public_email)): ?>
                        <li>
                            <i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::a(Html::encode($school->public_email), 'mailto:' . Html::encode($school->public_email)) ?>
                        </li>
                    <?php endif; ?>
                    <li>
                        <i class="glyphicon glyphicon-time text-muted"></i> <?= Yii::t('user', 'Joined on {0, date}', $school->user->created_at) ?>
                    </li>
                </ul>
                <?php if (!empty($school->bio)): ?>
                    <p><?= Html::encode($school->bio) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
