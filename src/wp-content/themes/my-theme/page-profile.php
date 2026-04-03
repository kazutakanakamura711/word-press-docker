<?php
/**
 * Template Name: Profile
 * Profileページテンプレート
 */
get_header();
the_post();
?>
<main class="l-main">
    <?php get_template_part('template-parts/page-hero'); ?>

    <section class="p-profile">
        <div class="l-container">

            <div class="p-profile__intro">
                <div class="p-profile__avatar">
                    <img
                        src="<?php echo esc_url(
                            get_template_directory_uri() . '/assets/images/img-profile.webp',
                        ); ?>"
                        alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        loading="lazy"
                    >
                </div>
                <div class="p-profile__bio">
                    <h2 class="p-profile__name">経歴概要</h2>
                    <?php the_content(); ?>
                </div>
            </div>

            <?php
            // スキルカテゴリ定義（ACFフィールド名 => 表示ラベル）
            $skill_categories = [
                'skill_lang' => '言語',
                'skill_fw' => 'FW・ライブラリ',
                'skill_ui' => 'UI',
                'skill_api' => 'API',
                'skill_orm' => 'ORM',
                'skill_cms' => 'CMS',
                'skill_task' => 'タスク管理',
                'skill_comm' => 'コミュニケーション',
                'skill_ai' => 'AIツール',
                'skill_other' => 'その他',
            ];

            // get_field() はACF（Advanced Custom Fields）プラグインの関数。
            // WordPressを入れ直した際などACFが未インストール・未有効化の場合は関数が存在せず
            // 500エラーになるため、function_exists() で存在確認してから呼び出す。
            // 管理画面のプラグインからACFをインストール・有効化すればスキルフィールドが使用可能になる。
            $has_skills = false;
            if (function_exists('get_field')) {
                foreach ($skill_categories as $field_name => $label) {
                    if (get_field($field_name)) {
                        $has_skills = true;
                        break;
                    }
                }
            }
            ?>
            <?php if ($has_skills): ?>
            <div class="p-profile__skills">
                <h3 class="p-profile__skills-heading">Skills</h3>
                <dl class="p-profile__skills-list">
                    <?php foreach ($skill_categories as $field_name => $label):

                        $value = function_exists('get_field') ? get_field($field_name) : null;
                        if (!$value) {
                            continue;
                        }
                        $items = array_map('trim', explode(',', $value));
                        ?>
                    <div class="p-profile__skills-row">
                        <dt class="p-profile__skills-category"><?php echo esc_html($label); ?></dt>
                        <dd class="p-profile__skills-tags">
                            <?php foreach ($items as $item): ?>
                                <span class="p-profile__skills-item"><?php echo esc_html(
                                    $item,
                                ); ?></span>
                            <?php endforeach; ?>
                        </dd>
                    </div>
                    <?php
                    endforeach; ?>
                </dl>
            </div>
            <?php endif; ?>

        </div>
    </section>
</main>
<?php get_footer(); ?>
