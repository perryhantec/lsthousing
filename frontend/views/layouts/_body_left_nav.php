<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


function generatePageLeftMenuNavSubmenu($menu_model) {
    $result = [
        'html' => '',
        'active' => $menu_model->route == Yii::$app->params['page_route'] ? true : false
    ];
    $_subMenus = $menu_model->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all();

    if (sizeof($_subMenus) > 0) {
        $_subMenus_html = "";
        foreach ($_subMenus as $_subMenu) {
            $_subMenu_result = generatePageLeftMenuNavSubmenu($_subMenu);
            $_subMenus_html .= $_subMenu_result['html'];
            if ($_subMenu_result['active'])
                $result['active'] = true;
        }
        $result['html'] .= '<li class="'.($result['active'] ? ' active' : '').'">
          <span>'.Html::encode($menu_model->name).'</span>
          <ul>
            '.$_subMenus_html.'
          </ul>
        </li>';
    } else {
        $result['html'] .= '<li class="'.($result['active'] ? 'active' : '').'">
          '.Html::a(Html::encode($menu_model->name), ['/'.$menu_model->route]).'
        </li>';
    }

    return $result;
}

?>
            <div class="page-left-menu hidden-xs hidden-sm">
                <ul class="page-left-menu-nav">
                <?php
                    foreach ($menus as $menu) {
                        $_subMenus = $menu->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all();
                        if (sizeof($_subMenus) > 0) {
                            $_subMenus_html = "";
                            $_menu_active = $menu->isActive;
                            foreach ($_subMenus as $_subMenu) {
                                $_subMenu_result = generatePageLeftMenuNavSubmenu($_subMenu);
                                $_subMenus_html .= $_subMenu_result['html'];
                                if ($_subMenu_result['active'])
                                    $_menu_active = true;
                            }
                            if ($_menu_active) {
                                echo '<li class="active submenu">';
                                echo Html::a('<div class="page-left-menu-icon" style="background-image: url('.$menu->iconDisplayPath.')"></div>'.Html::encode($menu->name), ['/'.$menu->route]);
                                echo '<ul>';
                                echo $_subMenus_html;
                                echo '</ul>';
                                echo '</li>';
                            } else {
                                echo '<li>';
                                echo Html::a('<div class="page-left-menu-icon" style="background-image: url('.$menu->iconDisplayPath.')"></div>'.Html::encode($menu->name), ['/'.$menu->route]);
                                echo '</li>';
                            }
                        } else {
                            echo '<li'.($menu->isActive ? ' class="active"' : '').'>';
                            echo Html::a('<div class="page-left-menu-icon" style="background-image: url('.$menu->iconDisplayPath.')"></div>'.Html::encode($menu->name), ['/'.$menu->route]);
                            echo '</li>';
                        }
//                         echo '<li'.($menu->route == Yii::$app->params['page_route'] ? ' class="active"' : '').'>'.Html::a(Html::img($menu->iconDisplayPath).$menu->name, ['/'.$menu->route]).'</li>';
                    }
                ?>
                </ul>
            </div>