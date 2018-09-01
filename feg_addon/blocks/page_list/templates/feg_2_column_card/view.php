<?php    defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>
<?php    if ( $c->isEditMode() && $controller->isBlockEmpty()) { ?>
    <div class="ccm-edit-mode-disabled-item"><?php    echo t('Empty Page List Block.')?></div>
<?php    } else { ?>
    <?php    if ($pageListTitle): ?>
        <h5><?php    echo $pageListTitle?></h5>    
    <?php    endif; ?>
    <?php    if ($rssUrl): ?>
        <a href="<?php    echo $rssUrl ?>" target="_blank" class="ccm-block-page-list-rss-feed"><i class="fa fa-rss"></i></a>
    <?php    endif; ?>
    <div class="ccm-block-page-list-pages f2cc-index-content">
        <?php        
            $ctr=1;
            foreach ($pages as $page):
                // Prepare data for each page being listed...
                $buttonClasses = 'ccm-block-page-list-read-more';
                $entryClasses = 'ccm-block-page-list-page-entry';
                $title = $th->entities($page->getCollectionName());
                $url = $nh->getLinkToCollection($page);
                $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
                $target = empty($target) ? '_self' : $target;
                $description = $page->getCollectionDescription();
                $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
                $description = $th->entities($description);
                $thumbnail = false;
                if ($displayThumbnail) {
                    $thumbnail = $page->getAttribute('thumbnail');
                    if(is_object($thumbnail)) {
                        $img = Core::make('html/image', array($thumbnail));
                        $tag = $img->getTag();
                        $tag->addClass('img-responsive');
                        $tag->addClass('img-kenburn');
                    }
                }
                $includeEntryText = false;
                if ($includeName || $includeDescription || $useButtonForLink) {
                    $includeEntryText = true;
                }
                if (is_object($thumbnail) && $includeEntryText) {
                    $entryClasses = 'ccm-block-page-list-page-entry-horizontal';
                }
                $date = $dh->formatDateTime($page->getCollectionDatePublic(), true); ?>
                <a href="<?php    echo $url ?>">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <?php if (is_object($thumbnail)) print $tag; ?>
                            <h4><?php    echo $title ?></h4>
                            <?php    if ($includeEntryText): ?>
                                <p> <?php    if ($includeDescription) echo $description; ?> </p>
                            <?php    endif; ?>
                            <a href="<?php    echo $url ?>" class="blue-button">Mehr</a>
                        </div>
                    </div>
                </a>
                <?php    $ctr++; ?> 
        <?php    endforeach; ?>
    </div>
    <?php    if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php    echo $noResultsMessage?></div>
    <?php    endif;?>
    <?php    if($showPagination) echo $pagination; ?>
<?php    } ?>


