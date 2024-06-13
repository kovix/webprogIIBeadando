<!DOCTYPE html>
    <html lang="<?=THEME_LANG?>">
    <head>
        <meta charset="<?=THEME_CHARSET?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?=THEME_DESCRIPTION?>">
        <meta name="author" content="<?=THEME_AUTHOR?>">
        <title><?= isset($title) ? $title : DEFAULT_TITLE ?></title>

        <?php
            if (is_array(THEME_CSS)) {
                foreach (THEME_CSS as $css) {
                    echo "<link href=\"{$css}\" rel=\"stylesheet\">";
                }
            }
        ?>

    </head>
    <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ADEJ1R</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                        if (is_array(THEME_MENU)) :
                            foreach (THEME_MENU as $menuitem) :
                            ?>
                                <li class="<?= implode(" ", $menuitem['OUTER_CLASSES']) ?>">
                                    <a class="<?= implode(" ", $menuitem['INNER_CLASSES']) ?>" href="<?= $menuitem['URL'] ?>"><?= $menuitem['TITLE'] ?></a>
                                </li>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <?= isset($content) ? $content : "" ?>
            </div>
        </div>
    </div>

    <?php
    if (is_array(THEME_JS)) {
        foreach (THEME_JS as $js) {
            echo "<script src=\"{$js}\" rel=\"stylesheet\"></script>";
        }
    }
    ?>

    </body>
    </html>
