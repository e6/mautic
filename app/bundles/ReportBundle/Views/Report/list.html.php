<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
if ($tmpl == 'index')
$view->extend('MauticReportBundle:Report:index.html.php');
?>

<div class="table-responsive scrollable body-white padding-sm page-list">
    <?php if (/*count($items)*/ true == false): ?>
        <table class="table table-hover table-striped table-bordered page-list">
            <thead>
            <tr>
                <th class="col-page-actions"></th>
                <?php
                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'page',
                    'orderBy'    => 'p.title',
                    'text'       => 'mautic.report.report.thead.title',
                    'class'      => 'col-page-title',
                    'default'    => true
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'page',
                    'orderBy'    => 'c.title',
                    'text'       => 'mautic.report.report.thead.category',
                    'class'      => 'visible-md visible-lg col-page-category'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'page',
                    'orderBy'    => 'p.author',
                    'text'       => 'mautic.report.report.thead.author',
                    'class'      => 'visible-md visible-lg col-page-author'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'page',
                    'orderBy'    => 'p.language',
                    'text'       => 'mautic.report.report.thead.language',
                    'class'      => 'visible-md visible-lg col-page-lang'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'page',
                    'orderBy'    => 'p.hits',
                    'text'       => 'mautic.report.report.thead.hits',
                    'class'      => 'col-page-hits'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'sessionVar' => 'page',
                    'orderBy'    => 'p.id',
                    'text'       => 'mautic.report.report.thead.id',
                    'class'      => 'col-page-id'
                ));
                ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <?php
                $variantChildren     = $item->getVariantChildren();
                $translationChildren = $item->getTranslationChildren();
                ?>
                <tr>
                    <td>
                        <?php
                        echo $view->render('MauticCoreBundle:Helper:actions.html.php', array(
                            'item'      => $item,
                            'edit'      => $security->hasEntityAccess(
                                $permissions['report:reports:editown'],
                                $permissions['report:reports:editother'],
                                $item->getCreatedBy()
                            ),
                            'clone'     => $permissions['report:reports:create'],
                            'delete'    => $security->hasEntityAccess(
                                $permissions['report:reports:deleteown'],
                                $permissions['report:reports:deleteother'],
                                $item->getCreatedBy()),
                            'routeBase' => 'report',
                            'menuLink'  => 'mautic_report_index',
                            'langVar'   => 'report.report',
                            'nameGetter' => 'getTitle'
                        ));
                        ?>
                    </td>
                    <td>
                        <?php echo $view->render('MauticCoreBundle:Helper:publishstatus.html.php',array(
                            'item'       => $item,
                            'model'      => 'report.report'
                        )); ?>
                        <a href="<?php echo $view['router']->generate('mautic_report_action',
                            array("objectAction" => "view", "objectId" => $item->getId())); ?>"
                           data-toggle="ajax">
                            <?php echo $item->getTitle(); ?> (<?php echo $item->getAlias(); ?>)
                        </a>
                        <?php
                        $hasVariants   = count($variantChildren);
                        $hasTranslations = count($translationChildren);
                        if ($hasVariants || $hasTranslations): ?>
                        <span>
                            <?php if ($hasVariants): ?>
                                <i class="fa fa-fw fa-sitemap"></i>
                            <?php endif; ?>
                            <?php if ($hasTranslations): ?>
                                <i class="fa fa-fw fa-language"></i>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                    </td>
                    <td class="visible-md visible-lg">
                        <?php $catName = ($category = $item->getCategory()) ? $category->getTitle() :
                            $view['translator']->trans('mautic.core.form.uncategorized'); ?>
                        <span><?php echo $catName; ?></span>
                    </td>
                    <td class="visible-md visible-lg"><?php echo $item->getAuthor(); ?></td>
                    <td class="visible-md visible-lg"><?php echo $item->getLanguage(); ?></td>
                    <td class="visible-md visible-lg"><?php echo $item->getHits(); ?></td>
                    <td class="visible-md visible-lg"><?php echo $item->getId(); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h4><?php echo $view['translator']->trans('mautic.core.noresults'); ?></h4>
    <?php endif; ?>
    <?php echo $view->render('MauticCoreBundle:Helper:pagination.html.php', array(
        "totalItems"      => /*count($items)*/ 0,
        "page"            => $page,
        "limit"           => /*$limit*/ 0,
        "menuLinkId"      => 'mautic_report_index',
        "baseUrl"         => $view['router']->generate('mautic_report_index'),
        'sessionVar'      => 'page'
    )); ?>
    <div class="footer-margin"></div>
</div>