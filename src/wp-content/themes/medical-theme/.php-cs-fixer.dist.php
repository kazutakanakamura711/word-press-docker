<?php

/**
 * PHP CS Fixer 設定ファイル
 * ルールベース: @PSR12 + WordPress開発向け追加ルール
 * PHP 8.2 / php-cs-fixer ^3.0
 */

require_once __DIR__ . '/vendor/autoload.php';

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('node_modules')
    ->exclude('assets');

return (new PhpCsFixer\Config())
    ->setRules([
        // PSR-12 をベースにする
        '@PSR12' => true,

        // 配列の短縮構文 [] を強制（array() → []）
        'array_syntax' => ['syntax' => 'short'],

        // 二項演算子の前後に半角スペース
        'binary_operator_spaces' => ['default' => 'single_space'],

        // キャストの後ろに半角スペース
        'cast_spaces' => ['space' => 'single'],

        // 文字列結合演算子 . の前後に半角スペース
        'concat_space' => ['spacing' => 'one'],

        // 余分な空行を削除
        'no_extra_blank_lines' => ['tokens' => ['extra', 'use', 'curly_brace_block']],

        // 行末スペースを削除
        'no_trailing_whitespace' => true,

        // 未使用のuse宣言を削除
        'no_unused_imports' => true,

        // 空行内の余分なスペースを削除
        'no_whitespace_in_blank_line' => true,

        // useのインポートをアルファベット順にソート
        'ordered_imports' => ['sort_algorithm' => 'alpha'],

        // ファイル末尾に改行を追加
        'single_blank_line_at_eof' => true,

        // 複数行の配列末尾にカンマを追加
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],

        // ヨーダ記法を無効化（WordPress慣習とは異なるが可読性優先）
        'yoda_style' => false,
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');
