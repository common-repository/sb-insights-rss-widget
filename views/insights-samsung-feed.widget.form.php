<p>
    <label for="<?php echo $this->get_field_id('feed_select') ?>">Select a Category:</label>
    <select name="<?php echo $this->get_field_name('feed_select') ?>" id="<?php echo $this->get_field_id('feed_select') ?>">
        <?php foreach($options as $option): ?>

            <option value="<?php echo $option['url']  ?>" <?php echo ($option['url'] == $instance['feed_select'] ? 'selected' : '') ?>><?php echo $option['category'] ?></option>

        <?php endforeach; ?>
    </select>
</p>

<p>
    <label for="<?php echo $this->get_field_id('feed_date_sort_select') ?>">Sort by Date:</label>
    <select name="<?php echo $this->get_field_name('feed_date_sort_select') ?>" id="<?php echo $this->get_field_id('feed_date_sort_select') ?>">

        <option value="asc" <?php echo ($instance['feed_date_sort_select'] == 'asc' ? 'selected' : '') ?>>Ascending</option>
        <option value="desc" <?php echo ($instance['feed_date_sort_select'] == 'desc' ? 'selected' : '') ?>>Descending</option>

    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('feed_cache_input') ?>">Cache for </label>
    <input type="text" name="<?php echo $this->get_field_name('feed_cache_input') ?>" id="<?php echo $this->get_field_id('feed_cache_input') ?>" size="2" value="<?php echo $instance['feed_cache_input']; ?>"/> hour(s)
</p>