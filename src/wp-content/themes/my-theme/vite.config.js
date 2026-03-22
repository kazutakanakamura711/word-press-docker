import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
  // ルートをmy-themeに設定
  root: ".",

  build: {
    // 出力先
    outDir: "assets",
    // ビルド時にassetsフォルダを削除しない
    emptyOutDir: false,
    rollupOptions: {
      input: {
        style: path.resolve(__dirname, "src/scss/style.scss"),
      },
      output: {
        // CSSの出力先
        assetFileNames: "css/[name][extname]",
      },
    },
  },

  css: {
    preprocessorOptions: {
      scss: {
        // SCSSの警告を抑制
        quietDeps: true,
      },
    },
  },
});
