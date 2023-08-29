<footer>
    <div class="container py-3">
        <?php if ($this->options->icp): ?>
            <nav class="text-center mb-1"><?php $this->options->icp(); ?></nav>
        <?php endif; ?>
        <nav class="text-center">
            Powered by
            <a class="mx-1" href="http://www.typecho.org/" target="_blank">Typecho</a>
            Theme by
            <a class="ml-1" href="https://github.com/mrchipset/My-Facile.git" target="_blank">My-Facile</a>
        </nav>
    </div>
</footer>

<button class="btn text-primary rounded-circle d-none" id="to-top-btn" type="button" aria-label="返回顶部" title="返回顶部">
    <i class="icon-arrow-up"></i>
</button>

<script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/bundle-20230622.js'); ?>"></script>
<!--统计数据的图表js-->
<?php if (isset($GLOBALS['page']) && $GLOBALS['page'] == 'page-data'): ?>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/ECharts.js'); ?>"></script>
<?php endif; ?>
<!--自定义HTML-->
<?php if ($this->options->bodyHTML): ?>
    <?php $this->options->bodyHTML(); ?>
<?php endif; ?>
<?php $this->footer(); ?>
</body>
</html>
