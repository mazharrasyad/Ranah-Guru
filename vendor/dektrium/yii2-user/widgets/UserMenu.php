<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace dektrium\user\widgets;

use yii\widgets\Menu;
use Yii;
use yii\base\Widget;

/**
 * User menu widget.
 */
class UserMenu extends Widget
{
    
    /** @array \dektrium\user\models\RegistrationForm */
    public $items;
    
    public function init()
    {
        parent::init();
        
        $networksVisible = count(Yii::$app->authClientCollection->clients) > 0;
        
        if (Yii::$app->user->identity->role_id == 2) {
            $this->items = [                                  
                ['label' => Yii::t('user', 'Profil Sekolah'), 'url' => ['/user/settings/school']],  
                ['label' => Yii::t('user', 'Akun'), 'url' => ['/user/settings/account']],
                [
                    'label' => Yii::t('user', 'Networks'),
                    'url' => ['/user/settings/networks'],
                    'visible' => $networksVisible
                ],
            ];
        }
        elseif (Yii::$app->user->identity->role_id == 3) {
            $this->items = [                                  
                ['label' => Yii::t('user', 'Profil Guru'), 'url' => ['/user/settings/teacher']],  
                ['label' => Yii::t('user', 'Akun'), 'url' => ['/user/settings/account']],
                [
                    'label' => Yii::t('user', 'Networks'),
                    'url' => ['/user/settings/networks'],
                    'visible' => $networksVisible
                ],
            ];
        }
        else{
            $this->items = [                                  
                ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],  
                ['label' => Yii::t('user', 'Akun'), 'url' => ['/user/settings/account']],
                [
                    'label' => Yii::t('user', 'Networks'),
                    'url' => ['/user/settings/networks'],
                    'visible' => $networksVisible
                ],
            ];
        }
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        return Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
            ],
            'items' => $this->items,
        ]);
    }
}
