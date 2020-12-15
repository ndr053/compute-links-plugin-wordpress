<?php
$computeLinkModel = new Clp_Link();
$convertorModel = new Clp_Convertor();
$page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
$limit = 20;
$offset = ($page - 1) * $limit;;
$firstId = 0;
$links = $computeLinkModel->getList($limit, $offset, $firstId);
$total = $computeLinkModel->getCountRequests();
$numOfPages = ceil($total / $limit);
?>


<table class="wp-list-table widefat fixed striped table-view-list">
    <thead>
    <tr>
        <th scope="col" id="link" class="manage-column column-link column-primary"><span>Link</span></th>
        <th scope="col" id="author" class="manage-column column-author">Author</th>
        <th scope="col" id="post-id" class="manage-column column-post-id">Post</th>
        <th scope="col" id="size" class="manage-column column-size">Size</th>
        <th scope="col" id="date" class="manage-column column-date">Date</th>
    </tr>
    </thead>

    <tbody id="the-list">
    <?php
    if ($total > 0):
    foreach ($links as $link):
        ?>

        <tr id="link-<?php echo $link->id ?>" class="iedit link-#">
            <td class="links column-link column-primary" data-colname="Link">
                <strong>
                    <a class="row-link" href="<?php echo $link->url ?>">
                        <?php echo $link->url ?>
                    </a>
                </strong>
            </td>
            <td class="author column-author" data-colname="Author"><?php echo $link->author_name ?></td>
            <td class="post-id column-post-id" data-colname="Post-ID">
                <a href="<?php echo get_edit_post_link($link->post_id) ?>"><?php echo $link->post_title ?></a>
            </td>
            <td class="size column-size"
                data-colname="Size"><?php echo $convertorModel->formatBytes($link->size) ?></td>
            <td class="date column-date" data-colname="Date">Created<br><?php echo $link->created_at ?></td>
        </tr>

    <?php
    endforeach;
    else:
        echo '<tr class="no-items"><td class="colspanchange" colspan="5">No links found.</td></tr>';
    endif;
    ?>
    </tbody>

    <tfoot>
    <tr>
        <th scope="col" id="links" class="manage-column column-title column-primary"><span>Links</span></th>
        <th scope="col" id="author" class="manage-column column-author">Author</th>
        <th scope="col" id="post-id" class="manage-column column-categories">Post</th>
        <th scope="col" id="size" class="manage-column column-tags">Size</th>
        <th scope="col" id="date" class="manage-column column-date">Date</th>
    </tr>
    </tfoot>

</table>

<div class="tablenav bottom">

    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo $total ?> items</span>
        <span class="pagination-links">

            <?php
            $pageLinks = paginate_links(array(
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'prev_text' => __('<div class=\'button\'> &laquo; </div>', 'text-domain'),
                'next_text' => __('<div class=\'button\'> &raquo;  </div>', 'text-domain'),
                'before_page_number' => '<div class=\'button\'>',
                'after_page_number' => '</div>',
                'total' => $numOfPages,
                'current' => $page,
            ));
            if ($pageLinks) {
                echo $pageLinks;
            }
            ?>
        </span>
    </div>
    <br class="clear">
</div>