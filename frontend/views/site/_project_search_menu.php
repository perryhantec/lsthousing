<?php

use common\models\Definitions;

$no_of_ppls = Definitions::getNoOfPeople();
$projects = Definitions::getProjectName();
$areas_districts = Definitions::getAreaDistrict();
?>

<section class="search2">
    <div class="search2-bg">
        <div class="search2-form">
            <form action="project_search" method="get">
                <ul>
                    <li class="choice">
                        <label>單位人數</label>
                        <select name="no_of_ppl">
                            <option value=''>請選擇</option>
                            <?php foreach ($no_of_ppls as $no_of_ppl) {
                                $selected = isset($_GET['no_of_ppl']) && $_GET['no_of_ppl'] == $no_of_ppl && $_GET['no_of_ppl'] != '' ? 'selected' : '';
                            ?>
                            <option value="<?= $no_of_ppl ?>" <?= $selected ?>><?= $no_of_ppl ?>人</option>
                            <?php } ?>
                        </select>
                    </li>
                    <li class="choice">
                        <label>項目</label>
                        <select name="project">
                            <option value=''>請選擇</option>
                            <?php foreach ($projects as $id => $title) { 
                                $selected = isset($_GET['project']) && $_GET['project'] == $id ? 'selected' : '';                                
                            ?>
                            <option value="<?= $id ?>" <?= $selected ?>><?= $title ?></option>
                            <?php } ?>
                        </select>
                    </li>
                    <li class="choice">
                        <label>地區</label>
                        <select name="district">
                            <option value=''>請選擇</option>
                            <?php foreach ($areas_districts as $area => $districts) { ?>
                                <optgroup label="<?= $area ?>">
                                <?php foreach ($districts as $district_id => $district) {
                                    $selected = isset($_GET['district']) && $_GET['district'] == $district_id ? 'selected' : '';
                                ?>
                                    <option value="<?= $district_id ?>" <?= $selected ?>><?= $district ?></option>
                                <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    </li>
                    <li class="button">
                        <button>
                            <img src="images/search_icon.png" />
                        </button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</section>