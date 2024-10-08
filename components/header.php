<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 检测是否包含主题配色 cookie
if (isset($_COOKIE['themeColor'])) {
    // 根据主题配色 cookie 设置配色
    $GLOBALS['color'] = $_COOKIE['themeColor'];
}else {
    // 如果不包含主题配色 cookie 就使用后台设置的默认配色
    $GLOBALS['color'] = $this->options->themeColor;

    // 如果设置了跟随系统主题并且浏览器是 IE
    if ($GLOBALS['color'] == 'auto-color' && isIE()) {
        // 默认使用浅色主题
        $GLOBALS['color'] = 'light-color';
    }
}

// 设置代码高亮主题
$codeThemeColor = $this->options->codeThemeColor;
// 如果代码高亮被禁用就不输出代码高亮主题设置
if ($this->options->codeHighlight != 'enable-highlight') {
    $codeThemeColor = 'code-theme-none';
}
?>

<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php
        $this->archiveTitle(array(
            'category'  =>  _e('分类 %s 下的文章'),
            'search'    =>  _e('包含关键字 %s 的文章'),
            'tag'       =>  _e('标签 %s 下的文章'),
            'author'    =>  _e('%s 发布的文章')
        ), '', ' - ');
        ?>
        <?php $this->options->title(); ?>
        <?php if ($this->is('index')) echo $this->options->tagline; ?>
    </title>
    <link rel="icon" href="<?php echo $this->options->logoUrl?$this->options->logoUrl:$this->options->siteUrl . 'favicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style-20230622.css'); ?>" type="text/css">
    <!--自定义CSS-->
    <?php if ($this->options->cssCode): ?>
        <style type="text/css">
            <?php $this->options->cssCode(); ?>
        </style>
    <?php endif; ?>
    <?php if ($this->is('post') && $this->fields->keywords): ?>
        <?php $this->header('keywords=' . $this->fields->keywords); ?>
    <?php else: ?>
        <?php $this->header(); ?>
    <?php endif; ?>
    <!--自定义HTML-->
    <?php if ($this->options->headHTML): ?>
        <?php $this->options->headHTML(); ?>
    <?php endif; ?>
</head>
<body class="<?php echo $codeThemeColor; ?> <?php $this->options->codeHighlight(); ?> <?php echo $GLOBALS['color']; ?>" data-color="<?php echo $GLOBALS['color']; ?>">
<header class="sticky-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="<?php _e('导航菜单'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor03">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php if ($this->is('index')) echo 'active'; ?>">
                        <a class="nav-link" href="<?php $this->options->siteUrl(); ?>" <?php if ($this->is('index')) echo 'aria-current="page"'; ?>><?php _e('首页'); ?></a>
                    </li>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                    <li class="nav-item <?php if ($this->is('page', $pages->slug)) echo 'active'; ?>">
                        <a class="nav-link" href="<?php $pages->permalink(); ?>" <?php if ($this->is('page', $pages->slug)) echo 'aria-current="page"'; ?>>
                            <?php $pages->title(); ?>
                        </a>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="<?php $this->options->siteUrl(); ?>" method="post" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="<?php _e('搜索'); ?>" required name="s">
                        <div class="input-group-append">
                            <button class="btn btn-primary my-sm-0" type="submit" aria-label="<?php _e('搜索'); ?>" title="<?php _e('搜索'); ?>" data-toggle="tooltip" data-placement="bottom">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</header>