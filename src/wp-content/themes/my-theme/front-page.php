<?php get_header(); ?>
<main>
    <!-- ヒーローセクション -->
    <section>
        <h2>ようこそ</h2>
        <p><?php bloginfo('description'); ?></p>
    </section>

    <!-- 新着情報 -->
    <section>
        <h2>新着情報</h2>
        <?php
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
        );
        $query = new WP_Query($args);
        ?>
        <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <article>
                  <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('thumbnail'); ?>
            </a>
            <?php endif; ?>
                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <p><?php the_excerpt(); ?></p>
                </article>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>

    <!-- 医師紹介 -->
<section>
    <h2>医師紹介</h2>
    <?php
    $doctor_query = new WP_Query(array(
        'post_type'      => 'doctor',
        'posts_per_page' => 3,
    ));
    ?>
    <?php if ($doctor_query->have_posts()) : ?>
        <?php while ($doctor_query->have_posts()) : $doctor_query->the_post(); ?>
            <article>
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                <?php endif; ?>
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?></p>
                <!-- ↓ここを追加 -->
                <p>専門分野：<?php the_field('specialty'); ?></p>
                <p>出身大学：<?php the_field('university'); ?></p>
                <p>診療曜日：<?php the_field('work_days'); ?></p>
            </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</section>

</main>
<?php get_footer(); ?>