<div id="footer" class="pane darkbox">
    <div class="row">
        <div class="col-sm-6">
        <?php if(!dynamic_sidebar('Left Sidebar')):?><?php endif;?>
        </div>
        <div class="col-sm-6">
        <?php if(!dynamic_sidebar('Right Sidebar')):?><?php endif;?>
        </div>
    </div><!-- .row -->

    <div class="row">
        <div class="copyright col-sm-12">
    <p><?php _e('Copyright', 'slimwriter');?> &copy; <?php bloginfo('name');?><br/>
    <?php _e('Themed by', 'slimwriter');?> <a href="http://www.slimtheme.com/slimwriter"><?php _e('SlimTheme.com', 'slimwriter');?></a></p>
        </div>
    </div><!-- .row -->
</div><!-- #sidebar -->
