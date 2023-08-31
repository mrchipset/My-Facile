<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$GLOBALS['page'] = 'post';
//  点赞请求
if (isset($_POST['agree'])) {
    if ($_POST['agree'] == $this->cid) {
        exit((string)agree($this->cid));
    }
    exit('error');
}

$this->need('components/header.php');
?>

<div class="container main">
    <div class="row my-4">
        <div class="col-xl-8 col-lg-8 post-page mb-5 mb-sm-5 mb-md-5 mb-lg-0 mb-xl-0">
            <?php if ($this->options->breadcrumb == 'on'): ?>
                <nav aria-label="路径" class="breadcrumb-nav bg">
                    <ol class="breadcrumb m-0 pl-0 pr-0 pt-0 border-0">
                        <li class="breadcrumb-item">
                            <a href="<?php $this->options->siteUrl(); ?>">首页</a>
                        </li>
                        <li class="breadcrumb-item">
                            <?php $this->category(' '); ?>
                        </li>
                        <li tabindex="0" class="breadcrumb-item active" aria-current="page"><?php $this->title(); ?></li>
                    </ol>
                </nav>
            <?php endif; ?>
            <main class="post">
                <article>
                    <header>
                        <h1 class="post-title m-0">
                            <a href="<?php $this->permalink(); ?>" rel="bookmark"><?php $this->title(); ?></a>
                        </h1>
                    </header>
                    <?php $headerImg = headerImageDisplay($this, $this->options->headerImage, $this->options->headerImageUrl); ?>
                    <?php if ($headerImg): ?>
                        <div class="header-img mb-3 mt-4">
                            <a <?php if ($this->options->headerImageStyle == 'rounded-corners') echo 'class="rounded"'; ?> href="<?php $this->permalink(); ?>" aria-hidden="true" aria-label="文章头图" style="background-image: url(<?php echo $headerImg; ?>);" tabindex="-1"></a>
                        </div>
                    <?php endif; ?>
                    <div class="post-info mt-2">
                        <span class="ml-1" title="发布日期" data-toggle="tooltip" data-placement="top">
                            <i class="icon-calendar mr-2" aria-hidden="true"></i>
                            <?php $this->date('Y年m月d日'); ?>
                        </span>
                        <span class="ml-2" title="作者" data-toggle="tooltip" data-placement="top">
                            <i class="icon-user mr-2" aria-hidden="true"></i>
                            <a href="<?php $this->author->permalink(); ?>" class="mr-2" title="作者：<?php $this->author(); ?>">
                                <?php $this->author(); ?>
                            </a>
                        </span>
                        <span class="ml-2" title="阅读量" data-toggle="tooltip" data-placement="top">
                            <i class="icon-eye mr-2" aria-hidden="true"></i>
                            <?php echo postViews($this); ?>
                        </span>
                        <?php if ($this->user->hasLogin()): ?>
                        <span class="ml-2">
                            <i class="icon-pencil mr-2" aria-hidden="true"></i>
                            <a href="<?php echo $this->options->siteUrl . 'admin/write-post.php?cid=' . $this->cid; ?>">编辑</a>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="post-content mt-4" data-code-line-num="<?php $this->options->codeLineNum(); ?>">
                        <?php if (is_numeric($this->fields->expired) && (int)$this->fields->expired > 0 && $this->created + (int)$this->fields->expired * 86400 < time()): ?>
                            <!--警示信息-->
                            <div class="alert expiration-reminder" role="alert">这篇文章发布于 <?php echo getDays($this->created, time()); ?> 天前，其中的信息可能已经有所发展或是发生改变！</div>
                        <?php endif; ?>
                        <?php $GLOBALS['postPage'] = preg_split('/\[-page-]|<p>\[-page-]<\/p>/', $this->content); ?>
                        <?php $postPageNum = isset($_GET['post-page'])?$_GET['post-page']:1; ?>
                        <?php if (!isset($GLOBALS['postPage'][$postPageNum - 1])) $postPageNum = 1; ?>
                        <?php $GLOBALS['post'] = articleDirectory($GLOBALS['postPage'][$postPageNum - 1]); ?>
                        <?php echo $this->options->imagelazyloading == 'on'?replaceImgSrc($GLOBALS['post']['content']):$GLOBALS['post']['content']; ?>
                    </div>
                    <?php if (count($GLOBALS['postPage']) > 1): ?>
                        <nav aria-label="文章分页" class="py-3 post-pagination">
                            <ol class="pagination justify-content-center">
                                <?php if ($postPageNum > 1): ?>
                                    <li class="page-item">
                                        <a href="<?php echo $this->permalink . '?post-page=' . ($postPageNum - 1); ?>" class="page-link previous-page" aria-label="上一页" title="上一页（左光标键）" data-toggle="tooltip" data-placement="top">
                                            <i class="icon-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php for ($i = 0;$i < count($GLOBALS['postPage']);$i ++): ?>
                                    <li class="page-item <?php if ($i == $postPageNum - 1) echo 'active'; ?>">
                                        <a href="<?php echo $this->permalink . '?post-page=' . ($i + 1); ?>" class="page-link" <?php if ($i == $postPageNum - 1) echo 'aria-current="page"'; ?>><?php echo $i + 1; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($postPageNum < count($GLOBALS['postPage'])): ?>
                                    <li class="page-item">
                                        <a href="<?php echo $this->permalink . '?post-page=' . ($postPageNum + 1); ?>" class="page-link next-page" aria-label="下一页" title="下一页（右光标键）" data-toggle="tooltip" data-placement="top">
                                            <i class="icon-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ol>
                        </nav>
                    <?php endif; ?>
                    <div class="category-tag clearfix my-4">
                        <div class="post-category float-left" role="group" aria-label="文章分类">
                            <i class="icon-folder-open mr-1" aria-hidden="true"></i>
                            <?php $this->category(' '); ?>
                        </div>
                        <div class="post-tag float-right" role="group" aria-label="标签">
                            <i class="icon-price-tag mr-1" aria-hidden="true"></i>
                            <?php $this->tags(' ', true, '暂无标签'); ?>
                        </div>
                    </div>
                </article>
                <div class="agree-share mb-4">
                    <div class="text-center">
                        <?php $agree = $this->hidden?array('agree' => 0, 'recording' => true):agreeNum($this->cid); ?>
                        <button type="button" class="btn btn-sm agree-btn" <?php if ($agree['recording']) echo 'disabled'; ?> data-cid="<?php echo $this->cid; ?>" data-url="<?php $this->permalink(); ?>">
                            <i class="icon-thumbs-up"></i>
                            <span class="agree-num">赞 <?php echo $agree['agree']; ?></span>
                        </button>
                        <span class="pl-2"></span>
                        <button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#qr-link" aria-expanded="false" aria-controls="collapseExample">
                            <i class="icon-share2"></i>
                            <span>打赏</span>
                        </button>
                    </div>
                    <div class="collapse" id="qr-link">
                        <div class="mt-4 qr-link">
                            <!-- use wechat/alipay qr code image -->
                            <p class="text-center mb-2">感谢扫码支持</p>
                            <div class="text-center">
                                <img src=<?php $this->options->themeUrl('assets/img/wechat.jpg')?> width=128 height=128 alt="wechat"/>
                                <img src=<?php $this->options->themeUrl('assets/img/alipay.jpg')?> width=128 height=128 alt="wechat"/>
                                <!-- <canvas id="qr" class="mb-1" aria-label="文章二维码"></canvas>
                                <div class="link-box">
                                    <a href="https://service.weibo.com/share/share.php?url=<?php $this->permalink(); ?>&title=<?php $this->title(); ?>" target="_blank" rel="external nofollow" aria-label="分享到新浪微博" title="分享到新浪微博" data-toggle="tooltip" data-placement="top">
                                        <i class="icon-sina-weibo mr-1"></i>
                                    </a>
                                    <a class="text-info" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php $this->permalink(); ?>&title=<?php $this->title(); ?>&site=<?php $this->options->siteUrl(); ?>&summary=<?php $this->fields->summaryContent?$this->fields->summaryContent():$this->excerpt($this->options->summary, '...'); ?>" target="_blank" rel="external nofollow" aria-label="分享到QQ空间" title="分享到QQ空间" data-toggle="tooltip" data-placement="top">
                                        <i class="icon-qzone-logo mr-1"></i>
                                    </a>
                                    <a class="text-info" href="https://twitter.com/intent/tweet?url=<?php $this->permalink(); ?>&text=<?php $this->title(); ?>" target="_blank" rel="external nofollow" aria-label="分享到Twitter" title="分享到Twitter" data-toggle="tooltip" data-placement="top">
                                        <i class="icon-twitter mr-1"></i>
                                    </a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-navigation border-top border-bottom py-4">
                    <nav class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 previous">
                            <div>上一篇</div>
                            <div class="text-truncate">
                                <?php $this->thePrev('%s','没有了'); ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 next">
                            <div class="text-lg-right text-xl-right text-md-right">下一篇</div>
                            <div class="text-lg-right text-xl-right text-md-right next-box text-truncate">
                                <?php $this->theNext('%s','没有了'); ?>
                            </div>
                        </div>
                    </nav>
                </div>
                <?php $this->need('components/comments.php'); ?>
            </main>
        </div>
        <?php $this->need('components/sidebar.php'); ?>
    </div>
</div>
<?php if ($this->options->directoryMobile == 'enable'): ?>
    <button type="button" id="directory-btn" class="btn text-primary rounded-circle border d-block d-sm-block d-md-block d-lg-none d-xl-none" aria-expanded="false" aria-label="目录" title="目录">
        <i class="icon-list-ol"></i>
    </button>
    <div id="directory-mobile" class="border rounded shadow" style="display: none;">
        <div class="title-bar border-bottom">
            <h5 class="m-0">目录</h5>
            <button type="button" class="btn btn-sm close-btn" aria-label="关闭目录" title="关闭目录">
                <i class="icon-cancel-circle"></i>
            </button>
        </div>
        <div class="p-3 directory-list">
            <?php echo $GLOBALS['post']['directory']; ?>
        </div>
    </div>
<?php endif; ?>
<?php require_once 'components/max-img.php'; ?>
<?php $this->need('components/footer.php'); ?>