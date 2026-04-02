<?php
/**
 * Home - Hero セクション
 * クリニック名 + キャッチコピー + 背景画像
 */
$hero_img_url = get_template_directory_uri() . '/assets/images/img-top-hero.webp'; ?>
<section
    class="relative min-h-[80vh] flex items-center justify-center bg-teal-900 bg-blend-overlay bg-cover bg-center"
    style="background-image: url('<?php echo esc_url($hero_img_url); ?>');"
>
    <!-- オーバーレイ -->
    <div class="absolute inset-0 bg-teal-900/60"></div>

    <div class="relative z-10 text-center text-white px-4 max-w-4xl mx-auto">
        <p class="text-teal-200 text-sm font-medium tracking-widest uppercase mb-4">
            Your Health, Our Priority
        </p>
        <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
            <?php bloginfo('name'); ?>
        </h1>
        <p class="text-xl md:text-2xl text-teal-100 mb-10 leading-relaxed">
            <?php bloginfo('description'); ?>
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo esc_url(home_url('/contact')); ?>"
                class="bg-teal-500 hover:bg-teal-400 text-white font-semibold px-8 py-4 rounded-full transition-colors duration-200 text-lg">
                ご予約・お問い合わせ
            </a>
            <a href="<?php echo esc_url(home_url('/about')); ?>"
                class="border-2 border-white text-white hover:bg-white hover:text-teal-800 font-semibold px-8 py-4 rounded-full transition-colors duration-200 text-lg">
                医院について
            </a>
        </div>
    </div>

    <!-- スクロール誘導 -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60 animate-bounce">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</section>
