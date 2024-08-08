<?php
/**
 * 这是一套简洁的博客主题 <a href="https://facile.misterma.com/" target="_blank">点击查看使用说明, Forkz自Facile</a>
 *
 * @package My-Facile
 * @author Mr.Chip
 * @version 2.1.12
 * @link 
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$GLOBALS['page'] = 'index';
// 检查数据库字段
checkField();
$this->need('components/header.php');
?>

<div class="container main">
    <div class="row mt-4">
        <div class="col-xl-8 col-lg-8 post-list">
            <?php $this->need('components/post-list.php'); ?>
            <nav class="page-nav my-5" aria-label="<?php _t('分页导航'); ?>">
                <?php $this->pageNav('<i class="icon-chevron-left"></i>', '<i class="icon-chevron-right"></i>', 1, '...', array('wrapTag' => 'ul', 'wrapClass' => 'pagination justify-content-center', 'itemTag' => 'li', 'textTag' => 'a', 'currentClass' => 'active', 'prevClass' => 'prev', 'nextClass' => 'next')); ?>
            </nav>
        </div>
        <?php $this->need('components/sidebar.php'); ?>
    </div>
</div>

<?php $this->need('components/footer.php'); ?>