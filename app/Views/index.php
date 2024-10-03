<?php
include_once 'headtags.php';
?>
<div class="container pt-4 mb-5">
    <div class="d-flex justify-content-between">
        <div></div>
        <div>
            <?php if (hasPermission("surveys", "add", $metadata)) { ?>
                <a class="btn btn-outline-primary btn-sm" href="<?= $baseURL ?>surveys/modify/add">
                    <i class="fa fa-place-of-worship"></i> Create Survey
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="row mt-3">
        <?php if (empty($surveys_list)) { ?>
            <div class="col-12">
                <div class="alert alert-warning">
                    No surveys found.
                </div>
            </div>
        <?php } else { ?>
            <?php foreach ($surveys_list as $survey) { ?>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <?= $survey['title'] ?>
                        </div>
                        <div class="card-body bg-white">
                            <div class="survey-image">
                                <img class="m-0" width="100%" src="<?= $baseURL . $survey['cover_art'] ?>" alt="">
                            </div>
                            <div>
                                <?= character_limiter(strip_tags($survey['description']), 120) ?>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <small>
                                            <i class="fa fa-calendar-check"></i> <?= $survey['date_created'] ?>
                                        </small>

                                    </div>
                                    <div>
                                        <small>
                                            <i class="fa fa-chart-pie"></i> <?= $survey['submitted_answers'] ?> Participants
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-1 border-top pt-1">
                                <small class="float-left">
                                    <i class="fa fa-calendar"></i> Start Date: <?= date('jS M y', strtotime($survey['start_date'])) ?>
                                </small>
                                <small class="float-right">
                                    <i class="fa fa-calendar-check"></i> End Date: <?= date('jS M y', strtotime($survey['end_date'])) ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer w-100">
                            <div class="w-100 d-flex justify-content-between">
                                <div>
                                    <?php if (hasPermission("surveys", "update", $metadata)) { ?>
                                        <a href="<?= $baseURL ?>surveys/modify/<?= $survey['slug'] ?>/edit" title="Edit Survey" class="btn btn-sm btn-outline-success">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= $baseURL ?>surveys/modify/<?= $survey['slug'] ?>/questions" title="View Survey Questions" class="btn btn-sm btn-outline-info">
                                            <i class="fa fa-question-circle"></i>
                                        </a>
                                    <?php } ?>
                                    <a target="_blank" href="<?= $baseURL ?>embed/<?= $survey['slug'] ?>" title="View Survey & Answer" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                                <div>
                                    <a title="Analyze Survey Results" href="<?= $baseURL ?>embed/<?= $survey['slug'] ?>/results" class="btn btn-sm btn-outline-warning">
                                        <i class="fa fa-chart-bar"></i> Results
                                    </a>
                                    <?php if (hasPermission("surveys", "update", $metadata)) { ?>
                                        <a title="Export Survey as PDF" href="<?= $baseURL ?>embed/<?= $survey['slug'] ?>/export" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-file-download"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if (hasPermission("surveys", "delete", $metadata)) { ?>
                                        <button hidden title="Delete Survey" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<?php include_once 'foottags.php'; ?>