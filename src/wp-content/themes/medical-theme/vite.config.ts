import { defineConfig, type Plugin } from "vite";
import tailwindcss from "@tailwindcss/vite";
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
  root: ".",

  plugins: [tailwindcss(), copyImagesPlugin()],

  build: {
    outDir: "assets",
    emptyOutDir: false,
    rollupOptions: {
      input: {
        style: path.resolve(__dirname, "src/css/style.css"),
        main: path.resolve(__dirname, "src/ts/main.ts"),
      },
      output: {
        assetFileNames: "css/[name][extname]",
        entryFileNames: "js/[name].js",
      },
    },
  },
});
