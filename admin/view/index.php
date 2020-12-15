<?php wp_enqueue_style('admin_css', plugin_dir_url( __FILE__ ) . '../../assets/css/style-admin.css'); ?>

<div id="clp_content" class="wrap">
    <h1>Compute Link Settings</h1>

    <?php
    $tabs = array(
        'settings' => __("Settings", "compute-link-settings"),
        'links' => __("Links", "compute-link-urls")
    );

    $tabs = apply_filters("clp_tabs", $tabs);
    ?>

    <h2 class="nav-tab-wrapper">
        <?php
        $activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'settings';
        foreach ($tabs as $tab => $name) {
            $class = ($tab == $activeTab) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='?page=compute_links&tab=$tab'>$name</a>";
        }
        ?>
    </h2>

    <?php
    include "$activeTab.php";
    ?>

</div>