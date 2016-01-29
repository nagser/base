
    <?= \yii\helpers\Html::a('
         <img src="http://admindesigns.com/demos/absolute/1.1/assets/img/avatars/5.jpg" alt="avatar" class="mw30 br64">
         <span class="hidden-xs pl15"> Michael .R.</span>
         <span class="caret caret-tp hidden-xs"></span>
    ', '#', [
            'class' => 'dropdown-toggle fw600 p15',
            'data-toggle' => 'dropdown',
            'aria-expanded' => 'true'
        ]
    )?>
    <?= \yii\bootstrap\Dropdown::widget([
        'options' => ['class' => 'dropdown-menu list-group dropdown-persist w250'],
        'items' => [
            [
                'label' => \kartik\helpers\Html::tag('i', '', ['class' => 'fa fa-power-off']). ' ' . Yii::t('user', 'Logout'),
                'url' => ['/user/security/logout'],
                'linkOptions' => ['data-method' => 'post'],
                'options' => ['class' => 'dropdown-footer'],
                'encode' => false,
            ],
        ],
    ])?>