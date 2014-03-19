<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input type="text" class="form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Search for...', 'slimwriter' ); ?>" />
        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'slimwriter' ); ?>" />
        </span>
    </div><!-- /input-group -->
</form>
