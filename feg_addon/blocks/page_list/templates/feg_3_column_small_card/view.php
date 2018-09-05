<?php    defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
$package = Package::getByHandle('feg_addon');
$package_path = $package->getRelativePath() . '/';
$defaultTumbnail = '<img src="'.$package_path.'images/feg_4c_block_banner.png">';
?>
<?php    if ( $c->isEditMode() && $controller->isBlockEmpty()) { ?>
    <div class="ccm-edit-mode-disabled-item"><?php    echo t('Empty Page List Block.')?></div>
<?php    } else { ?>
    <?php    if ($pageListTitle): ?>
        <h4><?php    echo $pageListTitle?></h4>    
    <?php    endif; ?>
    <?php    if ($rssUrl): ?>
        <a href="<?php    echo $rssUrl ?>" target="_blank" class="ccm-block-page-list-rss-feed"><i class="fa fa-rss"></i></a>
    <?php    endif; ?>
    <div class="ccm-block-page-list-pages f3cc-index-content">
        <div class="row">
        <?php        
            $ctr=1;
            foreach ($pages as $page):
                if (($ctr-1) % 3 == 0 && $ctr>1) {
                    echo( '</div><div class="row">');
                }
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
                        $tag->addClass('img-fit');
                    }
                }
                $includeEntryText = false;
                if ($includeName || $includeDescription || $useButtonForLink) {
                    $includeEntryText = true;
                }
                if (is_object($thumbnail) && $includeEntryText) {
                    $entryClasses = 'ccm-block-page-list-page-entry-horizontal';
                }
                $date = $dh->formatDateTime($page->getCollectionDatePublic(), true); 
                ?>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card">
                            <?php if (is_object($thumbnail)) {
                                    echo $tag;
                                } else {
                                    if ($displayThumbnail) {
                                        echo $defaultTumbnail;
                                    } else {
                                        echo ('<div class="spacer"></div>');
                                    }
                                }
                            ?>
                            <h4><a href="<?= $url;?>"><?= $title;?></a></h4>
                            <?php    if ($includeEntryText){ ?>
                                <p> <?php    if ($includeDescription) echo $description; ?> </p>
                            <?php } ?>
                        </div>
                    </div>
                <?php    $ctr++; ?> 
        <?php    endforeach; ?>
        </div>
    </div>
    <?php    if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?php    echo $noResultsMessage?></div>
    <?php    endif;?>
    <?php    if($showPagination) echo $pagination; ?>
<?php    } ?>


