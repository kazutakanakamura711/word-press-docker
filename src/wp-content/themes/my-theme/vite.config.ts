import { defineConfig, type Plugin } from "vite";
import path from "path";
import fs from "fs";
import { fileURLToPath } from "url";

const __dirname = path.dirname(fileURLToPath(import.meta.url));

// src/images/ → assets/images/ へコピーするカスタムプラグイン
function copyImagesPlugin(): Plugin {
  return {
    name: "copy-images",
    closeBundle() {
      const src = path.resolve(__dirname, "src/images");
      const dest = path.resolve(__dirname, "assets/images");
      if (!fs.existsSync(src)) return;
      fs.mkdirSync(dest, { recursive: true });
      for (const file of fs.readdirSync(src)) {
        fs.copyFileSync(path.join(src, file), path.join(dest, file));
      }
    },
  };
}

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
        main: path.resolve(__dirname, "src/ts/main.ts"),
      },
      output: {
        // CSSの出力先
        assetFileNames: "css/[name][extname]",
        // JSの出力先
        entryFileNames: "js/[name].js",
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

  plugins: [copyImagesPlugin()],
});
