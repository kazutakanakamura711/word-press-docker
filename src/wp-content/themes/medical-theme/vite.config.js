import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import path from "path";

export default defineConfig({
  root: ".",

  plugins: [tailwindcss()],

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
